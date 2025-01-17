<?php

// Based on attendance percentage, return a CSS color class
function getAttendanceColor($percentage = 0) {
    $color = '';

    if ($percentage >= 0.95) {
        $color = 'text-tier-1';
    } else if ($percentage >= 0.90) {
        $color = 'text-tier-2';
    } else if ($percentage >= 0.85) {
        $color = 'text-tier-3';
    } else if ($percentage >= 0.80) {
        $color = 'text-tier-4';
    } else if ($percentage >= 0.75) {
        $color = 'text-tier-5';
    } else if ($percentage < 0.75) {
        $color = 'text-tier-6';
    }

    return $color;
}

function getHexColorFromDec($color) {
    if ($color) {
        $color = dechex($color);

        // If it's too short, keep adding prefixed zero's till it's long enough
        while (strlen($color) < 6) {
            $color = '0' . $color;
        }
    } else {
        $color = 'FFF';
    }
    return '#' . $color;
}

// Gets date+time formated like 2020-12-31 23:59:59
function getDateTime($format = 'Y-m-d H:i:s') {
    return (new \DateTime())->format($format);
}

// Gets a CSS color for an expansion
function getExpansionColor($expansionId) {
    switch ($expansionId) {
        case 1:
            return 'gold';
        case 2:
            return 'uncommon';
        case 3:
            return 'mage';
        default:
            return 'white';
    }
}

function getExpansionAbbr($expansionId) {
    switch ($expansionId) {
        case 1:
            return 'Classic';
        case 2:
            return 'TBC';
        case 3:
            return 'WoTLK';
        default:
            return '';
    }
}

// Check the request for whether or not we stored the bool isAdmin as true or false
function isAdmin() {
    return request()->get('isAdmin');
}

function isGuildAdmin() {
    return request()->get('isGuildAdmin');
}

function isNotYourGuild() {
    return request()->get('isNotYourGuild');
}

function isStreamerMode() {
    return request()->get('isStreamerMode');
}

// Loads the desired Javascript. Switches source based on dev/prod.
function loadScript($file, $type = 'js') {
    return env('APP_ENV') == 'local' ? asset('/' . $type . '/' . $file) : mix($type . '/processed/' . $file);
}

/**
 * - 999 stays 999
 * - 1000 becomes 1k
 * - 1500 becomes 1.5k
 * - 1000000 becomes 1000k
 *
 * @param int $number The number to shorten.
 *
 * @return string
 */
function numToKs($number) {
    if ($number >= 1000) {
        return number_format(($number / 1000), 1) . 'k';
    } else {
        return $number;
    }
}

function slug($string) {
    $slug = substr(Illuminate\Support\Str::slug($string, '-'), 0, 50);
    if ($slug) {
        return $slug;
    } else {
        return '-';
    }
}

/**
 * Split a string into an array delimited by newlines.
 *
 * @param $string string
 *
 * @return array
 */
function splitByLine($string) {
    return preg_split("/\r\n|\n|\r/", $string);
}

/**
 * Expects a float, returns an s-tier with the decimal of the float intact.
 *
 * @param $float
 *
 * @return array
 */
function numToSTier($float) {
    if ($float > 0) {
        $tiers = App\Guild::tiers();

        $whole = floor($float);
        $decimal = $float - $whole;

        return $tiers[ceil($float)] . ltrim($decimal, '0');
    } else {
        return '';
    }
}
