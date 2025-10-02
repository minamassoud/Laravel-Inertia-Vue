<?php

namespace App\Services;

use App\Filters\ListingFilter;
use App\Models\Listing;
use Illuminate\Pagination\LengthAwarePaginator;

class ListingService
{

    public function __construct(?Listing $listing = null) { }

    public function getListingsPaginated(array $withFilters, ?int $withPageCount = 6): LengthAwarePaginator
    {
        return Listing::with('user')
            ->where(fn($q) => ListingFilter::apply($q, $withFilters))
                      ->latest()
            ->paginate($withPageCount)
                      ->withQueryString();
    }

}
