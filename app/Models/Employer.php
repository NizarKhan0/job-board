<?php

namespace App\Models;

use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employer extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
    ];

    public function works():HasMany
    {
        return $this->hasMany(Work::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}