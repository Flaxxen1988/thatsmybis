<?php
return [
        'assign' => 'Beute zuweisen',
        'hint' => 'Hinweis:',
        'note' => 'Anmerkung:',
        'hint_msg' => 'Behalte den Dienstplan und/oder die Beutefenster in einem anderen Fenster offen um nachzuvollziehen wer was benötigt',
        'note_msg' => "Wenn ein Character das selbe Item in mehreren Raids priorisiert wird nur der erste entfernt/geflaggt.",
        'import' => 'Importiere Beute',
        'paste' => 'Kopiere deine',
        'data' => 'daten',
        'max' => 'maximal',
        'rows' => 'Zeilen',
        'csv_info' => "Akzeptiert RCLootCouncil CSV Dateien. Die erste Zeile muss eine Kopfzeile für die Daten enthalten (case sensitive).
z.B.
character,date,itemID,itemName,note
    Gurgthock,2020-10-01,18821,Quick Strike Ring,That's my BIS

Unterstützte Kopfzeilen: (CASE SENSITIVE)
================
player OR character (required)
itemID OR item_id (required)
item OR itemName OR item_name
date OR dateTime OR date_time
publicNote OR public_note (max 140 chars)
(officerNote OR officer_note) + (note AND/OR votes AND/OR response) (max 140 chars)
offspec

Wenn note, response, public note, oder officer note gleich 'OS' wird die Zweitspezialisierung auf true gesetzt.
",
        'support_csv_schema' => "Passt das Datenschema nicht zu eurem? Wir Unterstützen euch.",
        'on_disc' => 'auf unserem Discord',
        'remove_warning' => "WARNUNG!!! Dies zu Laden wird alle bereits eingetragenen Items auf dieser Seite zurücksetzen.",
        'load' => 'Lade Daten',
        'nvm' => 'Schon gut',
        'show_note_inputs' => 'Zeige Notizeingaben',
        'show_date_inputs' => 'Show Datumseingaben',
        'for_backdating' => 'um Beute zurückzudatieren',
        'set_default_date' => 'Setze standard Datum',
        'overwrite_date_warning' => 'optional, überschreibt alle Datumseingaben',
        'default_today' => 'setze auf heute zurück',
        'raid_group' => 'Raidgruppe',
        'character_dropdown' => 'Charakter filter',
        'item' => 'Gegenstand',
        'searching' => 'Suche...',
        'character' => 'Charakter',
        'os' => 'Zweitspezialisierung',
        'notes' => 'Notiz',
        'optional' => 'optional',
        'optional_note' => 'Optionale Notiz',
        'optional_officer_note' => 'Optionale Offiziers Notiz',
        'note_desc' => 'kurze öffentliche notiz',
        'officer_note' => 'Offiziers Notiz',
        'rclc_date_issue' => 'RCLC Datumsimporte können +/-24 stunden je nach Zeitzone abweichen.',
        'date' => 'Datum',
        'optional_date' => 'Optionales Datum',
        'uid' => 'Einzigartige Import ID',
        'uid_desc' => 'Wir nutzen diese um zu verhindern dass mehrere mitglieder der Gilde die selbe Datei importieren.',
        'uid_addon' => 'einzigartige ID vom loot addon',
        'max_items_added' => 'Maximale Gegenstände hinzugefügt',
        'skip_no_character' => "Überspringe Gegenstände die keinen Character besitzen",
        'skip_no_character_desc' => "hilfreich um charactere zu überspringen die nicht in der Gilde sind",
        'delete_from_wishlist' => "Entferne zugewiesene Gegenstände von der Wunschliste des Characters.",
        'delete_from_wishlist_desc' => "Wenn nicht angeklickt werden die items in der Wunschliste durchgestrichen, sind jedoch noch einsehbar",
        'delete_from_prio' => "Entferne zugewiesene Gegenstände von der Prioritätenliste des Characters.",
        'delete_from_prio_desc' => "Wenn nicht angeklickt werden die items in der Prioritätenliste durchgestrichen, sind jedoch noch einsehbar",
        'no_raid_group' => "Keine Raidgruppe ausgewählt",
        'submit' => "Abschicken",
        'expires_warn1' => "WARNUNG: Dieses Formular läuft in ",
        'expires_warn2' => "Stunden ab (Sicherheitshalber)",
];