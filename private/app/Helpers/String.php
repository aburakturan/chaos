<?php

function textUppercase($text)
{
    if (app()->getLocale() == 'tr') {
        $text = str_replace(array('i', 'ı'), array('İ', 'I'), $text);
    }

    return mb_convert_case($text, MB_CASE_UPPER, 'UTF-8');
}

function strLimit($content, $limit)
{
    $content = strip_tags($content);

    return str_limit(html_entity_decode($content), $limit);
}

function phoneToURLTel($phone, $widthTel = true)
{
    $output = '';

    if ($widthTel) {
        $output .= 'tel:';
    }

    $output .= str_replace(['(', ')', ' '], '', $phone);

    return $output;
}
