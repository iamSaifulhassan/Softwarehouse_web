<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class SoftwareUser extends Model
{
    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
        'role',
        'team_lead_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function teamLead()
    {
        return $this->belongsTo(SoftwareUser::class, 'team_lead_id');
    }

    public function teamMembers()
    {
        return $this->hasMany(SoftwareUser::class, 'team_lead_id');
    }

    public function assignedIssues()
    {
        return $this->hasMany(ProjectIssue::class, 'assigned_to');
    }

    public function createdIssues()
    {
        return $this->hasMany(ProjectIssue::class, 'created_by');
    }

    public function teamAssignments()
    {
        return $this->hasMany(TeamAssignment::class, 'user_id');
    }

    // Helper methods
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function verifyPassword($password)
    {
        return Hash::check($password, $this->password);
    }

    public function isRole($role)
    {
        return $this->role === $role;
    }

    public function isTeamLead()
    {
        return $this->role === 'team_lead';
    }

    public function isDeveloper()
    {
        return $this->role === 'developer';
    }

    public function isQA()
    {
        return $this->role === 'qa_specialist';
    }

    public function isRequirementGatherer()
    {
        return $this->role === 'requirement_gatherer';
    }
}
