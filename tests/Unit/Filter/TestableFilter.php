<?php

namespace Tests\Unit\Filter;

use App\Filters\Filter;

class TestableFilter extends Filter
{
    protected function filterTest($value): void
    {
        $this->builder->where('test_field', $value);
    }

    protected function filterAnother($value): void
    {
        $this->builder->where('another_field', 'like', "%{$value}%");
    }
}
