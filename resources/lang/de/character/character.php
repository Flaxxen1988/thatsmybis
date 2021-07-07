<?php

return [
    'loot' => include('loot.php'),
    'show' => include('show.php'),
    'edit' => include('edit.php'),
    'partials' => [
        'header' => include('partials/header.php'),
        'itemdetails' => include('partials/itemdetails.php'),
        'headerTitle' => include ('partials/headerTitle.php'),
    ]
];