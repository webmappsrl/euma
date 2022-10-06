<?php

namespace App\Policies;

use App\Models\Trail;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrailPolicy
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
        if ($user->is_admin == true || $user->member_id) {
            return true;
        } 

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trail  $trail
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Trail $trail)
    {
        if ($user->is_admin == true || $trail->member->id == $user->member_id) {
            return true;
        } 

        return false;
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
     * @param  \App\Models\Trail  $trail
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Trail $trail)
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
     * @param  \App\Models\Trail  $trail
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Trail $trail)
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
     * @param  \App\Models\Trail  $trail
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Trail $trail)
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
     * @param  \App\Models\Trail  $trail
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Trail $trail)
    {
        if ($user->is_admin == true) {
            return true;
        } 

        return false;
    }
}
