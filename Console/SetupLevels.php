<?php

namespace Modules\Academic\Console;

use App\Models\Team;
use Illuminate\Console\Command;
use Modules\Academic\Entities\Level;
use Modules\Academic\Actions\SetLevelsAndGrades;
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
    public function __construct(private SetLevelsAndGrades $setLevelsAndGrades)
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
      $team = Team::find($this->argument('teamId'));
      $levels = config('academic.levels');
      $this->setLevelsAndGrades->handle($team, $levels);
    }


    protected function getArguments(): array
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
