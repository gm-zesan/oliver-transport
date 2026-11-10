<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\User as SocialiteUser;

afterEach(function (): void {
    Mockery::close();
});

test('login, register, and homepage auth modal display continue with google button', function (): void {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Continue with Google')
        ->assertSee(route('auth.google.redirect'));

    $this->get(route('login'))
        ->assertOk()
        ->assertSee('Continue with Google')
        ->assertSee(route('auth.google.redirect'));

    $this->get(route('register'))
        ->assertOk()
        ->assertSee('Continue with Google')
        ->assertSee(route('auth.google.redirect'));
});

test('google redirect shows configuration notice when oauth credentials are missing', function (): void {
    config([
        'services.google.client_id' => null,
        'services.google.client_secret' => null,
    ]);

    $response = $this->get(route('auth.google'));

    $response->assertRedirect(route('login'))
        ->assertSessionHasErrors(['google']);
    $this->assertGuest();
});

test('google redirect initiates oauth flow when credentials are configured', function (): void {
    config([
        'services.google.client_id' => 'test-client-id',
        'services.google.client_secret' => 'test-client-secret',
    ]);

    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('redirect')
        ->twice()
        ->andReturn(redirect('https://accounts.google.com/o/oauth2/auth'));

    Socialite::shouldReceive('driver')
        ->with('google')
        ->andReturn($provider);

    $this->get(route('auth.google'))
        ->assertRedirect('https://accounts.google.com/o/oauth2/auth');

    $this->get(route('auth.google.redirect'))
        ->assertRedirect('https://accounts.google.com/o/oauth2/auth');
});

test('google callback handles user cancellation gracefully', function (): void {
    $response = $this->get(route('auth.google.callback', [
        'error' => 'access_denied',
        'error_description' => 'User cancelled Google consent screen.',
    ]));

    $response->assertRedirect(route('login'))
        ->assertSessionHasErrors(['google']);
    $this->assertGuest();
});

test('google callback handles socialite exceptions safely', function (): void {
    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('user')
        ->once()
        ->andThrow(new RuntimeException('Invalid OAuth state'));

    Socialite::shouldReceive('driver')
        ->with('google')
        ->andReturn($provider);

    $response = $this->get(route('auth.google.callback'));

    $response->assertRedirect(route('login'))
        ->assertSessionHasErrors(['google']);
    $this->assertGuest();
});

test('google callback fails cleanly if no email is provided', function (): void {
    $socialiteUser = new SocialiteUser;
    $socialiteUser->id = 'google-no-email-1';
    $socialiteUser->name = 'No Email User';
    $socialiteUser->email = null;

    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('user')->once()->andReturn($socialiteUser);
    Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

    $response = $this->get(route('auth.google.callback'));

    $response->assertRedirect(route('login'))
        ->assertSessionHasErrors(['google']);
    $this->assertGuest();
});

test('google callback registers new passenger user, regenerates session, and redirects to passenger bookings', function (): void {
    Event::fake([Registered::class]);

    $this->get(route('login'));
    $sessionBefore = session()->getId();

    $socialiteUser = new SocialiteUser;
    $socialiteUser->id = 'google-id-12345';
    $socialiteUser->name = 'Marie Dubois';
    $socialiteUser->email = 'Marie.Dubois@gmail.com';
    $socialiteUser->avatar = 'https://lh3.googleusercontent.com/a/avatar123';

    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('user')->once()->andReturn($socialiteUser);
    Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

    $response = $this->get(route('auth.google.callback'));

    $response->assertRedirect(route('passenger.bookings.index'));
    $this->assertAuthenticated();
    expect(session()->getId())->not->toBe($sessionBefore);

    $user = User::where('email', 'marie.dubois@gmail.com')->first();
    expect($user)->not->toBeNull()
        ->and($user->google_id)->toBe('google-id-12345')
        ->and($user->name)->toBe('Marie Dubois')
        ->and($user->role)->toBe('passenger')
        ->and($user->phone)->toBe('')
        ->and($user->avatar)->toBe('https://lh3.googleusercontent.com/a/avatar123')
        ->and($user->email_verified_at)->not->toBeNull();

    Event::assertDispatched(Registered::class);
});

