<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class AcademicPeriod extends Model
{
    protected $fillable = [
      'team_id',
      'user_id',
      'name',
      'start_date',
      'is_active'
    ];
    protected $table = "ac_academic_periods";

    public function classes() {
      return $this->hasMany(ClassRoom::class);
    }
}
