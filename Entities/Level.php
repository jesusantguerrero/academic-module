<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
      'team_id',
      'user_id',
      'name',
      'label',
      'description',
    ];

    protected $table = "ac_levels";

    public function cycles() {
      return $this->hasMany(Cycle::class);
    }

    public function grades() {
      return $this->hasMany(Grade::class);
    }

    protected static function booted()
    {
        static::creating(function ($invoice) {
            self::setNumber($invoice);
        });
    }

    public static function setNumber($resource)
    {
        $isInvalidNumber = true;

        if ($resource->order) {
            $isInvalidNumber = self::where([
                "team_id" => $resource->team_id,
                "order" => $resource->order,
            ])->whereNot([
                "id" => $resource->id
            ])->get();

            $isInvalidNumber = count($isInvalidNumber);
        }

        if ($isInvalidNumber) {
            $result = self::where([
                "team_id" => $resource->team_id,
            ])->max('order');
            $resource->order = $result + 1;
        }
    }
}
