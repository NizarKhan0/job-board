<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employer;
use App\Models\WorkApplication;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'location',
        'salary',
        'experience',
        'description',
        'category',
    ];
    public static array $experience = ['entry', 'intermediate', 'senior'];
    public static array $category = [
        'IT',
        'Finance',
        'Sales',
        'Marketing',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function workApplications(): HasMany
    {
        return $this->hasMany(WorkApplication::class);
    }

    public function hasUserApplied(Authenticatable|User|int $user): bool
    {
        //untuk dapat job id current job model
        return $this->where('id', $this->id)
            ->whereHas(
                'workApplications',
                fn($query) => $query->where('user_id',  '=', $user->id ??$user)
         )->exists();
         //untuk cek user tu ada apply kat job ni ke belum
    }

    public function canUserApply(User $user)
    {
        if ($user->employer) {
            // Prevent user from applying to their own company's job
            return $this->employer_id !== $user->employer->id;
        }
        return true; // Allow if user does not have an employer
    }

    public function scopeFilter(Builder|QueryBuilder $query, array $filters): Builder|QueryBuilder
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('employer', function ($query) use ($search) {
                        $query->where('company_name', 'like', '%' . $search . '%');
                    });
                    // kena buat dekat sini kalau dia nested realation(maksdunya gabung table)
            });
        })->when($filters['min_salary'] ?? null, function ($query, $minSalary) {
            $query->where('salary', '>=', $minSalary);
        })->when($filters['max_salary'] ?? null, function ($query, $maxSalary) {
            $query->where('salary', '<=', $maxSalary);
        })->when($filters['experience'] ?? null, function ($query, $experience) {
            $query->where('experience', $experience);
        })->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('category', $category);
        });
    }

}
