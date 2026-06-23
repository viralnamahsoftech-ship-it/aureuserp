<?php

namespace Webkul\BusinessParty\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Webkul\Security\Models\User;

class UomPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_business_party_uom');
    }

    public function view(User $user, Model $Uom): bool
    {
        return $user->can('view_business_party_uom');
    }

    public function create(User $user): bool
    {
        return $user->can('create_business_party_uom');
    }

    public function update(User $user, Model $Uom): bool
    {
        return $user->can('update_business_party_uom');
    }

    public function delete(User $user, Model $Uom): bool
    {
        return $user->can('delete_business_party_uom');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_business_party_uom');
    }
}
