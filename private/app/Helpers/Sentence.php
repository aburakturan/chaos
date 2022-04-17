<?php

/**
 * Custom Functions For Laravel 5 - HelperServiceProdiver.
 *
 * @author Ozgur KARAGOZ
 */
function getSentence($sentence, $stripTags = false, $variables = array())
{
    $getSentence = config('sentences.'.$sentence);

    if (count($variables)) {
        foreach ($variables as $key => $value) {
            $getSentence = str_replace(':'.$key.':', $value, $getSentence);
        }
    }

    if ($stripTags) {
        return strip_tags($getSentence);
    }

    return $getSentence;
}

function theSentence($sentence, $stripTags = true, $variables = array())
{
    return getSentence($sentence, $stripTags, $variables);
}
