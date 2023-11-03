<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "ac_grades";

    public function classrooms() {
      return $this->hasMany(ClassRoom::class);
    }

    public function level() {
      return $this->belongsTo(Level::class);
    }

    protected static function boot() {
      parent::boot();

      static::saving(function ($grade) {
        $grade->full_name = "{$grade->name} {$grade->level->name} {}";
      });
    }
}
