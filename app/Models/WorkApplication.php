<?php

namespace App\Models;

use App\Models\Work;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'expected_salary',
        'user_id',
        'work_id',
        'cv_path',
    ];
    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}