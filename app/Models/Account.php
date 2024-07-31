<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['active'];

    public function plan(): BelongsTo
    {
    	return $this->belongsTo(Plan::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    protected function daysElapsed(): Attribute
    {
    	return Attribute::make(
    		get: fn() => Carbon::create($this->started_at)->diffInDays(now()),
    	);
    }

    protected function daysRemaining(): Attribute
    {
    	return Attribute::make(
    		get: fn() => Carbon::now()->diffInDays($this->finished_at),
    	);
    }

    protected function totalDays(): Attribute
    {
    	return Attribute::make(
    		get: fn() => Carbon::create($this->started_at)->diffInDays($this->finished_at),
    	);
    }
    
    protected function progress(): Attribute
    {
    	return Attribute::make(
    		get: fn() => number_format(($this->days_elapsed/($this->total_days) * 100) / 10) * 10,
    	);
    }


}
