<?php

namespace Webkul\BusinessParty\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Webkul\Security\Models\User;

class PartyTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_business_party_party_type');
    }

    public function view(User $user, Model $PartyType): bool
    {
        return $user->can('view_business_party_party_type');
    }

    public function create(User $user): bool
    {
        return $user->can('create_business_party_party_type');
    }

    public function update(User $user, Model $PartyType): bool
    {
        return $user->can('update_business_party_party_type');
    }

    public function delete(User $user, Model $PartyType): bool
    {
        return $user->can('delete_business_party_party_type');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_business_party_party_type');
    }
}
