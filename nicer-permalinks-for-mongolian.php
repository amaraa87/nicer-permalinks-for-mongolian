<?php
/*
Plugin Name: Nicer permalinks for Mongolian
Tags: wp, php, utf-8, converter, cp1251, mongolian , cryllic
Author: Amara
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: 1.1
Version: 1.1
*/

<?php

function removeSign($str)
{
    $cyrillic = array(
        "а", "б", "в", "г", "д", "е", "ё", "ж", "з", "и", "й", "к",
        "л", "м", "н", "о", "ө",
        "п", "р", "с", "т", "у", "ү", "ф", "х", "ц", "ч", "ш",
        "щ", "ъ", "ы", "ь", "э",
        "ю", "я",
        "А", "Б", "В", "Г", "Д", "Е", "Ё", "Ж", "З", "И", "Й", "К",
        "Л", "М", "Н", "О", "Ө",
        "П", "Р", "С", "Т",
        "У", "Ү", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ", "Ы", "Ь",
        "Э", "Ю", "Я"
    );

    $latin = array(
        "a", "b", "v", "g", "d", "ye", "yo", "j", "z", "i", "i", "k",
        "l", "m", "n", "o", "u",
        "p", "r", "s", "t", "u", "u", "f", "h", "ts", "ch", "sh",
        "sh", "i", "y", "i", "e",
        "yu", "ya",
        "A", "B", "V", "G", "D", "YE", "YO", "J", "Z", "I", "I", "K",
        "L", "M", "N", "O", "U",
        "P", "R", "S", "T", "U", "U", "F", "H", "TS", "CH", "SH",
        "SH", "I", "Y", "I", "E",
        "YU", "YA"
    );

    return str_replace($cyrillic, $latin, $str);
}

function removeTitle($string, $keyReplace = "-")
{
    $string = removeSign($string);

    $string = trim(preg_replace("/[^A-Za-z0-9]/i", " ", $string));
    $string = str_replace(" ", "-", $string);
    $string = preg_replace("/-+/", "-", $string); // Replace multiple dashes with a single one
    $string = str_replace($keyReplace, "-", $string);

    return $string;
}

function appendSlug($data)
{
    if (!empty($data['post_name'])) {
        $data['post_name'] = strtolower(removeTitle($data['post_title']));
    } else {
        $data['post_name'] = strtolower(removeTitle($data['post_name']));
    }

    return $data;
}

add_filter('wp_insert_post_data', 'appendSlug', 10);
