<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarketingUser extends Model
{
    use HasFactory;

    protected $table = 'marketing_users';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
        'department',
        'territory',
        'status',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope untuk filter berdasarkan status aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk filter berdasarkan department
     */
    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    /**
     * Scope untuk filter berdasarkan territory
     */
    public function scopeByTerritory($query, $territory)
    {
        return $query->where('territory', $territory);
    }
}
