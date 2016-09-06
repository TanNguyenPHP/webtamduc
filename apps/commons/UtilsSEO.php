<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 6/22/2016
 * Time: 11:08 AM
 */

namespace Coredev\commons;

use Coredev\Commons\RemoveUnicode;

class UtilsSEO
{
    public static function CreateSlug($text)
    {
        $text = RemoveUnicode::SpaceUnicode($text);
        $text = \preg_replace('/[^A-Za-z0-9\-]/', " ", $text);
        $text = \str_replace(" ", "-", $text);
        return $text;
    }
}