<?php

namespace Webkul\BusinessParty\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Webkul\BusinessParty\Models\BranchUserRight;

class BranchScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $user = Auth::user();

        if (! $user || $user->hasRole('super_admin')) {
            return;
        }

        if (! $model->getConnection()->getSchemaBuilder()->hasTable('bp_branch_user_rights')) {
            return;
        }

        $branchIds = BranchUserRight::query()
            ->where('user_id', $user->id)
            ->pluck('branch_id');

        if ($branchIds->isEmpty()) {
            $builder->whereRaw('1 = 0');

            return;
        }

        $builder->whereIn($model->getTable().'.branch_id', $branchIds);
    }
}
