<?php

return [
    'name' => 'Academic',
    'levels' => [
      [
        "name" => "inicial",
        "is_active" => false,
        "cycles" => ["primero", "segundo"]
      ],
      [
        "name" => "primario",
        "is_active" => true,
        "cycles" => ["primero", "segundo"],
        "grades" => [
          [
            "name" => "primero",
            "cycle" => "primero",
            "order" => 1,
          ],
          [
            "name" => "segundo",
            "cycle" => "primero",
            "order" => 2,
          ],
          [
            "name" => "tercero",
            "cycle" => "primero",
            "order" => 3,
          ],
          [
            "name" => "cuarto",
            "cycle" => "segundo",
            "order" => 4,
          ],
          [
            "name" => "quinto",
            "cycle" => "segundo",
            "order" => 5,
          ],
          [
            "name" => "sexto",
            "cycle" => "segundo",
            "order" => 6,
          ]
        ]
      ],
      [
        "name" => "secundario",
        "is_active" => false,
        "cycles" => ["primero", "segundo"],
        "grades" => [
          [
            "name" => "primero",
            "cycle" => "primero",
            "order" => 1,
          ],
          [
            "name" => "segundo",
            "cycle" => "primero",
            "order" => 2,
          ],
          [
            "name" => "tercero",
            "cycle" => "primero",
            "order" => 3,
          ],
          [
            "name" => "cuarto",
            "cycle" => "segundo",
            "order" => 4,
          ],
          [
            "name" => "quinto",
            "cycle" => "segundo",
            "order" => 5,
          ],
          [
            "name" => "sexto",
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
