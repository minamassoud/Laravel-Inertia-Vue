<?php
declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    public function __construct(
        protected Builder $builder,
        protected array $filters,
    ) {
    }

    public static function apply(Builder $builder, array $filter): Builder
    {
        return (new static($builder, $filter))();
    }

    public function __invoke(): Builder
    {
        foreach ($this->filters as $key => $value) {
            $method = "filter".ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this->builder;
    }

}
