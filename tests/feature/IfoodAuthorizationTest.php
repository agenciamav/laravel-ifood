<?php

namespace Agenciamav\LaravelIfood\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Agenciamav\LaravelIfood\Models\Merchant;
use Agenciamav\LaravelIfood\Tests\TestCase;
use Agenciamav\LaravelIfood\Tests\User;

class IfoodAuthorizationTokenTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	function authenticated_model_can_list_merchants()
	{
		$client = User::factory()->create();
		dd($client);

		// To make sure we don't start with a Merchant
		$this->assertCount(0, Merchant::all());

		// $client = User::factory()->create();

		// $response = $this->actingAs($client)->post(route('posts.store'), [
		// 	'title' => 'My first fake title',
		// 	'body'  => 'My first fake body',
		// ]);

		// $this->assertCount(1, Merchant::all());

		// tap(Merchant::first(), function ($post) use ($response, $client) {
		// 	$this->assertEquals('My first fake title', $post->title);
		// 	$this->assertEquals('My first fake body', $post->body);
		// 	$this->assertTrue($post->client->is($client));
		// 	$response->assertRedirect(route('posts.show', $post));
		// });
	}
}
