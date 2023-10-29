<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $fillable = [
      "team_id",
      "user_id",
      "name",
      "fee",
      "capacity"
    ];
    protected $table = "ac_classrooms";

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
