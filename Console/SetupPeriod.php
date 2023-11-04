<?php

namespace Modules\Academic\Console;

use App\Models\User;
use Illuminate\Console\Command;
use App\Domains\CRM\Models\Client;
use Spatie\Backup\Tasks\Cleanup\Period;
use Modules\Academic\Entities\Admission;
use App\Domains\Academic\Data\AdmissionData;
use Modules\Academic\Entities\AcademicPeriod;
use App\Domains\Academic\Services\PeriodService;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Domains\Academic\Services\AdmissionService;

class SetupPeriod extends Command
{

    protected $name = 'academic:setup-period';
    protected $description = 'Generate data for period.';

    public function handle(PeriodService $periodService, AdmissionService $admissionService): mixed
    {
      $teamId = $this->argument('teamId');
      $user = User::where(["current_team_id" => $teamId])->first();
      $periods = AcademicPeriod::factory()->count(3)->make();


      // foreach ($periods as $period) {
      //    $periodService->create(
      //     [...$period->toArray(),
      //     "team_id" => $teamId,
      //     "user_id" => $user->id
      //   ], $user);
      // }

      // $periodService->setCurrentPeriod(["current_period_id" => AcademicPeriod::latest()->first()->id], $user);

      $admissions = Admission::factory()->count(10)->make([
        "team_id" => $teamId,
        "user_id" => $user->id,
        "period_id" => $user->currentTeam->current_period_id,
      ]);

      foreach ($admissions as $admission) {
         $admissionService->create(
            AdmissionData::from([...$admission->toArray(),
            "parents" => Client::factory()->count(2)->make()->toArray()
          ]),
            $user
          );
      }

      return 1;
    }

    protected function getArguments(): array
    {
        return [
            ['teamId', InputArgument::REQUIRED, '2'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
