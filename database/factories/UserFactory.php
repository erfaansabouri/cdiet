<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition (): array {
        $faker = $this->faker;

        return [
            'premium_expires_at' => $faker->randomElement([
                                                              $faker->dateTimeBetween('now' , '+3 months'),
                                                              null ,
                                                          ]) ,
            'full_name' => $faker->firstName() ,
            'email' => $faker->unique()->safeEmail ,
            'phone_number' => $faker->phoneNumber() ,
            'sex' => $faker->randomElement([
                                               'مرد' ,
                                               'زن' ,
                                           ]) ,
            'pregnant_status' => $faker->randomElement([
                                                           true ,
                                                           false ,
                                                       ]) ,
            'lactation_status' => $faker->randomElement([
                                                            true ,
                                                            false ,
                                                        ]) ,
            'birthday' => $faker->date ,
            'exercise' => $faker->randomElement(array_values(User::EXERCISES)) ,
            'height' => $faker->numberBetween(150 , 200) ,
            // Adjust the height range as needed
            'weight' => $faker->numberBetween(50 , 100) ,
            // Adjust the weight range as needed
            'goal' => $faker->randomElement(array_values(User::GOALS)) ,
            'register_completed_at' => $faker->dateTimeBetween('-1 year' , 'now') ,
            'terms_accepted_at' => $faker->dateTimeBetween('-1 year' , 'now') ,
            'created_at' => $faker->dateTimeBetween('-1 year' , 'now') ,
            'updated_at' => $faker->dateTimeBetween('-1 year' , 'now') ,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function registerUncompleted (): static {
        return $this->state(fn ( array $attributes ) => [
            'register_completed_at' => null ,
        ]);
    }
}
