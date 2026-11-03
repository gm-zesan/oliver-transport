<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\LazyLoadingViolationException;

test('strict lazy loading prevention is enabled in testing and non-production environments', function () {
    expect(Model::preventsLazyLoading())->toBeTrue();
});

test('accessing an un-eager-loaded relationship on queried models throws a LazyLoadingViolationException', function () {
    User::resolveRelationUsing('lazyRelation', function (User $user) {
        return $user->hasMany(User::class, 'id', 'id');
    });

    // Create multiple users to activate N+1 prevention during query hydration
    User::factory()->count(2)->create();

    $users = User::all();

    expect(fn () => $users->first()->lazyRelation)
        ->toThrow(LazyLoadingViolationException::class);
});
