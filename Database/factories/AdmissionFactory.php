<?php

namespace Modules\Academic\Database\factories;

use Modules\Academic\Entities\Grade;
use Modules\Academic\Entities\Admission;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdmissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Academic\Entities\Admission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $birthDate = $this->faker->dateTimeBetween('-18 year', '-6 year');

        return [
          'user_id' => 1,
          'team_id' => 1,
          'classroom_id' => null,
          'grade_id' => function (array $attributes) {
            return Grade::where([
              "team_id" => $attributes['team_id'],
            ])->get()->pluck('id')->random();
          },
          'level_id' => null,
          'period_id' => null,
          'gender' => 'M',
          'client_id' => null,
          'student_id' => null,
          'next_invoice_date' => null,
          'status' => Admission::STATUS_DRAFT,
          'generated_invoice_dates' => [],
          'fee' => 1000,
          "names" => $this->faker->name(),
          "lastnames" => $this->faker->lastName(),
          "gender" => null,
          "birth_date" => $birthDate->format('Y-m-d'),
        ];
    }
}

