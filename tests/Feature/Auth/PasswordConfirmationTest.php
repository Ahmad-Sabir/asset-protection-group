<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    protected const PASSWORD_ROUTE = 'confirm-password';

    public function test_confirm_password_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(self::PASSWORD_ROUTE);

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(self::PASSWORD_ROUTE, [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(self::PASSWORD_ROUTE, [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
