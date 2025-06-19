<?php

namespace App\Http\Controllers;

use App\Models\SoftwareUser;
use App\Models\ProjectIssue;
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
            return redirect('/login')->with('error', 'Username and password are required');
        }

        $user = SoftwareUser::where('username', $username)
                           ->where('is_active', true)
                           ->first();

        if ($user && $user->verifyPassword($password)) {
            // Map roles to dashboard routes
            $roleDashboardMap = [
                'requirement_gatherer' => 'requirements-analyst',
                'developer' => 'developer',
                'qa_specialist' => 'qa-specialist',
                'team_lead' => 'team-lead'
            ];
            $dashboardRoute = $roleDashboardMap[$user->role] ?? 'developer';
            // No session management
            return redirect('/dashboard/' . $dashboardRoute);
        }

        return redirect('/login')->with('error', 'Invalid credentials. Please check your username and password.');
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
        $password_confirmation = $request->input('password_confirmation');
        $full_name = $request->input('full_name');
        $role = $request->input('role');

        // Basic validation
        if (empty($username) || empty($email) || empty($password) || empty($full_name) || empty($role)) {
            return redirect('/register')->with('error', 'All fields are required');
        }

        // Password confirmation check
        if ($password !== $password_confirmation) {
            return redirect('/register')->with('error', 'Passwords do not match.');
        }

        // Password length check
        if (strlen($password) < 6) {
            return redirect('/register')->with('error', 'Password must be at least 6 characters.');
        }

        // Check if user already exists
        $existingUser = SoftwareUser::where('username', $username)
                                   ->orWhere('email', $email)
                                   ->first();

        if ($existingUser) {
            return redirect('/register')->with('error', 'Username or email already exists.');
        }

        $user = new SoftwareUser();
        $user->username = $username;
        $user->email = $email;
        $user->password = $password; // Will be hashed in model
        $user->full_name = $full_name;
        $user->role = $role;
        $user->is_active = true;
        $user->save();

        return redirect('/login')->with('success', 'Account created successfully! Please sign in.');
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
    public function dashboard()
    {
        // This is a general dashboard redirect - for now redirect to login
        return redirect('/login');
    }

    public function requirementsAnalystDashboard()
    {
        $recentIssues = ProjectIssue::orderBy('created_at', 'desc')->take(5)->get();
        return view('dashboard.requirements-analyst', compact('recentIssues'));
    }

    public function teamLeadDashboard()
    {
        // Use fallback logic, no session
        $currentTeamLead = SoftwareUser::where('role', 'team_lead')->where('is_active', true)->first();
        $teamLeads = SoftwareUser::where('role', 'team_lead')->where('is_active', true)->get();
        if (!$currentTeamLead) {
            return view('dashboard.team-lead', [
                'unassignedIssues' => [],
                'developers' => [],
                'teamMembers' => []
            ]);
        }
        // Auto-assign unassigned developers evenly to team leads
        $unassignedDevs = SoftwareUser::where('role', 'developer')->where('is_active', true)->whereNull('team_lead_id')->get();
        if ($unassignedDevs->count() > 0 && $teamLeads->count() > 0) {
            $devs = SoftwareUser::where('role', 'developer')->where('is_active', true)->get();
            $devsPerLead = intdiv($devs->count(), $teamLeads->count());
            $extra = $devs->count() % $teamLeads->count();
            $devIndex = 0;
            foreach ($teamLeads as $i => $lead) {
                $count = $devsPerLead + ($i < $extra ? 1 : 0);
                $leadDevs = $devs->slice($devIndex, $count);
                foreach ($leadDevs as $dev) {
                    $dev->team_lead_id = $lead->id;
                    $dev->save();
                }
                $devIndex += $count;
            }
        }
        $myTeam = SoftwareUser::where('role', 'developer')
            ->where('is_active', true)
            ->where('team_lead_id', $currentTeamLead->id)
            ->get();
        foreach ($myTeam as $dev) {
            $dev->assignedIssues = $dev->assignedIssues()->get();
            $dev->active_tasks_count = $dev->assignedIssues()->whereIn('status', ['assigned', 'in_progress'])->count();
        }
        $unassignedIssues = ProjectIssue::where('status', 'new')->get();
        return view('dashboard.team-lead', [
            'unassignedIssues' => $unassignedIssues,
            'developers' => $myTeam,
            'teamMembers' => $myTeam
        ]);
    }

    public function developerDashboard()
    {
        // Show all assigned/in progress issues for all developers (no session/user filtering)
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

    // Profile CRUD for all users (stateless: user identified by username/email in POST)
    public function profile(Request $request)
    {
        // For demo: get user by ?username=... or ?email=... (since no session)
        $username = $request->query('username');
        $email = $request->query('email');
        $user = null;
        if ($username) {
            $user = SoftwareUser::where('username', $username)->first();
        } elseif ($email) {
            $user = SoftwareUser::where('email', $email)->first();
        }
        if (!$user) {
            return view('profile.index', ['user' => (object)[
                'full_name' => '', 'username' => '', 'email' => '', 'role' => ''
            ]])->with('error', 'User not found.');
        }
        return view('profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $username = $request->input('username');
        $email = $request->input('email');
        $full_name = $request->input('full_name');
        $password = $request->input('password');
        $user = SoftwareUser::where('username', $username)->orWhere('email', $email)->first();
        if (!$user) {
            return redirect('/profile?username=' . urlencode($username))->with('error', 'User not found.');
        }
        $user->full_name = $full_name;
        $user->email = $email;
        if (!empty($password)) {
            if (strlen($password) < 6) {
                return redirect('/profile?username=' . urlencode($username))->with('error', 'Password must be at least 6 characters.');
            }
            $user->password = $password;
        }
        $user->save();
        return redirect('/profile?username=' . urlencode($username))->with('success', 'Profile updated successfully!');
    }

    public function deleteProfile(Request $request)
    {
        $username = $request->input('username');
        $email = $request->input('email');
        $user = SoftwareUser::where('username', $username)->orWhere('email', $email)->first();
        if (!$user) {
            return redirect('/profile?username=' . urlencode($username))->with('error', 'User not found.');
        }
        $user->delete();
        return redirect('/register')->with('success', 'Account deleted.');
    }
}
