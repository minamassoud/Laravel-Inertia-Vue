<?php


use App\Models\Listing;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->user = User::factory()->create();

});

it('can render the Listing page', function () {
    $this->get(route('home'))
         ->assertOk()
         ->assertInertia(fn(AssertableInertia $page) => $page->component('Home'));
});

it('returns the listings in a lengthAwarePaginator', function () {
    Listing::factory()->for($this->user)->count(20)->create();

    $this->get(route('home', ['page' => 1]))
         ->assertInertia(fn(AssertableInertia $page) => $page
             ->where('listings.total', 20)
             ->where('listings.current_page', 1)
             ->where('listings.per_page', 6)
             ->has('listings.data', 6)
             ->etc()
         );
});

it('can return filters if present in the request', function () {
    $this->get(route('home', ['page' => 1, 'tag' => 'dev', 'user' => '1']))
         ->assertInertia(fn(AssertableInertia $page) => $page
             ->has('filters', 2)
             ->etc()
         );
});
