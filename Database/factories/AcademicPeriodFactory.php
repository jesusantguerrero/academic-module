<?php

namespace Modules\Academic\Database\factories;

use Illuminate\Support\Carbon;
use Modules\Academic\Entities\AcademicPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcademicPeriodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Academic\Entities\AcademicPeriod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
      $startDate = $this->faker->dateTimeBetween('-1 year', 'now');
      $endDate = Carbon::parse($startDate)->addMonths(3);

        return [
          'name' => Carbon::parse($startDate)->format('Y-m') . "-" . $endDate->format('Y-m'),
          'start_date' => $startDate->format('Y-m-d'),
          'end_date' => $endDate->format('Y-m-d'),
          'is_active' => false
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (AcademicPeriod $period) {
           // Get the last created period
          $lastPeriod = AcademicPeriod::latest()->first();

          // Generate the next sequential period
          $nextStartDate = Carbon::parse($lastPeriod->end_date)->addDays(1);
          $nextEndDate = Carbon::parse($nextStartDate)->addMonths(3);

          // Update the current period with the sequential dates
          $period->update([
              'start_date' => $nextStartDate,
              'end_date' => $nextEndDate,
          ]);
        });
    }
}

