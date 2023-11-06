<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Accounting\Helpers\InvoiceHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $appends = ['days', 'studentCount'];

    public function classrooms() {
      return $this->hasMany(ClassRoom::class, 'period_id');
    }
    public function students() {
      return $this->hasMany(Admission::class, 'period_id')->active();
    }

    protected static function newFactory()
    {
        return AcademicPeriodFactory::new();
    }

    protected function days(): Attribute {
      return new Attribute(
        get: fn($value, $attributes) => InvoiceHelper::getCarbonDate($attributes['start_date'])
        ->diffInDays(InvoiceHelper::getCarbonDate($attributes['end_date']))
      );
    }

    protected function getStudentCountAttribute() {
      return $this->students()->count();
    }
}
