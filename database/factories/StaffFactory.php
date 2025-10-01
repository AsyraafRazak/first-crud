<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = ['Manager', 'Executive', 'Officer', 'Assistant', 'Intern'];
        $departments = ['IT', 'HR', 'Finance', 'Marketing', 'Operations', 'Legal'];
        $genders = ['Male', 'Female'];
        $locations = [
            'Kuala Lumpur', 'Johor Bahru', 'Penang', 'Shah Alam',
            'Kota Kinabalu', 'Kuching', 'Melaka', 'Ipoh', 'Seremban', 'Alor Setar'
        ];

        return [
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement($genders),
            'startServiceDate' => $this->faker->dateTimeBetween('-10 years', 'now'),
            'position' => $this->faker->randomElement($positions),
            'department' => $this->faker->randomElement($departments),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => '01' . $this->faker->numberBetween(1, 9) . $this->faker->numerify('########'),
            'office_location' => $this->faker->randomElement($locations),
        ];
    }
}
