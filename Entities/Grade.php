<?php

namespace Modules\Academic\Entities;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'team_id',
      'level_id',
      'cycle_id',
      'name',
      'full_name',
      'description',
      'fee',
    ];

    protected $table = "ac_grades";

    protected $appends = ['studentCount'];

    public function classrooms() {
      return $this->hasMany(Classroom::class);
    }

    public function cycle() {
      return $this->belongsTo(Cycle::class);
    }

    public function level() {
      return $this->belongsTo(Level::class);
    }

    public function students() {
      return $this->hasMany(Admission::class, 'grade_id')->active();
    }

    protected static function boot() {
      parent::boot();

      static::saving(function ($grade) {
        $grade->full_name = $grade?->full_name ?? "{$grade->name} {$grade->level?->name}";
      });
    }

    protected function getStudentCountAttribute() {
      return $this->students()->count();
    }

    public static function getByTeam($teamId) {
      return self::where([
        "ac_grades.team_id" => $teamId,
      ])
      ->selectRaw('ac_grades.*')
      ->join('ac_levels', 'ac_levels.id', 'ac_grades.level_id')
      ->orderBy(DB::raw('concat(ac_levels.order, ".", ac_grades.order)'))
      ->get();
    }
}
