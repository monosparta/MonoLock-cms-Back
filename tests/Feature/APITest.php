<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class APITest extends TestCase
{
    static $token = "";
    static $userId = "";
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_login_returns_a_successful_response()
    {
        $response = $this->post('/api/login', ['mail' => '002@example.com', 'password' => 'root']);
        $response->assertStatus(200);
        $this::$token = $response->getData()->message->token;
    }

    public function test_the_getLocker_returns_a_successful_response()
    {
        $response = $this->withHeaders(["token" => $this::$token])->get('/api/locker');
        $response->assertStatus(200);
    }
    // public function test_the_unlock_returns_a_successful_response()
    // {
    //     $response = $this->withHeaders(["token" => $this::$token])->post('/api/unlock', [
    //         "lockerNo" => "00",
    //         "description" => "test"
    //     ]);
    //     $response->assertStatus(200);
    // }

    public function test_the_addUser_returns_a_successful_response()
    {
        $response = $this->withHeaders(["token" => $this::$token])->post('/api/user', [
            "lockerNo" => "00",
            'name' => "test",
            'phone' => "0910237485",
            'mail' => "test@example.com",
            'cardId' => "8564365895",
        ]);
        $response->assertStatus(200);
        $this::$userId = $response->getData()->id;
    }

    public function test_the_getRecord_returns_a_successful_response()
    {
        $response = $this->withHeaders(["token" => $this::$token])->get('/api/record/00');
        $response->assertStatus(200);
    }


    public function test_the_updateUser_returns_a_successful_response()
    {
        $response = $this->withHeaders(["token" => $this::$token])->patch('/api/user/' . $this::$userId, [
            'name' => "test2",
            'phone' => "0910237487",
            'mail' => "test2@example.com",
            'cardId' => "4332680586",
        ]);
        $response->assertStatus(200);
    }

    public function test_the_deleteUser_returns_a_successful_response()
    {
        $response = $this->withHeaders(["token" => $this::$token])->delete('/api/user/' . $this::$userId);
        $response->assertStatus(200);
    }

    public function test_the_logout_returns_a_successful_response()
    {
        $response = $this->withHeaders(["token" => $this::$token])->get('/api/logout');
        $response->assertStatus(200);
    }
}
