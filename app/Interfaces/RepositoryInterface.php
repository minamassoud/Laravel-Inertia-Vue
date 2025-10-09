<?php
declare(strict_types=1);

namespace App\Interfaces;

interface RepositoryInterface
{
    public function index(array $filters, int $pageCount);
}
