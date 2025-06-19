<?php

namespace App\Http\Controllers;

use App\Models\ProjectIssue;
use App\Models\SoftwareUser;
use Illuminate\Http\Request;

class ProjectIssueController extends Controller
{
    // List all issues
    public function index()
    {
        $issues = ProjectIssue::all();
        return view('issues.index', compact('issues'));
    }

    // Show create form
    public function create()
    {
        return view('issues.create');
    }

    // Store new issue (for requirement gatherer)
    public function store(Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $priority = $request->input('priority');

        if (empty($title) || empty($description) || empty($priority)) {
            return redirect('/dashboard/requirements-analyst');
        }

        $issue = new ProjectIssue();
        $issue->title = $title;
        $issue->description = $description;
        $issue->priority = $priority;
        $issue->status = 'new';
        $issue->created_by = 1; // For now, using a default user
        $issue->save();

        return redirect('/dashboard/requirements-analyst');
    }

    // Assign issue to developer (for team lead)
    public function assign(Request $request)
    {
        $issueId = $request->input('issue_id');
        $developerId = $request->input('developer_id');
        
        if (empty($issueId) || empty($developerId)) {
            return redirect('/dashboard/team-lead');
        }

        $issue = ProjectIssue::find($issueId);
        if ($issue) {
            $issue->assigned_to = $developerId;
            $issue->status = 'assigned';
            $issue->save();
        }

        return redirect('/dashboard/team-lead');
    }
    
    // Start working on issue (for developer)
    public function start(Request $request)
    {
        $issueId = $request->input('issue_id');
        
        if (empty($issueId)) {
            return redirect('/dashboard/developer');
        }

        $issue = ProjectIssue::find($issueId);
        if ($issue && $issue->status == 'assigned') {
            $issue->status = 'in_progress';
            $issue->save();
        }

        return redirect('/dashboard/developer');
    }

    // Mark issue as complete (for developer)
    public function complete(Request $request)
    {
        $issueId = $request->input('issue_id');
        
        if (empty($issueId)) {
            return redirect('/dashboard/developer');
        }

        $issue = ProjectIssue::find($issueId);
        if ($issue && $issue->status == 'in_progress') {
            $issue->status = 'completed';
            $issue->save();
        }

        return redirect('/dashboard/developer');
    }

    // Approve issue (for QA)
    public function approve(Request $request)
    {
        $issueId = $request->input('issue_id');
        
        if (empty($issueId)) {
            return redirect('/dashboard/qa-specialist');
        }

        $issue = ProjectIssue::find($issueId);
        if ($issue && $issue->status == 'completed') {
            $issue->status = 'approved';
            $issue->save();
        }

        return redirect('/dashboard/qa-specialist');
    }

    // Reject issue (for QA)
    public function reject(Request $request)
    {
        $issueId = $request->input('issue_id');
        
        if (empty($issueId)) {
            return redirect('/dashboard/qa-specialist');
        }

        $issue = ProjectIssue::find($issueId);
        if ($issue && $issue->status == 'completed') {
            $issue->status = 'in_progress';
            $issue->save();
        }

        return redirect('/dashboard/qa-specialist');
    }
}
