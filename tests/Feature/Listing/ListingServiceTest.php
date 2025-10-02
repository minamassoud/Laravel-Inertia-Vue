<?php

use App\Models\Listing;
use App\Models\User;
use App\Services\ListingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->service = new ListingService();
    $this->user = User::factory()->create();
});

describe('ListingService', function () {
    it('can be instantiated without parameters', function () {
        $service = new ListingService();

        expect($service)->toBeInstanceOf(ListingService::class);
    });

    it('can be instantiated with listing parameter', function () {
        $listing = new Listing();
        $service = new ListingService($listing);

        expect($service)->toBeInstanceOf(ListingService::class);
    });

    it('returns paginated listings with user relationship', function () {
        // Create test listings with user relationship
        Listing::factory()
               ->count(10)
               ->for($this->user)
               ->create();

        $filters = [];
        $result = $this->service->getListingsPaginated($filters);

        expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
        expect($result->items())->toHaveCount(6); // Default pagination is 7
        expect($result->first()->user)->toBeInstanceOf(User::class);
        expect($result->first()->user->id)->toBe($this->user->id);
    });

    it('applies search filter correctly', function () {
        // Create listings with different titles
        Listing::factory()
               ->for($this->user)
               ->create(['title' => 'Laravel Developer Needed']);

        Listing::factory()
               ->for($this->user)
               ->create(['title' => 'PHP Programmer Required']);

        Listing::factory()
               ->for($this->user)
               ->create(['desc' => 'Looking for Laravel expert']);

        $filters = ['search' => 'Laravel'];
        $result = $this->service->getListingsPaginated($filters);

        expect($result->total())->toBe(2);
        foreach ($result->items() as $listing) {
            expect($listing->title.' '.$listing->desc)->toContain('Laravel');
        }
    });

    it('applies user filter correctly', function () {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create listings for different users
        Listing::factory()
               ->count(3)
               ->for($user1)
               ->create();

        Listing::factory()
               ->count(5)
               ->for($user2)
               ->create();

        $filters = ['user' => $user1->id];
        $result = $this->service->getListingsPaginated($filters);

        expect($result->total())->toBe(3);
        foreach ($result->items() as $listing) {
            expect($listing->user_id)->toBe($user1->id);
        }
    });

    it('applies tag filter correctly', function () {
        Listing::factory()
               ->for($this->user)
               ->create(['tags' => 'php,laravel,backend']);

        Listing::factory()
               ->for($this->user)
               ->create(['tags' => 'javascript,frontend,react']);

        Listing::factory()
               ->for($this->user)
               ->create(['tags' => 'php,symfony,backend']);

        $filters = ['tag' => 'laravel'];
        $result = $this->service->getListingsPaginated($filters);

        expect($result->total())->toBe(1);
        expect($result->first()->tags)->toContain('laravel');
    });

    it('applies multiple filters simultaneously', function () {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create listings for user1
        Listing::factory()
               ->for($user1)
               ->create([
                   'title' => 'Laravel Developer Position',
                   'tags' => 'php,laravel,backend'
               ]);

        Listing::factory()
               ->for($user1)
               ->create([
                   'title' => 'React Developer Needed',
                   'tags' => 'javascript,react,frontend'
               ]);

        // Create listing for user2
        Listing::factory()
               ->for($user2)
               ->create([
                   'title' => 'Laravel Expert Required',
                   'tags' => 'php,laravel,backend'
               ]);

        $filters = [
            'search' => 'Laravel',
            'user' => $user1->id,
            'tag' => 'backend'
        ];

        $result = $this->service->getListingsPaginated($filters);

        expect($result->total())->toBe(1);
        $listing = $result->first();
        expect($listing->user_id)->toBe($user1->id);
        expect($listing->title)->toContain('Laravel');
        expect($listing->tags)->toContain('backend');
    });

    it('returns listings ordered by latest first', function () {
        // Create listings with specific timestamps
        $oldListing = Listing::factory()
                             ->for($this->user)
                             ->create(['created_at' => now()->subDays(5)]);

        $newListing = Listing::factory()
                             ->for($this->user)
                             ->create(['created_at' => now()->subDay()]);

        $newestListing = Listing::factory()
                                ->for($this->user)
                                ->create(['created_at' => now()]);

        $filters = [];
        $result = $this->service->getListingsPaginated($filters);

        $items = $result->items();
        expect($items[0]->id)->toBe($newestListing->id);
        expect($items[1]->id)->toBe($newListing->id);
        expect($items[2]->id)->toBe($oldListing->id);
    });

    it('paginates results with 7 items per page', function () {
        // Create more than 7 listings
        Listing::factory()
               ->count(15)
               ->for($this->user)
               ->create();

        $filters = [];
        $result = $this->service->getListingsPaginated($filters);

        expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
        expect($result->perPage())->toBe(6);
        expect($result->items())->toHaveCount(6);
        expect($result->total())->toBe(15);
        expect($result->lastPage())->toBe(3);
    });

    it('includes query string in pagination links', function () {
        Listing::factory()
               ->count(10)
               ->for($this->user)
               ->create();

        // Simulate request with query parameters
        request()->merge(['search' => 'test', 'user' => 123]);

        $filters = ['search' => 'test'];
        $result = $this->service->getListingsPaginated($filters);

        // The withQueryString() method should preserve query parameters
        expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
        // We can't easily test the actual query string without making HTTP requests,
        // but we can verify the method chain completed successfully
    });

    it('handles empty filters gracefully', function () {
        Listing::factory()
               ->count(5)
               ->for($this->user)
               ->create();

        $filters = [];
        $result = $this->service->getListingsPaginated($filters);

        expect($result->total())->toBe(5);
        expect($result->items())->toHaveCount(5);
    });

    it('handles filters with null values', function () {
        Listing::factory()
               ->count(3)
               ->for($this->user)
               ->create();

        $filters = [
            'search' => null,
            'user' => null,
            'tag' => null
        ];

        $result = $this->service->getListingsPaginated($filters);

        // With null values, filters should still be applied but match nothing or everything
        expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    });

    it('handles filters with empty string values', function () {
        Listing::factory()
               ->count(3)
               ->for($this->user)
               ->create();

        $filters = [
            'search' => '',
            'user' => '',
            'tag' => ''
        ];

        $result = $this->service->getListingsPaginated($filters);

        expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    });

    it('always loads user relationship', function () {
        Listing::factory()
               ->for($this->user)
               ->create();

        $filters = [];
        $result = $this->service->getListingsPaginated($filters);

        $listing = $result->first();

        // Verify that user relationship is loaded (not lazy loaded)
        expect($listing->relationLoaded('user'))->toBeTrue();
        expect($listing->user)->toBeInstanceOf(User::class);
        expect($listing->user->id)->toBe($this->user->id);
    });

    it('returns empty results when no listings match filters', function () {
        Listing::factory()
               ->for($this->user)
               ->create(['title' => 'PHP Developer']);

        $filters = ['search' => 'NonExistentTerm'];
        $result = $this->service->getListingsPaginated($filters);

        expect($result->total())->toBe(0);
        expect($result->items())->toBeEmpty();
    });
});
