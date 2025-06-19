<?php

namespace App\Http\Controllers;

use App\Models\ProjectIssue;
use App\Models\SoftwareUser;
use App\Models\TeamAssignment;
use Illuminate\Http\Request;

class ProjectIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!session('user_id')) {
            return redirect('/login');
        }

        $userRole = session('user_role');
        $userId = session('user_id');

        if ($userRole === 'requirement_gatherer') {
            $issues = ProjectIssue::where('created_by', $userId)->with('assignedTo')->get();
        } elseif ($userRole === 'team_lead') {
            $issues = ProjectIssue::with('assignedTo', 'creator')->get();
        } elseif ($userRole === 'developer') {
            $issues = ProjectIssue::where('assigned_to', $userId)->with('creator')->get();
        } elseif ($userRole === 'qa_specialist') {
            $issues = ProjectIssue::whereIn('status', ['completed', 'testing', 'approved', 'rejected'])->with('assignedTo', 'creator')->get();
        } else {
            $issues = collect();
        }

        return view('issues.index', compact('issues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!session('user_id') || session('user_role') !== 'requirement_gatherer') {
            return redirect('/dashboard');
        }

        return view('issues.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!session('user_id') || session('user_role') !== 'requirement_gatherer') {
            return redirect('/dashboard');
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'priority' => 'required|in:low,medium,high,urgent',
            'estimated_hours' => 'nullable|integer|min:1',
            'due_date' => 'nullable|date|after:today',
        ]);

        $issue = new ProjectIssue();
        $issue->title = $request->title;
        $issue->description = $request->description;
        $issue->priority = $request->priority;
        $issue->status = ProjectIssue::STATUS_NEW;
        $issue->created_by = session('user_id');
        $issue->estimated_hours = $request->estimated_hours;
        $issue->due_date = $request->due_date;
        $issue->save();

        return redirect('/issues')->with('success', 'Issue created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectIssue $projectIssue)
    {
        if (!session('user_id')) {
            return redirect('/login');
        }

        $projectIssue->load('creator', 'assignedTo', 'teamAssignments.assignedBy');
        return view('issues.show', compact('projectIssue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectIssue $projectIssue)
    {
        if (!session('user_id')) {
            return redirect('/login');
        }

        $userRole = session('user_role');
        $userId = session('user_id');

        // Only requirement gatherer can edit issues they created
        if ($userRole !== 'requirement_gatherer' || $projectIssue->created_by !== $userId) {
            return redirect('/issues');
        }

        return view('issues.edit', compact('projectIssue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectIssue $projectIssue)
    {
        if (!session('user_id')) {
            return redirect('/login');
        }

        $userRole = session('user_role');
        $userId = session('user_id');

        // Only requirement gatherer can edit issues they created
        if ($userRole !== 'requirement_gatherer' || $projectIssue->created_by !== $userId) {
            return redirect('/issues');
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'priority' => 'required|in:low,medium,high,urgent',
            'estimated_hours' => 'nullable|integer|min:1',
            'due_date' => 'nullable|date|after:today',
        ]);

        $projectIssue->update($request->all());
        return redirect('/issues')->with('success', 'Issue updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectIssue $projectIssue)
    {
        if (!session('user_id')) {
            return redirect('/login');
        }

        $userRole = session('user_role');
        $userId = session('user_id');

        // Only requirement gatherer can delete issues they created
        if ($userRole !== 'requirement_gatherer' || $projectIssue->created_by !== $userId) {
            return redirect('/issues');
        }

        $projectIssue->delete();
        return redirect('/issues')->with('success', 'Issue deleted successfully');
    }

    // Assign issue to developer (Team Lead only)
    public function assign(Request $request, ProjectIssue $projectIssue)
    {
        if (!session('user_id') || session('user_role') !== 'team_lead') {
            return redirect('/dashboard');
        }

        $request->validate([
            'developer_id' => 'required|exists:software_users,id',
            'notes' => 'nullable|string',
        ]);

        $developer = SoftwareUser::find($request->developer_id);
        
        if ($developer->role !== 'developer') {
            return back()->with('error', 'Selected user is not a developer');
        }

        $projectIssue->assigned_to = $request->developer_id;
        $projectIssue->status = ProjectIssue::STATUS_ASSIGNED;
        $projectIssue->save();

        // Create team assignment record
        TeamAssignment::create([
            'issue_id' => $projectIssue->id,
            'user_id' => $request->developer_id,
            'assigned_by' => session('user_id'),
            'assigned_at' => now(),
            'notes' => $request->notes,
        ]);

        return redirect('/issues')->with('success', 'Issue assigned successfully');
    }

    // Update issue status (Developer actions)
    public function updateStatus(Request $request, ProjectIssue $projectIssue)
    {
        if (!session('user_id')) {
            return redirect('/login');
        }

        $userRole = session('user_role');
        $userId = session('user_id');

        $request->validate([
            'status' => 'required|in:in_progress,completed',
            'actual_hours' => 'nullable|integer|min:1',
        ]);

        // Developer can update their assigned issues
        if ($userRole === 'developer' && $projectIssue->assigned_to === $userId) {
            if ($request->status === 'in_progress' && $projectIssue->canBeStarted()) {
                $projectIssue->status = ProjectIssue::STATUS_IN_PROGRESS;
            } elseif ($request->status === 'completed' && $projectIssue->canBeCompleted()) {
                $projectIssue->status = ProjectIssue::STATUS_COMPLETED;
                $projectIssue->actual_hours = $request->actual_hours;
            }
            $projectIssue->save();
        }

        return redirect('/issues')->with('success', 'Issue status updated successfully');
    }

    // QA actions
    public function qaAction(Request $request, ProjectIssue $projectIssue)
    {
        if (!session('user_id') || session('user_role') !== 'qa_specialist') {
            return redirect('/dashboard');
        }

        $request->validate([
            'action' => 'required|in:approve,reject',
            'qa_notes' => 'nullable|string',
        ]);

        if ($request->action === 'approve') {
            $projectIssue->status = ProjectIssue::STATUS_APPROVED;
        } else {
            $projectIssue->status = ProjectIssue::STATUS_REJECTED;
        }

        $projectIssue->save();

        return redirect('/issues')->with('success', 'Issue ' . $request->action . 'd successfully');
    }
}
