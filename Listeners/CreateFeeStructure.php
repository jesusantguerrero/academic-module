<?php

namespace Modules\Academic\Listeners;

use Laravel\Jetstream\Events\TeamCreated;
use Modules\Academic\Actions\SetLevelsAndGrades;

class CreateFeeStructure
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(private SetLevelsAndGrades $setLevelsAndGrades) {}

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
    */
    public function handle(TeamCreated $event)
    {
        $team = $event->team;
        // $this->setLevelsAndGrades($team);
    }

      /**
     * Set general chart of accounts categories
     *
     * @return void
     */
    protected function setLevelsAndGrades($team)
    {

    }
}
