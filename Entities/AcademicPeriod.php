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
      'end_date',
      'is_active'
    ];
    protected $table = "ac_academic_periods";

    public function classrooms() {
      return $this->hasMany(ClassRoom::class, 'period_id');
    }
}
