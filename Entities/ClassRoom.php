<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
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

    public function grade() {
      return $this->belongsTo(Grade::class);
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

    public function pastAdmissionsInProgress() {
      return $this->hasMany(Admission::class)->inProgress();
    }

    public function pastAdmissionsInDraft() {
      return $this->hasMany(Admission::class)->draft();
    }
}
