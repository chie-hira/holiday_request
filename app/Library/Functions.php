<?php 

namespace App\Library;

class Functions
{
    public static function remainingDaysOnly($remaining_days)
    {
        $exp = explode('.', $remaining_days);
        return $exp[0];
    }

    public static function remainingHours($remaining_days)
    {
        $exp = explode('.', $remaining_days);
        $exp_key1 = array_key_exists(1, $exp);
        if ($exp_key1) {
            $decimal_p = '0.'. $exp[1];
            return $decimal_p * 8; # 8時間で1日
        } else {
            return 0;
        }
    }
}

?>
