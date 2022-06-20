<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use App\Models\Company;
use Illuminate\Support\Str;

class AuthenticationTest extends TestCase
{
    protected const LOGIN_ROUTE = 'login';

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get(self::LOGIN_ROUTE);

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();
        $this->get('admin')->assertRedirect();

        $response = $this->post(self::LOGIN_ROUTE, [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
        $this->get('admin')->assertOk();
        $this->post('logout')->assertRedirect();
        User::where('id', $user->id)->update(['deactivate_at' => now()]);
        $user = User::find($user->id);
        $user->update(['deactivate_at' => now()]);
        $this->actingAs($user)->get('admin')->assertRedirect();
        $company = Company::factory()->create();
        $company->update(['deactivate_at' => now()]);
        $user->company_id = $company->id;
        $this->actingAs($user)->get('admin')->assertRedirect();
        $this->actingAs($user)->get(self::LOGIN_ROUTE)->assertRedirect();
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();
        $this->post(self::LOGIN_ROUTE, [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_api_throttle_limit()
    {
        Route::get('/test', fn() => "OK")->middleware('throttle:api');

        for ($i=0; $i < 8; $i++) {
            $this->post(self::LOGIN_ROUTE, [
                'email' => 'wrongemail@gmail.com',
                'password' => 'wrong-password',
            ]);
        }

        $this->get('/test')->assertOk();
    }
}
