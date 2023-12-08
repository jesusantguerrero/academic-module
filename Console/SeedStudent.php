<?php

namespace Modules\Academic\Console;

use App\Models\User;
use Illuminate\Console\Command;
use App\Domains\CRM\Models\Client;
use Modules\Academic\Entities\Admission;
use App\Domains\Academic\Data\AdmissionData;
use Symfony\Component\Console\Input\InputOption;
use App\Domains\Academic\Services\StudentService;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Database\Eloquent\Factories\Sequence;

class SeedStudent extends Command
{

    protected $name = 'academic:feed-student';
    protected $description = 'Generate sample data for student.';

    public function handle(StudentService $studentService): mixed
    {
      $teamId = $this->argument('teamId');
      $user = User::where(["current_team_id" => $teamId])->first();


      $admissions = Admission::factory()->count(10)
      ->state(new Sequence(
        ['gender' => 'M'],
        ['gender' => 'F'],
      ))
      ->make([
        "team_id" => $teamId,
        "user_id" => $user->id,
        "period_id" => $user->currentTeam->current_period_id,
      ]);

      foreach ($admissions as $admission) {
         $studentService->create(
            AdmissionData::from([...$admission->toArray(),
              "parents" => Client::factory()->count(2)
              ->state(new Sequence(
                ['gender' => 'M'],
                ['gender' => 'F'],
              ))->make()->toArray(),
              "fee" => null,
              "first_invoice_date" =>  date('Y-m-d'),
              "grace_days" => 1,
              "late_fee" => 100,
              "rrule" => [
                "frequency" => "DAILY",
                "interval" => 1
              ]
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
