<?php

namespace Webkul\BusinessParty\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Webkul\BusinessParty\Models\Scopes\BranchScope;

trait HasBranchScope
{
    protected static function bootHasBranchScope(): void
    {
        static::addGlobalScope(new BranchScope);
    }

    public function scopeForBranch(Builder $query, int $branchId): Builder
    {
        return $query->where($this->getTable().'.branch_id', $branchId);
    }
}
