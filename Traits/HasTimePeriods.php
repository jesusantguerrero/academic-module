<?php

namespace Modules\Academic\Traits;

use Modules\Academic\Entities\AcademicPeriod;

trait HasTimePeriods
{

    public function currentPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class, 'current_period_id');
    }
}
