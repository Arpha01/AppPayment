<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_checkout_new_ticket() 
    {
        $user = User::where('email', 'kemendikbud@test.com')->first();

        $this->actingAs($user);

        $event = Event::inRandomOrder()->first();

        $response = $this->post(route('checkout'), [
            'event_id' => $event->id,
            'amount' => $this->faker->numberBetween(1, 3),
            'payment_method' => $this->faker->randomElement(['bri', 'bca', 'bni', 'indomaret', 'alfamart', 'gopay']),
            'ticket_schedules' => '2020-05-01',
            'ticket_schedules' => '2020-06-01'
        ]);

        $response->assertSuccessful();
    }
}
