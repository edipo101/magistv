<?php

namespace App\Models;

use App\Models\Account;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'account_id', 'plan_id', 'started_at', 'finished_at', 'active'];

    public function account(): BelongsTo
    {
    	return $this->BelongsTo(Account::class);
    }

    public function plan(): BelongsTo
    {
    	return $this->BelongsTo(Plan::class);
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
