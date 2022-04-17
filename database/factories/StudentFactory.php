<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StudentFactory extends Factory
{

  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Student::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'carnet' => '00' . $this->faker->unique()->randomNumber(4) . '22',
      'name' => $this->faker->firstName,
      'last_name' => $this->faker->lastName,
      'email' => $this->faker->email,
      'birth_date' => $this->faker->dateTimeBetween('-30 years', '-18 years'),
      'address' => $this->faker->address,
      'phone_number' => '7' . $this->faker->randomNumber(3, true) . '-' . $this->faker->randomNumber(4, true),
      'home_phone_number' => '2' . $this->faker->randomNumber(3, true) . '-' . $this->faker->randomNumber(4, true),
      'gender' => $this->faker->randomElement($array = array ('M','F')),
      'relationship' => $this->faker->randomElement($array = array('A', 'B', 'C')),
      'status' => $this->faker->randomElement($array = array('A', 'X', 'R')),
      'blood_type' => $this->faker->randomElement($array = array('A', 'B', 'AB', 'O')),
      'mother_name' => $this->faker->name($gender = 'female'),
      'mother_phone_number' => '7' . $this->faker->randomNumber(3, true) . '-' . $this->faker->randomNumber(4, true),
      'father_name' => $this->faker->name($gender = 'male'),
      'father_phone_number' => '7' . $this->faker->randomNumber(3, true) . '-' . $this->faker->randomNumber(4, true),
      'emergency_contact_name' => $this->faker->name($gender = 'male'),
      'emergency_contact_phone' => '7' . $this->faker->randomNumber(3, true) . '-' . $this->faker->randomNumber(4, true),
      'date_high_school_degree' => $this->faker->year($max = 'now'),
      'entry date' => $this->faker->dateTimeBetween('-30 years', '-18 years'),
      'country_id' => 1,
      'department_id' => 14,
      'municipality_id' => 3,
      'status_id' => 1,
    ];
  }
}
