<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    const ACTION_ENROLL = 'enroll';
    const ACTION_RE_ENROLL = 're_enroll';
    const ACTION_PROMOTE = 'promoted';
    const ACTION_REPEAT = 'repeat';

    const INVOICE_TYPE_ENROLLMENT = 'enrollment';
    const INVOICE_TYPE_MONTH = 'month';

    protected $fillable = [
      'user_id',
      'team_id',
      'classroom_id',
      'period_id',
      'student_id',
      'fee',
    ];

    protected $table = "ac_admissions";
}
