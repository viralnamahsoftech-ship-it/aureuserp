<?php

namespace Webkul\BusinessParty\Support;

use Illuminate\Support\Facades\DB;
use Webkul\BusinessMasters\Models\SerialNoMaster;

class SerialNumberGenerator
{
    public static function generate(string $documentType, ?int $companyId, ?int $branchId = null): string
    {
        return DB::transaction(function () use ($documentType, $companyId, $branchId): string {
            $serial = SerialNoMaster::query()
                ->where('doc_type', $documentType)
                ->when($companyId, fn ($query) => $query->where('company_id', $companyId))
                ->when($branchId, fn ($query) => $query->where('branch_id', $branchId))
                ->lockForUpdate()
                ->first();

            if (! $serial && $companyId) {
                $serial = SerialNoMaster::query()->create([
                    'company_id' => $companyId,
                    'branch_id'  => $branchId,
                    'doc_type'   => $documentType,
                    'prefix'     => $documentType,
                    'separator'  => '/',
                    'current_no' => 0,
                    'pad_length' => 5,
                    'is_active'  => true,
                ]);
            }

            $nextNumber = ($serial?->current_no ?? 0) + 1;

            if ($serial) {
                $serial->forceFill(['current_no' => $nextNumber])->save();
            }

            $prefix = $serial?->prefix ?: $documentType;
            $suffix = $serial?->suffix;
            $separator = $serial?->separator ?: '/';
            $padded = str_pad((string) $nextNumber, $serial?->pad_length ?: 5, '0', STR_PAD_LEFT);

            return implode($separator, array_filter([$prefix, $padded, $suffix], fn (?string $part): bool => filled($part)));
        });
    }
}
