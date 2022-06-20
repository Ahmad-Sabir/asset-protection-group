<?php

namespace Tests\Feature;

use Tests\TestCase;

class NotificationTest extends TestCase
{
    public function test_manage_notifications()
    {
        $this->actingAs($this->user)->get(route('admin.notifications'))->assertOk();
    }
}
