<?php

namespace App\Filters;


class ListingFilter extends Filter
{
    protected function filterSearch($value): void
    {
        $this->builder->whereAny(['title', 'desc'], 'like', "%{$value}%");
    }

    protected function filterUser($value): void
    {
        $this->builder->where('user_id', $value);
    }

    protected function filterTag($value): void
    {
        $this->builder->whereLike('tags', "%{$value}%");
    }

}
