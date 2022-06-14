<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventTest extends TestCase
{
    use WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
     public function test_it_stores_new_event() 
     {
        // Grab event oraganizer account
        $user = User::where('email', 'kemendikbud@test.com')->first();

        $this->actingAs($user);

        $response = $this->post(route('events.store'), [
            'name' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(1000, 1000000),
            'schedule' => json_encode([$this->faker->date(), $this->faker->date()]),
            'location' => $this->faker->city(),
            'location_description' => $this->faker->sentence(2),
            'rules' => $this->faker->paragraph,
        ]);

        $response->assertSuccessful();
     }

     public function test_it_updates_event() 
     {
         // Grab event oraganizer account
         $user = User::where('email', 'kemendikbud@test.com')->first();

         $this->actingAs($user);

         $event = Event::latest()->first();

         $response = $this->put(route('events.update', $event->id), [
            'name' => $event->name,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(1000, 1000000),
            'schedule' => json_encode([$this->faker->date(), $this->faker->date()]),
            'location' => $event->location,
            'location_description' => $this->faker->sentence(3),
            'rules' => $this->faker->paragraph,
        ]);

        $response->assertSuccessful();
     }

     public function test_it_delete_event() 
     {
        $user = User::where('email', 'kemendikbud@test.com')->first();

        $this->actingAs($user);

        $event = Event::latest()->first();

        $response = $this->delete(route('events.destroy', $event->id));

        $response->assertSuccessful();
     }
}
