<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GradeFee extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "ac_grade_fees";

    protected $casts = [
      'grade_ids' => 'array'
    ];

    public function grade() {
      return $this->hasMany(Grade::class);
    }

    public function level() {
      return $this->belongsTo(Level::class);
    }
}
