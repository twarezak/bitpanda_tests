<?php declare(strict_types=1);


namespace Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function get_active_users_from_austria(): void
    {
        $response = $this->get('/api/users', [
            'filter' => [
                'country' => 'Austria',
                'active' => true,
                ],
        ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'email' => 'alex@tempmail.com'
        ]);
        $response->assertJsonFragment([
            'email' => 'Taaaaaaa@test.com'
        ]);
        $response->assertJsonMissing([
            'email' => 'maria@tempmail.com'
        ]);
    }

    /** @test */
    public function update_user_details_if_exists(): void
    {
        $response = $this
            ->put(route('users-detail.update', [1]), [
                'first_name' => 'Jan',
                'last_name' => 'Kowalski',
                'phone_number' => '1234567890',
                "country_id" => 2,
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('user_details', [
            'user_id' => 1,
            'first_name' => 'Jan',
            'last_name' => 'Kowalski',
            'phone_number' => '1234567890',
            'citizenship_country_id' => 2,
        ]);
    }

    /** @test */
    public function update_user_details_return_error_when_not_exists(): void
    {
        $response = $this
            ->put(route('users-detail.update', [2]), [
                'first_name' => 'Jan',
                'last_name' => 'Kowalski',
                'phone_number' => '1234567890',
                "country_id" => 2,
            ]);

        $response->assertStatus(Response::HTTP_CONFLICT);
    }

    /** @test */
    public function delete_user_if_details_not_exists(): void
    {
        $response = $this
            ->delete(route('users.delete', [2]),);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('users', [ 'id' => 2]);
    }

    /** @test */
    public function not_allowed_delete_user_if_details_exists(): void
    {
        $response = $this
            ->delete(route('users.delete', [1]),);

        $response->assertStatus(Response::HTTP_CONFLICT);

        $this->assertDatabaseHas('users', [ 'id' => 1]);
    }
}
