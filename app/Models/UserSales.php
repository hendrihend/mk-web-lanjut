<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSales extends Model
{
    use HasFactory;

    protected $table = 'user_sales';

    protected $fillable = [
        'user_id',
        'sales_name',
        'email',
        'phone',
        'region',
        'quota',
        'achievement',
        'commission_rate',
        'status',
        'notes',
    ];

    protected $casts = [
        'quota' => 'decimal:2',
        'achievement' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi dengan User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk filter berdasarkan status aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk filter berdasarkan region
     */
    public function scopeByRegion($query, $region)
    {
        return $query->where('region', $region);
    }

    /**
     * Scope untuk mencari berdasarkan nama sales
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('sales_name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');
    }

    /**
     * Hitung persentase achievement
     */
    public function getAchievementPercentageAttribute()
    {
        if ($this->quota == 0) {
            return 0;
        }
        return round(($this->achievement / $this->quota) * 100, 2);
    }

    /**
     * Hitung komisi
     */
    public function getCommissionAttribute()
    {
        return round($this->achievement * ($this->commission_rate / 100), 2);
    }
}