test('google callback logs in existing user by google_id and populates missing avatar', function (): void {
    $existing = User::factory()->passenger()->create([
        'email' => 'alex@example.com',
        'google_id' => 'google-existing-999',
        'avatar' => null,
        'name' => 'Alexandre Cote',
    ]);

    $socialiteUser = new SocialiteUser;
    $socialiteUser->id = 'google-existing-999';
    $socialiteUser->name = 'Alexandre Cote';
    $socialiteUser->email = 'alex@example.com';
    $socialiteUser->avatar = 'https://lh3.googleusercontent.com/a/new-avatar';

    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('user')->once()->andReturn($socialiteUser);
    Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

    $response = $this->get(route('auth.google.callback'));

    $response->assertRedirect(route('passenger.bookings.index'));
    $this->assertAuthenticatedAs($existing);
    expect($existing->fresh()->avatar)->toBe('https://lh3.googleusercontent.com/a/new-avatar')
        ->and(User::count())->toBe(1);
});

test('google callback links google_id to existing email user case-insensitively and preserves role', function (): void {
    $existing = User::factory()->rider()->create([
        'email' => 'driver@pickmeroute.com',
        'google_id' => null,
        'email_verified_at' => null,
    ]);

    $socialiteUser = new SocialiteUser;
    $socialiteUser->id = 'google-linked-777';
    $socialiteUser->name = 'Driver PickMeRoute';
    $socialiteUser->email = 'Driver@PickMeRoute.com';
    $socialiteUser->avatar = 'https://lh3.googleusercontent.com/a/driver-pic';

    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('user')->once()->andReturn($socialiteUser);
    Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

    $response = $this->get(route('auth.google.callback'));

    $response->assertRedirect(route('rider.dashboard'));
    $this->assertAuthenticatedAs($existing);

    $fresh = $existing->fresh();
    expect($fresh->google_id)->toBe('google-linked-777')
        ->and($fresh->role)->toBe('rider')
        ->and($fresh->email_verified_at)->not->toBeNull()
        ->and(User::count())->toBe(1);
});

test('operator account signing in via google redirects to operator dashboard', function (): void {
    $operator = User::factory()->operator()->create([
        'email' => 'operator@pickmeroute.com',
        'google_id' => 'google-operator-1',
    ]);

    $socialiteUser = new SocialiteUser;
    $socialiteUser->id = 'google-operator-1';
    $socialiteUser->name = 'Operations Lead';
    $socialiteUser->email = 'operator@pickmeroute.com';

    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('user')->once()->andReturn($socialiteUser);
    Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

    $response = $this->get(route('auth.google.callback'));

    $response->assertRedirect(route('operator.dashboard'));
    $this->assertAuthenticatedAs($operator);
});

test('google login respects role authorization boundary when intended url is restricted', function (): void {
    $this->get(route('operator.dashboard'))->assertRedirect(route('login'));

    $socialiteUser = new SocialiteUser;
    $socialiteUser->id = 'google-passenger-scope-check';
    $socialiteUser->name = 'Standard Passenger';
    $socialiteUser->email = 'passenger.scope@example.com';

    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('user')->once()->andReturn($socialiteUser);
    Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

    $response = $this->get(route('auth.google.callback'));
    $response->assertRedirect(route('operator.dashboard'));

    $this->get(route('operator.dashboard'))->assertForbidden();
});

test('authenticated user is redirected away from google oauth guest routes', function (): void {
    $passenger = User::factory()->passenger()->create();

    $this->actingAs($passenger)
        ->get(route('auth.google.redirect'))
        ->assertRedirect(route('home'));
});
