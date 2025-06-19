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
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = SoftwareUser::where('username', $request->username)
                           ->where('is_active', true)
                           ->first();

        if ($user && $user->verifyPassword($request->password)) {
            session(['user_id' => $user->id, 'user_role' => $user->role]);
            return redirect('/dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:software_users',
            'email' => 'required|email|unique:software_users',
            'password' => 'required|min:6|confirmed',
            'full_name' => 'required',
            'role' => 'required|in:requirement_gatherer,developer,qa_specialist,team_lead',
        ]);

        $user = new SoftwareUser();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->password; // Will be hashed in model
        $user->full_name = $request->full_name;
        $user->role = $request->role;
        $user->is_active = true;
        $user->save();

        session(['user_id' => $user->id, 'user_role' => $user->role]);
        return redirect('/dashboard')->with('success', 'Registration successful');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }

    public function dashboard()
    {
        if (!session('user_id')) {
            return redirect('/login');
        }

        $user = SoftwareUser::find(session('user_id'));
        $role = session('user_role');

        return view('dashboard.' . $role, compact('user'));
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
}
