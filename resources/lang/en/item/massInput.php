<?php
return [
        'assign' => 'Assign Loot',
        'hint' => 'Hint:',
        'note' => 'Note:',
        'hint_msg' => 'Keep the roster and/or item pages open in another window to review who deserves what',
        'note_msg' => "If a character has the same item prio'd in multiple raid groups, we'll only remove/flag the first one we find.",
        'import' => 'Import Loot',
        'paste' => 'Paste your',
        'data' => 'data',
        'max' => 'max',
        'rows' => 'rows',
        'csv_info' => "Accepts RCLootCouncil CSV data, or any CSV. First line must contain headers for the data (case sensitive).
eg.
character,date,itemID,itemName,note
    Gurgthock,2020-10-01,18821,Quick Strike Ring,That's my BIS

Supported header fields: (CASE SENSITIVE)
================
player OR character (required)
itemID OR item_id (required)
item OR itemName OR item_name
date OR dateTime OR date_time
publicNote OR public_note (max 140 chars)
(officerNote OR officer_note) + (note AND/OR votes AND/OR response) (max 140 chars)
offspec

If note, response, public note, or officer note are equal to 'OS', offspec flag will be set to true.
",
        'support_csv_schema' => "Doesn't match your data schema? Request support for it",
        'on_disc' => 'on our Discord',
        'remove_warning' => "WARNING!!! Loading this will remove any items you've already added to this page.",
        'load' => 'Load Data',
        'nvm' => 'Nevermind',
        'show_note_inputs' => 'Show note inputs',
        'show_date_inputs' => 'Show date inputs',
        'for_backdating' => 'for backdating old loot',
        'set_default_date' => 'Set default date',
        'overwrite_date_warning' => 'optional, overwrites all date inputs',
        'default_today' => 'defaults to today',
        'raid_group' => 'Raid Group',
        'character_dropdown' => 'Character dropdown filter',
        'item' => 'Item',
        'searching' => 'Searching...',
        'character' => 'Character',
        'os' => 'Offspec',
        'notes' => 'Note',
        'optional' => 'optional',
        'optional_note' => 'Optional Note',
        'optional_officer_note' => 'Optional Officer Note',
        'note_desc' => 'brief public note',
        'officer_note' => 'Officer Note',
        'rclc_date_issue' => 'RCLC date imports may be off by +/-24h due to timezone issues.',
        'date' => 'Date',
        'optional_date' => 'Optional Date',
        'uid' => 'Unique Import ID',
        'uid_desc' => 'We use this to prevent your guild from loading duplicates of the same import data.',
        'uid_addon' => 'unique ID from loot addon',
        'max_items_added' => 'Max items added',
        'skip_no_character' => "Skip items that don't have a character",
        'skip_no_character_desc' => "useful for ignoring characters that aren't in your guild when importing data",
        'delete_from_wishlist' => "Delete assigned items from each character's wishlist",
        'delete_from_wishlist_desc' => "if unchecked, corresponding wishlist items will be flagged as received but still be visible",
        'delete_from_prio' => "Delete assigned items from each character's prio list",
        'delete_from_prio_desc' => "if unchecked, corresponding prio will be flagged as received but still be visible",
        'no_raid_group' => "No raid group selected",
        'submit' => "Submit",
        'expires_warn1' => "WARNING: This form expires if you don't submit it within",
        'expires_warn2' => "hours (security reasons)",

];