<?php

namespace App\Policies;

use App\Models\HutSurvey;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HutSurveyPolicy
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
     * @param  \App\Models\HutSurvey  $hutSurvey
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, HutSurvey $hutSurvey)
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
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HutSurvey  $hutSurvey
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, HutSurvey $hutSurvey)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HutSurvey  $hutSurvey
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, HutSurvey $hutSurvey)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HutSurvey  $hutSurvey
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, HutSurvey $hutSurvey)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HutSurvey  $hutSurvey
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, HutSurvey $hutSurvey)
    {
        return false;
    }
}
