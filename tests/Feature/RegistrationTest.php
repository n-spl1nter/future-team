<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testWrongEmailFormat()
    {
        $response = $this->post('/api/v1/register', ['email' => 'k']);
        $response->assertStatus(400);
    }
}
