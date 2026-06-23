<?php

namespace Webkul\BusinessParty\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Webkul\Security\Models\User;

class BranchUserRightPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_business_party_branch_user_right');
    }

    public function view(User $user, Model $BranchUserRight): bool
    {
        return $user->can('view_business_party_branch_user_right');
    }

    public function create(User $user): bool
    {
        return $user->can('create_business_party_branch_user_right');
    }

    public function update(User $user, Model $BranchUserRight): bool
    {
        return $user->can('update_business_party_branch_user_right');
    }

    public function delete(User $user, Model $BranchUserRight): bool
    {
        return $user->can('delete_business_party_branch_user_right');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_business_party_branch_user_right');
    }
}
