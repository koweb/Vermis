<?php

/**
 * =============================================================================
 * @file        FreeCode/String.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: String.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_String
 * @brief   String manipulations.
 */
class FreeCode_String
{

    static $_specialChars = array(
        '/', '\\', '?', '"', '\'', '!', '@', '#',
        '$', '%', '^', '&', '<', '>', ',', '.',
        '~', '`', ':', '[', ']', '{', '}', '(',
        ')', '*', ',', '|', ';'
    );

    static $_plCaseCvt = array(
        'Ą' => 'ą',
        'Ć' => 'ć',
        'Ę' => 'ę',
        'Ł' => 'ł',
        'Ń' => 'ń',
        'Ó' => 'ó',
        'Ś' => 'ś',
        'Ż' => 'ż',
        'Ź' => 'ź',
        "\n" => ' ',
        "\r" => ' ',
        "\t" => ' '
    );

    /**
     * Convert text to keywords.
     * @param   string  $text
     * @param   string  $explode    Slice tekst to words.
     * @return  string
     */
    public static function textToKeywords($text, $explode = true)
    {
        $text = strip_tags($text);
        $text = strtr($text, self::$_plCaseCvt);
        $text = strtolower($text);

        $keywords = '';

        if ($explode) {
            $array = explode(' ', $text);
            foreach ($array as $word) {
                if (!empty($word)) {
                    foreach (self::$_specialChars as $c)
                        $word = str_replace($c, '', $word);
                    if (strlen($word) > 1)
                        $keywords .= ", {$word}";
                }
            }

        } else {
            foreach (self::$_specialChars as $c)
                $text = str_replace($c, '', $text);
            $keywords = $text;
        }

        $keywords = trim($keywords, ", \n\t\r\0\x0b");
        return $keywords;
    }

    /**
     * Normalize string, make it seo friendly.
     * @param   string  $text
     * @return  string
     */
    public static function normalize($text, $separator = '-')
    {
        $text = mb_ereg_replace('[\x00-\x2F\x3A-\x40\x5B-\x60\x7B-\x7F]', $separator, $text);
        $text = mb_ereg_replace('['.$separator.']+', $separator, $text);
        $text = trim($text, $separator);
        return $text == '' ? '-' : $text;
    }
    
    /**
     * Get date stamp.
     * @param   int     $time   Unix timestamp.
     * @return  string
     */
    public static function timeStamp($time = null)
    {
        return date('Y-m-d H:i:s', isset($time) ? $time : time());
    }

    /**
     * Convert time stamp to unix timestamp.
     * @param   string  $timeStamp  YYYY-MM-DD hh:mm:ss
     * @return  int
     */
    public static function timeStampToTime($timeStamp)
    {
        list($year, $month, $day, $hours, $minutes, $seconds) = sscanf($timeStamp, '%d-%d-%d %d:%d:%d');
        return mktime($hours, $minutes, $seconds, $month, $day, $year);
    }

    /**
     * Convert timestamp to date.
     * @param   string  $format     Date formating string.
     * @param   string  $timeStamp  Text timestamp YYYY-MM-DD HH:MM:SS
     * @return  string
     */
    public static function dateFromStamp($format, $timeStamp)
    {
        return date($format, self::timeStampToTime($timeStamp));
    }

    /**
     * Convert file size to text
     * @param   int     $size
     * @param   string  $space  Replace spaces to separator;
     * @return  string
     */
    public static function fileSize($size, $space = ' ')
    {
        if ($size < 1024)
            return $size.$space.'B';
        $size /= 1024;    
        if ($size < 1024)
            return round($size, 2).$space.'kB';
        $size /= 1024;
        return round($size, 2).$space.'MB';
    }

    /**
     * Generate randomized string.
     * @param   int     $length String length.
     * @return  string
     */
    static public function random($length)
    {
        $word = '';
        $n = (int) $length;
        while ($n--)
            $word .= chr((rand() % 26) + ord('a'));
        return $word;
    }

    /**
     * Truncate text to n-words.
     * @param   string  $text   Text
     * @param   $nWords int
     * @return  string
     */
    static public function truncateWords($text, $nWords)
    {
        $array = mb_split(' ', strip_tags($text), $nWords);
        array_pop($array);
        $text = '';
        foreach ($array as $element)
            $text .= $element.' ';
        return $text.' ...';
    }
    
    /**
     * Convert query to MySQL full text search expresion.
     * @param   string  $query Pattern.
     * @return  string
     */
    static public function mysqlFtsQuery($query, $preMark = null, $postMark = null)
    {
        if (strlen($query) == 0)
            return '';
        $array = mb_split(' ', strip_tags($query));
        $sql = '';
        $prefix = '';
        foreach ($array as $element) {
            $sql .= $prefix.'+'.$preMark.$element.$postMark;
            $prefix = ' ';
        }
        return $sql;
    }
    
    /**
     * Get file name extension.
     * @param   string  $filename
     * @return  string|null
     */
    static public function getFileNameExtension($filename) 
    {
        $pos = strrpos($filename, '.');
            if ($pos === false)
                return null;
        return trim(substr($filename, $pos), '.');      
    }

}
