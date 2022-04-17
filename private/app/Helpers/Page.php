<?php

function getPageByTemplate($template)
{
    if (config('pages_'.app()->getLocale())) {
        return config('pages_'.app()->getLocale())->where('template', $template)->first();
    }
}

function getPageById($id)
{
    if (config('pages_'.app()->getLocale())) {
        return config('pages_'.app()->getLocale())->where('id', $id)->first();
    }
}
