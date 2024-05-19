<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Work;
use Illuminate\Auth\Access\Response;

class WorkPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function viewAnyEmployer(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Work $work): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->employer !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Work $work): bool|Response
    {
        //untuk cek current user authenticate dgn current user ID
        if($work->employer->user_id !== $user->id) {
            return false;
        }

        if($work->workApplications()->count() > 0) {
            return Response::deny('Cannot change the job with applications');
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Work $work): bool
    {
        return $work->employer->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Work $work): bool
    {
        return $work->employer->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Work $work): bool
    {
        return $work->employer->user_id === $user->id;
    }

    public function apply(User $user, Work $work): bool
    {
        //ni custom $setup condtiton dekat model
        return !$work->hasUserApplied($user);
    }

    // public function canUserApply(User $user, Work $work)
    // {
    //     if ($user->employer) {
    //         // Prevent user from applying to their own company's job
    //         return $work->employer_id !== $user->employer->id;
    //     }
    //     return true; // Allow if user does not have an employer
    // }
    //yg atas ni takde custom message dia gun default unauthorized

    public function canUserApply(User $user, Work $work)
    {
        if ($user->employer) {
            // Prevent user from applying to their own company's job
            if ($work->employer_id === $user->employer->id) {
                return Response::deny('You cannot apply to jobs from your own post!.');
            }
        }
        return true; // Allow if user does not have an employer
    }

}