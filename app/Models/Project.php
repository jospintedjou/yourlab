<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => ProjectStatus::class,
    ];

    /**
     * Boot method to automatically set tenant_id
     */
    protected static function booted()
    {
        static::creating(function ($project) {
            if (tenancy()->initialized) {
                $project->tenant_id = tenant('id');
            }
        });

        static::addGlobalScope('tenant', function ($builder) {
            if (tenancy()->initialized) {
                $builder->where('tenant_id', tenant('id'));
            }
        });
    }

    /**
     * Get tasks for this project
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the tenant
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
