<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
      "team_id",
      "user_id",
      "grade_id",
      "period_id",
      "name",
      "number",
      "code",
      "fee",
      "capacity"
    ];
    protected $table = "ac_classrooms";
    protected $appends = ['studentCount'];

    protected static function boot() {
      parent::boot();

      static::saving(function($classroom) {
        $defaultName = "{$classroom->period->name} {$classroom->grade->level->name} {$classroom->grade->name}";
        $gradeName = $classroom->grade->label ?? $classroom->grade->name;
        $classroom->full_name = $defaultName;
        $classroom->name = $classroom->name ?? "{$gradeName} {$classroom->grade->level->name}";
        $classroom->number = $classroom->number ?? "{$classroom->grade->level->order}.{$classroom->grade->order}";
        $classroom->code = $classroom->code ?? "{$classroom->period->name}_{$classroom->grade->level->name}-{$classroom->grade->name}";
      });
    }

    public function grade() {
      return $this->belongsTo(Grade::class);
    }

    public function period() {
      return $this->belongsTo(AcademicPeriod::class, 'period_id');
    }

    public function level() {
      return $this->belongsTo(Level::class);
    }

    public function admissions() {
      return $this->hasMany(Admission::class)->completed();
    }

    public function admissionsArchived() {
      return $this->hasMany(Admission::class)->archived();
    }

    public function activeStudents() {
      return $this->hasMany(Admission::class, 'classroom_id')->active();
    }
    public function pastAdmissionsInProgress() {
      return $this->hasMany(Admission::class)->active();
    }

    public function pastAdmissionsInDraft() {
      return $this->hasMany(Admission::class)->draft();
    }

    protected function getStudentCountAttribute() {
      return $this->activeStudents()->count();
    }
}
