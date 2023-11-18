<?php

namespace Modules\Academic\Console;

use App\Models\Team;
use Illuminate\Console\Command;
use Modules\Academic\Entities\Level;
use App\Domains\Academic\Services\FeeService;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SetupFees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'academic:setup-fees';

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
      $team = Team::find($teamId);

      $feeService = new FeeService();

      $feeService->setupFeeCategories($team);
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
