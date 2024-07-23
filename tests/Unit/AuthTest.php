<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Actions\AuthAction;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Mockery;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authAction = new AuthAction();
    }

    public function test_handle_successful_authentication()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $request = Mockery::mock(LoginRequest::class);
        $request->shouldReceive('validated')
            ->andReturn(['email' => 'test@example.com', 'password' => 'password123']);

        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => 'test@example.com', 'password' => 'password123'])
            ->andReturn(true);

        Auth::shouldReceive('user')
            ->once()
            ->andReturn($user);


        $response = $this->authAction->handle($request);

        $this->assertNotNull($response);
        $this->assertEquals('Bearer', $response['type']);
        $this->assertInstanceOf(UserResource::class, $response['user']);
    }

    public function test_handle_failed_authentication()
    {
        $request = Mockery::mock(LoginRequest::class);
        $request->shouldReceive('validated')
            ->andReturn(['email' => 'test@example.com', 'password' => 'wrong-password']);

        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => 'test@example.com', 'password' => 'wrong-password'])
            ->andReturn(false);

        $response = $this->authAction->handle($request);

        $this->assertNull($response);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
