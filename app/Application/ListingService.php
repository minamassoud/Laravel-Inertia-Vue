<?php
declare(strict_types=1);

namespace App\Application;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class ListingService
{

    public function __construct(
        protected RepositoryInterface $ResourceRepo
    )
    {
    }

    public function getListingsPaginated(array $filters = [], ?int $pageCount = null): Collection|LengthAwarePaginator
    {
        return $this->ResourceRepo->index($filters, $pageCount);
    }

}
