<?php

namespace Webkul\BusinessMasters\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Webkul\Security\Models\User;

class ReferenceMasterPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_business_masters_reference_master');
    }

    public function view(User $user, Model $ReferenceMaster): bool
    {
        return $user->can('view_business_masters_reference_master');
    }

    public function create(User $user): bool
    {
        return $user->can('create_business_masters_reference_master');
    }

    public function update(User $user, Model $ReferenceMaster): bool
    {
        return $user->can('update_business_masters_reference_master');
    }

    public function delete(User $user, Model $ReferenceMaster): bool
    {
        return $user->can('delete_business_masters_reference_master');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_business_masters_reference_master');
    }
}
