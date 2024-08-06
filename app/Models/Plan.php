<?php

namespace App\Models;

use App\Models\Account;
use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    public function accounts(): HasMany
    {
    	return $this->hasMany('Account::class');
    }

    public function devices(): HasMany
    {
    	return $this->hasMany('Device::class');
    }
}
