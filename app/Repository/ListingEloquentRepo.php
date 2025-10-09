<?php
declare(strict_types=1);

namespace App\Repository;

use App\Filters\ListingFilter;
use App\Interfaces\RepositoryInterface;
use App\Models\Listing;
use Illuminate\Database\Eloquent\Builder;

class ListingEloquentRepo implements RepositoryInterface
{

    public function index(?array $filters, ?int $pageCount)
    {
        return Listing::with('user')
                      ->whereHas('user', fn(Builder $q) => $q->where('role', '!=', 'suspended'))
                      ->when(!empty($filters), fn($q) => ListingFilter::apply($q, $filters))
                      ->where('approved', true)
                      ->latest()
                      ->when($pageCount,
                          fn($q) => $q->paginate($pageCount)->withQueryString(),
                          fn($q) => $q->get()
                      );
    }

}
