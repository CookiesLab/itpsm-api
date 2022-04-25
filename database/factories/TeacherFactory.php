<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Teacher::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'id' => $this->faker->unique()->randomNumber(1),
      'name' => $this->faker->firstName,
      'last_name' => $this->faker->lastName,
      'birth_date' => $this->faker->dateTimeBetween('-30 years', '-18 years'),
      'nit' => $this->faker->numerify('############'),
      'dui' => $this->faker->numerify('#########'),
      'isss_number' => $this->faker->numerify('#########'),
      'nup_number' => $this->faker->numerify('#########'),
      'email' => $this->faker->email,
      'genre' => $this->faker->randomElement($array = array ('M','F')),
      'address' => $this->faker->address,
      'phone_number' => '7' . $this->faker->randomNumber(3, true) . '-' . $this->faker->randomNumber(4, true),
      'home_phone_number' => '2' . $this->faker->randomNumber(3, true) . '-' . $this->faker->randomNumber(4, true),
      'municipality_id' => 3,
      'department_id' => 14,
      'country_id' => 1,
      'status_id' => 1,
    ];
  }
}
