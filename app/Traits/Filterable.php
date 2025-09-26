<?php

namespace App\Traits;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

trait Filterable
{
    protected function applyCommonFilters($query, Request $request, $searchFields = [])
    {
        // Search
        if ($request->filled('search') && !empty($searchFields)) {
            $search = $request->input('search');
            $query->where(function ($q) use ($searchFields, $search) {
                foreach ($searchFields as $index => $field) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $q->{$method}($field, 'LIKE', "%{$search}%");
                }
            });
        }
        // Export (ví dụ)
        if ($request->has('export')) {
            return $query->get(); // hoặc gọi Export service
        }

        return $query;
    }
}
