<?php

namespace App\Models;

use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'assigned_to',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
        'priority' => TaskPriority::class,
        'due_date' => 'date',
    ];

    /**
     * Boot method to automatically set tenant_id
     */
    protected static function booted()
    {
        static::creating(function ($task) {
            if (tenancy()->initialized) {
                $task->tenant_id = tenant('id');
            }
        });

        static::addGlobalScope('tenant', function ($builder) {
            if (tenancy()->initialized) {
                $builder->where('tenant_id', tenant('id'));
            }
        });
    }

    /**
     * Get the project this task belongs to
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user assigned to this task
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the tenant
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
