<?php

namespace App\Policies;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FavoritePolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }


    public function view(User $user, Favorite $favorite): bool
    {
        return false;
    }


    public function create(User $user): bool
    {
        return false;
    }


    public function update(User $user, Favorite $favorite): bool
    {
        return false;
    }


    public function delete(User $user, Favorite $favorite): bool
    {
        return $user->id === $favorite->user_id;
    }


    public function restore(User $user, Favorite $favorite): bool
    {
        return false;
    }


    public function forceDelete(User $user, Favorite $favorite): bool
    {
        return false;
    }
}
