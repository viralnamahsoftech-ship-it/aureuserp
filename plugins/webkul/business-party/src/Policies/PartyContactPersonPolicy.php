<?php

namespace Webkul\BusinessParty\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Webkul\Security\Models\User;

class PartyContactPersonPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_business_party_party_contact_person');
    }

    public function view(User $user, Model $PartyContactPerson): bool
    {
        return $user->can('view_business_party_party_contact_person');
    }

    public function create(User $user): bool
    {
        return $user->can('create_business_party_party_contact_person');
    }

    public function update(User $user, Model $PartyContactPerson): bool
    {
        return $user->can('update_business_party_party_contact_person');
    }

    public function delete(User $user, Model $PartyContactPerson): bool
    {
        return $user->can('delete_business_party_party_contact_person');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_business_party_party_contact_person');
    }
}
