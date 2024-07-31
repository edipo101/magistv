<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Account;

class Plan extends Model
{
    use HasFactory;

    public function accounts(): HasMany
    {
    	return $this->hasMany('Account::class');
    }
}
