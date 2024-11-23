<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeatherTrigger;
use Illuminate\Auth\Access\HandlesAuthorization;

class TriggerPolicy
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
        return $user->is_admin;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeatherTrigger  $weatherTrigger
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, WeatherTrigger $weatherTrigger)
    {
        return $user->id === $weatherTrigger->user_id || $user->is_admin;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeatherTrigger  $weatherTrigger
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, WeatherTrigger $weatherTrigger)
    {
        return $user->id === $weatherTrigger->user_id || $user->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeatherTrigger  $weatherTrigger
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, WeatherTrigger $weatherTrigger)
    {
        return $user->id === $weatherTrigger->user_id || $user->is_admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeatherTrigger  $weatherTrigger
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, WeatherTrigger $weatherTrigger)
    {
        //
    }
}
