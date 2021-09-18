<?php

namespace App\Utils;

class Utils
{
    public static function maskNumberedList($number, $list, $type = ''){
        return $list[$number];
    }

    public static function formatPrice($price)
    {
      return number_format($price,2,'.',',');
    }

    public static function formatPlural($total, $string){
        if($total > 1){
            if(!(substr($string, -1)=='s')){
                return $string.'s';
            }
        }
        if(substr($string, -1)=='s'){
            return substr($string,0,strlen($string)-1);
        }
        return $string;
    }

    public static function formatDecimal($number){
        $stringNumber = strval($number);
        $numbers = explode('.',$number);
        if(count($numbers) == 1){
            return $numbers[0];
        }
        $newDecimal = floatval($numbers[0].'.'.$numbers[1]);
        if(strpos($numbers[1],'0')!=0){
            $numbers[1] = str_replace('0','',$numbers[1]);
            $newDecimal = floatval($numbers[0].'.'.$numbers[1]);
        }
        return $newDecimal;
    }
}
