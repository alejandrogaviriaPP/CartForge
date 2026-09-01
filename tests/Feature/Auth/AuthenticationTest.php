<?php

use App\Mail\LoginCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('regular users are sent to the verification code screen after login', function () {
    Mail::fake();

    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertGuest();
    $response->assertRedirect(route('login.verify', absolute: false));
    Mail::assertSent(LoginCodeMail::class);
});

test('users can authenticate with a valid verification code', function () {
    Mail::fake();

    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $code = null;
    Mail::assertSent(function (LoginCodeMail $mail) use (&$code) {
        $code = $mail->code;

        return true;
    });

    $response = $this->post(route('login.verify.check'), ['code' => $code]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('home', absolute: false));
});

test('invalid verification codes are rejected', function () {
    Mail::fake();

    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->post(route('login.verify.check'), ['code' => '000777'])
        ->assertSessionHasErrors(['code']);

    $this->assertGuest();
});

test('the admin account logs in directly without a code', function () {
    Mail::fake();

    $user = User::factory()->create(['email' => 'admin@cartforge.com']);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('home', absolute: false));
    Mail::assertNothingSent();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
