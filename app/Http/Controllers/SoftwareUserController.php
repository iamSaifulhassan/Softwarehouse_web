<?php

namespace App\Http\Controllers;

use App\Models\SoftwareUser;
use Illuminate\Http\Request;

class SoftwareUserController extends Controller
{
    // Authentication methods
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if (empty($username) || empty($password)) {
            return redirect('/login');
        }

        $user = SoftwareUser::where('username', $username)
                           ->where('is_active', true)
                           ->first();

        if ($user && $user->verifyPassword($password)) {
            // Simple redirect based on role
            $role = str_replace('_', '-', $user->role);
            return redirect('/dashboard/' . $role);
        }

        return redirect('/login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        $full_name = $request->input('full_name');
        $role = $request->input('role');

        if (empty($username) || empty($email) || empty($password) || empty($full_name) || empty($role)) {
            return redirect('/register');
        }

        // Check if user already exists
        $existingUser = SoftwareUser::where('username', $username)
                                   ->orWhere('email', $email)
                                   ->first();

        if ($existingUser) {
            return redirect('/register');
        }

        $user = new SoftwareUser();
        $user->username = $username;
        $user->email = $email;
        $user->password = $password; // Will be hashed in model
        $user->full_name = $full_name;
        $user->role = $role;
        $user->is_active = true;
        $user->save();

        return redirect('/login');
    }

    public function logout()
    {
        return redirect('/login');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = SoftwareUser::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teamLeads = SoftwareUser::where('role', 'team_lead')->get();
        return view('users.create', compact('teamLeads'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:software_users',
            'email' => 'required|email|unique:software_users',
            'password' => 'required|min:6',
            'full_name' => 'required',
            'role' => 'required|in:requirement_gatherer,developer,qa_specialist,team_lead',
        ]);

        SoftwareUser::create($request->all());
        return redirect('/users')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SoftwareUser $softwareUser)
    {
        return view('users.show', compact('softwareUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SoftwareUser $softwareUser)
    {
        $teamLeads = SoftwareUser::where('role', 'team_lead')->get();
        return view('users.edit', compact('softwareUser', 'teamLeads'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SoftwareUser $softwareUser)
    {
        $request->validate([
            'username' => 'required|unique:software_users,username,' . $softwareUser->id,
            'email' => 'required|email|unique:software_users,email,' . $softwareUser->id,
            'full_name' => 'required',
            'role' => 'required|in:requirement_gatherer,developer,qa_specialist,team_lead',
        ]);

        $softwareUser->update($request->all());
        return redirect('/users')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SoftwareUser $softwareUser)
    {
        $softwareUser->delete();
        return redirect('/users')->with('success', 'User deleted successfully');
    }

    // Dashboard methods for each role
    public function requirementAnalystDashboard()
    {
        $recentIssues = ProjectIssue::orderBy('created_at', 'desc')->take(5)->get();
        return view('dashboard.requirements-analyst', compact('recentIssues'));
    }

    public function teamLeadDashboard()
    {
        $unassignedIssues = ProjectIssue::where('status', 'new')->get();
        $developers = SoftwareUser::where('role', 'developer')->where('is_active', true)->get();
        $teamMembers = SoftwareUser::where('role', '!=', 'team_lead')->where('is_active', true)->get();
        
        return view('dashboard.team-lead', compact('unassignedIssues', 'developers', 'teamMembers'));
    }

    public function developerDashboard()
    {
        // For now, get all issues that are assigned or in progress
        $issues = ProjectIssue::whereIn('status', ['assigned', 'in_progress'])->get();
        $totalTasks = ProjectIssue::count();
        $completedTasks = ProjectIssue::where('status', 'completed')->count();
        $inProgressTasks = ProjectIssue::where('status', 'in_progress')->count();
        
        return view('dashboard.developer', compact('issues', 'totalTasks', 'completedTasks', 'inProgressTasks'));
    }

    public function qaSpecialistDashboard()
    {
        $testingTasks = ProjectIssue::where('status', 'completed')->get();
        return view('dashboard.qa-specialist', compact('testingTasks'));
    }
}
