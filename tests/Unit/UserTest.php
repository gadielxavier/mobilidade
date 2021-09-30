<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class UserTest extends TestCase
{	
    /** @test */
    public function check_if_users_columns_is_correct()
    {
    	$user = new User;

    	$expected = [
    		'name',
    		'email',
    		'password'
    	];

    	$arrayCompared = array_diff($expected, $user->getFillable());

        $this->assertEquals(0, count($arrayCompared));
    }

    /** @test */
    public function check_if_user_is_created()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
    }
}
