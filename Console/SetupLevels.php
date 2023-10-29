<?php

namespace Modules\Academic\Console;

use Illuminate\Console\Command;
use Modules\Academic\Entities\Level;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SetupLevels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'academic:setup-levels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $teamId = $this->argument('teamId');
      $levels = config('academic.levels');
      $storedCycles = [];

      foreach ($levels as $order => $level) {
        $levelSaved = Level::create([
          "team_id" => $teamId,
          "user_id" => 0,
          "order" => $order,
          "name" => $level["name"],
          "label" => $level["label"] ?? ucfirst($level["name"]),
          "is_active" => $level["is_active"]
        ]);

        if (isset($level["cycles"])) {
          foreach ($level["cycles"] as $cycle) {
            $cycleSaved = $levelSaved->cycles()->create([
              "team_id" => $teamId,
              "user_id" => 0,
              "order" => $order,
              "name" => $cycle,
              "label" => ucfirst($cycle),
            ]);

            $storedCycles[$cycleSaved->name] = $cycleSaved->id;
          }
        }

        if (isset($level["grades"])) {
          foreach ($level["grades"] as $grade) {
            $levelSaved->grades()->create([
              "team_id" => $teamId,
              "user_id" => 0,
              "cycle_id" => $storedCycles[$grade["cycle"]],
              "order" => $grade["order"] ?? $order,
              "name" => $grade["name"],
              "label" => $grade["label"] ?? ucfirst($grade["name"]),
            ]);
          }
        }

      }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['teamId', InputArgument::REQUIRED, '2'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
