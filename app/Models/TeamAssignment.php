<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamAssignment extends Model
{
    protected $fillable = [
        'issue_id',
        'user_id',
        'assigned_by',
        'assigned_at',
        'notes',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    // Relationships
    public function issue()
    {
        return $this->belongsTo(ProjectIssue::class, 'issue_id');
    }

    public function user()
    {
        return $this->belongsTo(SoftwareUser::class, 'user_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(SoftwareUser::class, 'assigned_by');
    }
}
