<?php

namespace Webkul\BusinessMasters\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Webkul\Security\Models\User;

class CityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_business_masters_city');
    }

    public function view(User $user, Model $City): bool
    {
        return $user->can('view_business_masters_city');
    }

    public function create(User $user): bool
    {
        return $user->can('create_business_masters_city');
    }

    public function update(User $user, Model $City): bool
    {
        return $user->can('update_business_masters_city');
    }

    public function delete(User $user, Model $City): bool
    {
        return $user->can('delete_business_masters_city');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_business_masters_city');
    }
}
