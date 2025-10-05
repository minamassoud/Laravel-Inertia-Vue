<?php

namespace App\Services;

use App\Filters\ListingFilter;
use App\Models\Listing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ListingService
{

    public function __construct(?Listing $listing = null) { }

    public function getListingsPaginated(array $withFilters, ?int $withPageCount = 6): LengthAwarePaginator
    {
        return Listing::with('user')
            ->whereHas('user', fn(Builder $q) => $q->where('role', '!=', 'suspended'))
            ->where(fn($q) => ListingFilter::apply($q, $withFilters))
            ->where('approved', true)
                      ->latest()
            ->paginate($withPageCount)
                      ->withQueryString();
    }

}
