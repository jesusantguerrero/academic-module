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

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    protected $fillable = [
      'team_id',
      'user_id',
      'name',
      'shortname',
      'description',
      'start_date',
      'end_date',
    ];
    protected $table = "ac_periods";

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

    public function hasPassed() {
      return InvoiceHelper::getCarbonDate($this->end_date)->gt(now());
    }

    protected function getStudentCountAttribute() {
      return $this->students()->count();
    }
}
