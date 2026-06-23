<?php

namespace Webkul\BusinessMasters\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Webkul\Security\Models\User;

class TaxTemplatePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_business_masters_tax_template');
    }

    public function view(User $user, Model $TaxTemplate): bool
    {
        return $user->can('view_business_masters_tax_template');
    }

    public function create(User $user): bool
    {
        return $user->can('create_business_masters_tax_template');
    }

    public function update(User $user, Model $TaxTemplate): bool
    {
        return $user->can('update_business_masters_tax_template');
    }

    public function delete(User $user, Model $TaxTemplate): bool
    {
        return $user->can('delete_business_masters_tax_template');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_business_masters_tax_template');
    }
}
