<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $guarded = [];

    protected $table = "ac_levels";

    public function cycles() {
      return $this->hasMany(Cycle::class);
    }

    public function grades() {
      return $this->hasMany(Grade::class);
    }
}
