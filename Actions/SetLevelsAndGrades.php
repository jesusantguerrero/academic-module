<?php

namespace Modules\Academic\Actions;

use App\Models\Team;
use App\Models\ContactType;
use Modules\Academic\Entities\Level;


class SetLevelsAndGrades
{
    public function handle(Team $team, mixed $levelData)
    {
      foreach ($levelData as $order => $level) {
        $levelSaved = Level::create([
          "team_id" => $team->id,
          "user_id" => $team->user_id,
          "order" => $order,
          "name" => $level["name"],
          "label" => $level["label"] ?? ucfirst($level["name"]),
          "is_active" => $level["is_active"]
        ]);

        if (isset($level["cycles"])) {
          foreach ($level["cycles"] as $cycle) {
            $cycleSaved = $levelSaved->cycles()->create([
              "team_id" => $team->id,
              "user_id" => $team->user_id,
              "order" => $order,
              "name" => $cycle,
              "label" => ucfirst($cycle),
            ]);

            $storedCycles[$cycleSaved->name] = $cycleSaved->id;
          }
        }

        if (isset($level["grades"])) {
          foreach ($level["grades"] as $grade) {
            $levelSaved->grades()->create([
              "team_id" => $team->id,
              "user_id" => $team->user_id,
              "cycle_id" => $storedCycles[$grade["cycle"]],
              "order" => $grade["order"] ?? $order,
              "name" => $grade["name"],
              "label" => $grade["label"] ?? ucfirst($grade["name"]),
              "fee" => $grade["fee"] ?? $level["fee"],
            ]);
          }
        }
      }
    }

    public function addContactTypes(Team $team) {
        $contactTypes = [[
          "name" => "students",
          "label" => "Estudiantes"
        ], [
          "name" => "parents",
          "label" => "Tutores"
        ],
        [
          "name" => "teachers",
          "label" => "Profesores"
        ],
        [
          "name" => "staff",
          "label" => "Empleados"
        ],
      ];

      foreach ($contactTypes as $contactType) {
        ContactType::create([
          "team_id" => $team->id,
          "user_id" => $team->user_id,
          ...$contactType
        ]);
      }
    }
}
