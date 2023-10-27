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
    protected $table = "ac_class_rooms";
}
