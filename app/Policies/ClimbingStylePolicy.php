<?php

namespace App\Policies;

use App\Models\ClimbingStyle;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClimbingStylePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClimbingStyle  $climbingStyle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ClimbingStyle $climbingStyle)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->is_admin == true) {
            return true;
        } 

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClimbingStyle  $climbingStyle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ClimbingStyle $climbingStyle)
    {
        if ($user->is_admin == true) {
            return true;
        } 

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClimbingStyle  $climbingStyle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ClimbingStyle $climbingStyle)
    {
        if ($user->is_admin == true) {
            return true;
        } 

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClimbingStyle  $climbingStyle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ClimbingStyle $climbingStyle)
    {
        if ($user->is_admin == true) {
            return true;
        } 

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClimbingStyle  $climbingStyle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ClimbingStyle $climbingStyle)
    {
        if ($user->is_admin == true) {
            return true;
        } 

        return false;
    }
}
