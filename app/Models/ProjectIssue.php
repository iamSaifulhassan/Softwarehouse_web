<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectIssue extends Model
{
    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'created_by',
        'assigned_to',
        'estimated_hours',
        'actual_hours',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
        'estimated_hours' => 'integer',
        'actual_hours' => 'integer',
    ];

    // Status constants
    const STATUS_NEW = 'new';
    const STATUS_ASSIGNED = 'assigned';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_TESTING = 'testing';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    // Priority constants
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_URGENT = 'urgent';

    // Relationships
    public function creator()
    {
        return $this->belongsTo(SoftwareUser::class, 'created_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(SoftwareUser::class, 'assigned_to');
    }

    public function teamAssignments()
    {
        return $this->hasMany(TeamAssignment::class, 'issue_id');
    }

    // Helper methods
    public function getStatusColor()
    {
        return match($this->status) {
            self::STATUS_NEW => 'blue',
            self::STATUS_ASSIGNED => 'yellow',
            self::STATUS_IN_PROGRESS => 'orange',
            self::STATUS_COMPLETED => 'green',
            self::STATUS_TESTING => 'purple',
            self::STATUS_APPROVED => 'green',
            self::STATUS_REJECTED => 'red',
            default => 'gray'
        };
    }

    public function getPriorityColor()
    {
        return match($this->priority) {
            self::PRIORITY_LOW => 'green',
            self::PRIORITY_MEDIUM => 'yellow',
            self::PRIORITY_HIGH => 'orange',
            self::PRIORITY_URGENT => 'red',
            default => 'gray'
        };
    }

    public function canBeAssigned()
    {
        return in_array($this->status, [self::STATUS_NEW, self::STATUS_REJECTED]);
    }

    public function canBeStarted()
    {
        return $this->status === self::STATUS_ASSIGNED;
    }

    public function canBeCompleted()
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function canBeTested()
    {
        return $this->status === self::STATUS_COMPLETED;
    }
}
