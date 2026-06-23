<?php

namespace Webkul\BusinessMasters\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Webkul\Security\Models\User;

class DocWiseSerialNoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_business_masters_doc_wise_serial_no');
    }

    public function view(User $user, Model $DocWiseSerialNo): bool
    {
        return $user->can('view_business_masters_doc_wise_serial_no');
    }

    public function create(User $user): bool
    {
        return $user->can('create_business_masters_doc_wise_serial_no');
    }

    public function update(User $user, Model $DocWiseSerialNo): bool
    {
        return $user->can('update_business_masters_doc_wise_serial_no');
    }

    public function delete(User $user, Model $DocWiseSerialNo): bool
    {
        return $user->can('delete_business_masters_doc_wise_serial_no');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_business_masters_doc_wise_serial_no');
    }
}
