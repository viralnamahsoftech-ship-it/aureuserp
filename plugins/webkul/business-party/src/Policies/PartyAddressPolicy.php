<?php

namespace Webkul\BusinessParty\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Webkul\Security\Models\User;

class PartyAddressPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_business_party_party_address');
    }

    public function view(User $user, Model $PartyAddress): bool
    {
        return $user->can('view_business_party_party_address');
    }

    public function create(User $user): bool
    {
        return $user->can('create_business_party_party_address');
    }

    public function update(User $user, Model $PartyAddress): bool
    {
        return $user->can('update_business_party_party_address');
    }

    public function delete(User $user, Model $PartyAddress): bool
    {
        return $user->can('delete_business_party_party_address');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_business_party_party_address');
    }
}
