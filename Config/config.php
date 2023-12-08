<?php

return [
    'name' => 'Academic',
    'levels' => [
      [
        "name" => "inicial",
        "is_active" => false,
        "cycles" => ["primero", "segundo"],
        "grades" => [
          [
            "name" => "kinder",
            "cycle" => "primero",
            "order" => 1,
          ],
          [
            "name" => "pre-primero",
            "cycle" => "segundo",
            "order" => 2,
          ],
        ]
      ],
      [
        "name" => "primaria",
        "is_active" => true,
        "cycles" => ["primero", "segundo"],
        "grades" => [
          [
            "name" => "primero",
            "label" => "1ro",
            "cycle" => "primero",
            "order" => 1,
          ],
          [
            "name" => "segundo",
            "label" => "2ro",
            "cycle" => "primero",
            "order" => 2,
          ],
          [
            "name" => "tercero",
            "label" => "3ro",
            "cycle" => "primero",
            "order" => 3,
          ],
          [
            "name" => "cuarto",
            "cycle" => "segundo",
            "label" => "4to",
            "order" => 4,
          ],
          [
            "name" => "quinto",
            "label" => "5to",
            "cycle" => "segundo",
            "order" => 5,
          ],
          [
            "name" => "sexto",
            "label" => "6to",
            "cycle" => "segundo",
            "order" => 6,
          ]
        ]
      ],
      [
        "name" => "secundaria",
        "is_active" => false,
        "cycles" => ["primero", "segundo"],
        "grades" => [
          [
            "name" => "primero",
            "label" => "1ro",
            "cycle" => "primero",
            "order" => 1,
          ],
          [
            "name" => "segundo",
            "cycle" => "primero",
            "label" => "2do",
            "order" => 2,
          ],
          [
            "name" => "tercero",
            "cycle" => "primero",
            "label" => "3ro",
            "order" => 3,
          ],
          [
            "name" => "cuarto",
            "cycle" => "segundo",
            "label" => "4to",
            "order" => 4,
          ],
          [
            "name" => "quinto",
            "label" => "5to",
            "cycle" => "segundo",
            "order" => 5,
          ],
          [
            "name" => "sexto",
            "label" => "6to",
            "cycle" => "segundo",
            "order" => 6,
          ]
        ]
      ],
      [
        "name" => "superior",
        "is_active" => false,
      ]
    ],
    "cycles" => [[
      "level" => "inicial",
      "name" => "primer ciclo"
      ]
    ]
];
