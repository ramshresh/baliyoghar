<?php
/**
 * Created by PhpStorm.
 * User: RamS-NSET
 * Date: 5/31/2017
 * Time: 1:14 PM
 */

if ( ! function_exists('number_to_english_month'))
{
    function numToEngMonth($month_number){
        $months = array(
            '1'=>'Jan',
            '2'=>'Feb',
            '3'=>'Mar',
            '4'=>'Apr',
            '5'=>'May',
            '6'=>'Jun',
            '7'=>'Jul',
            '8'=>'Aug',
            '9'=>'Sep',
            '10'=>'Oct',
            '11'=>'Nov',
            '12'=>'Dec',
        );
        return (isset($months[$month_number]))?$months[$month_number]:false;
    }

}