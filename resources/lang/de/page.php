<?php
return [
    'character' => include('character/character.php'),
    'partials' => include ('partials/partials.php'),
    'member' => include ('member/member.php'),
    'item' => include ('item/item.php'),
    'races' => [
        'bloodelf' => 'Blutelf',
        'orc' => 'Ork',
        'tauren' => 'Taure',
        'troll' => 'Troll',
        'undead' => 'Untoter',
        'draenei' => 'Draenei',
        'dwarf' => 'Zwerg',
        'gnome' => 'Gnom',
        'human' => 'Mensch',
        'nightelf' => 'Nachtelf'
    ],
    'classes' => [
        'deathknight' => 'Todesritter',
        'druid' => 'Druide',
        'hunter' => 'Jäger',
        'mage' => 'Magier',
        'paladin' => 'Paladin',
        'priest' => 'Priester',
        'rogue' => 'Schurke',
        'shaman' => 'Shamane',
        'warlock' => 'Hexenmeister',
        'warrior' => 'Krieger',
    ],
    'professions' => [
        'alchemy' => 'Alchemie',
        'blacksmithing' => 'Schmiedekunst',
        'enchanting' => 'Verzauberkunst',
        'engineering' => 'Ingenieur',
        'herbalism' => 'Kräuterkunde',
        'inscription' => 'Inschriftenkunde',
        'jewelcrafting' => 'Juwelenschleifen',
        'leatherworking' => 'Lederverarbeitung',
        'mining' => 'Bergbau',
        'skinning' => 'Kürschner',
        'tailoring' => 'Schneider',
    ],
    'raids' => [
        'zul_gurub' => "Zul'Gurub",
        'aq40' => "Ruinen von Ahn'Qiraj",
        'worldbosses' => "Weltbosse",
        'moltencore' => "Molten Core",
        'ony_classic' => "Onyxia's Hort",
        'bwl' => "Pechschwingenhort",
        'aq20' => "Tempel von Ahn'Qiraj",
        'naxx' => "Naxxramas",
        'karazhan' => "Karazhan",
        'gruul' => "Gruul's Unterschlupf",
        'magtheridon' => "Magtheridon's Kammer",
        'ssc' => 'Höhle des Schlangenschreins',
        'hyjal' => 'Hyjalgipfel',
        'tempest_keep' => 'Festung der Stürme',
        'black_temple' => 'Schwarzer Tempel',
        'zul_aman' => "Zul'Aman",
        'sunwell' => 'Sonnenbrunnenplateau',
    ]
];