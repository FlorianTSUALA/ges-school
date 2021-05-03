<?php

// GESTION DE L'ENSEMBLE DES CHEMINS DE BASE DU FRAMEWORK

use Config\Invariant\Path;

return[

    Path::SAMPLE => [
        "title" => "accueil",
        "icon" => "",
        "url" => "",
        "hasChildren" => false,
        "children" => [],
    ],
    Path::VERSION => '',
];

//check core/config.php to see how to access data array by good pratice