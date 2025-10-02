<?php

namespace App\Services;

use App\Filters\ListingFilter;
use App\Models\Listing;
use Illuminate\Pagination\LengthAwarePaginator;

class ListingService
{

    public function __construct(?Listing $listing = null) { }

    public function getListings(array $filters): LengthAwarePaginator
    {
        return Listing::with('user')
                      ->where(fn($q) => ListingFilter::apply($q, $filters))
                      ->latest()
                      ->paginate(7)
                      ->withQueryString();
    }

}
