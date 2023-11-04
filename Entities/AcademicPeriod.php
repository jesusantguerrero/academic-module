<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Academic\Database\factories\AcademicPeriodFactory;

class AcademicPeriod extends Model
{
    use HasFactory;

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

    protected static function newFactory()
    {
        return AcademicPeriodFactory::new();
    }
}
