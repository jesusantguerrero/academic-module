<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentProgress extends Model
{

    protected $fillable = [
      "team_id",
      "user_id",
      "student_id",
      "period_id",
      "status"
    ];
    protected $table = "ac_student_progress";

}
