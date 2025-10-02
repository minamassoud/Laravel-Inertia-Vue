<?php

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Tests\Unit\Filter\TestableFilter;

describe('Filter Abstract Class', function () {
    beforeEach(function () {
        $this->builder = Mockery::mock(Builder::class);
        $this->filters = ['test' => 'value', 'another' => 'search'];
    });

    it('can be instantiated through concrete implementation', function () {
        $filter = new TestableFilter($this->builder, $this->filters);

        expect($filter)->toBeInstanceOf(Filter::class);
        expect($filter)->toBeInstanceOf(TestableFilter::class);
    });

    it('applies filters correctly when statically called', function () {
        $this->builder->shouldReceive('where')
                      ->once()
                      ->with('test_field', 'value')
                      ->andReturnSelf();

        $this->builder->shouldReceive('where')
                      ->once()
                      ->with('another_field', 'like', '%search%')
                      ->andReturnSelf();

        $builder = TestableFilter::apply($this->builder, $this->filters);

        expect($builder)->toBe($this->builder);
    });

    it('applies filters correctly when invoked', function () {
        $this->builder->shouldReceive('where')
                      ->once()
                      ->with('test_field', 'value')
                      ->andReturnSelf();

        $this->builder->shouldReceive('where')
                      ->once()
                      ->with('another_field', 'like', '%search%')
                      ->andReturnSelf();

        $filter = new TestableFilter($this->builder, $this->filters);
        $builder = $filter();

        expect($builder)->toBe($this->builder);
    });

    it('ignores unrecognized filter', function () {
        $this->builder->shouldNotReceive('where')
                      ->with('nonexistent_field', 'value')
                      ->andReturnSelf();

        $invalidFilters = ['nonexistent' => 'value'];
        $filter = new TestableFilter($this->builder, $invalidFilters);

        expect(method_exists($filter, 'filterNonexistent'))->toBeFalsy();
        expect($filter())->toBe($this->builder);
    });

    it('returns builder unchanged when no filters provided', function () {
        $filters = [];

        $result = TestableFilter::apply($this->builder, $filters);

        expect($result)->toBe($this->builder);
    });

});
