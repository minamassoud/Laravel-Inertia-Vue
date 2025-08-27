<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;


it('can render the registration page', function () {
    $this->get(route('register'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Auth/Register'));
});

it('can register a new user successfully', function () {
    Event::fake([Registered::class]);

    $userData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $this->post('/register', $userData)
        ->assertRedirect(route('home'));

    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    $user = User::where('email', 'john@example.com')->first();
    expect($user)->not()->toBeNull();
    expect(Hash::check('password123', $user->password))->toBeTrue();

    Event::assertDispatched(Registered::class, function (Registered $event) use ($user) {
        return $event->user->is($user);
    });
});

it('validates required fields during registration', function () {
    $this->from('/register')
        ->post('/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
            'password_confirmation' => 'different',
        ])
        ->assertRedirect('/register')
        ->assertSessionHasErrors(['name', 'email', 'password']);

    $this->assertGuest();
    $this->assertDatabaseCount('users', 0);
});

it('enforces email uniqueness', function () {
    $existingUser = User::factory()->create(['email' => 'existing@example.com']);

    $this->from('/register')
        ->post('/register', [
            'name' => 'New User',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertRedirect('/register')
        ->assertSessionHasErrors(['email']);

    expect(User::count())->toBe(1);
    $this->assertGuest();
});

it('requires matching password confirmation', function () {
    $this->from('/register')
        ->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ])
        ->assertRedirect('/register')
        ->assertSessionHasErrors(['password']);

    $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    $this->assertGuest();
});
