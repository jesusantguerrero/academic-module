<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $fillable = [];

    public function parents() {
      return $this->hasMany();
    }
}
