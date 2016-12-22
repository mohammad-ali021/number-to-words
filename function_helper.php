<?php

if(! function_exists('convert_number_to_words'))
{

    function change_number_to_words($number,$lang='en') 
    {
       if($lang=='dr'){
            $hyphen      = ' ';
            $conjunction = ' و ';
            $separator   = 'و ';
            $negative    = 'منفی ';
            $decimal     = ' اعشاریه ';
            $dictionary  = array(
                0                   => 'صفر',
                1                   => 'یک',
                2                   => 'دو',
                3                   => 'سه',
                4                   => 'چهار',
                5                   => 'پنج',
                6                   => 'شش',
                7                   => 'هفت',
                8                   => 'هشت',
                9                   => 'نه',
                10                  => 'ده',
                11                  => 'یازده',
                12                  => 'دوازده',
                13                  => 'سیزده',
                14                  => 'چهارده',
                15                  => 'پانزده',
                16                  => 'شانزده',
                17                  => 'هفده',
                18                  => 'هجده',
                19                  => 'نوزده',
                20                  => 'بیست',
                30                  => 'سی',
                40                  => 'چهل',
                50                  => 'چنجاه',
                60                  => 'شصت',
                70                  => 'هفتاد',
                80                  => 'هشتاد',
                90                  => 'نود',
                100                 => 'صد',
                1000                => 'هزار',
                1000000             => 'میلیون',
                1000000000          => 'ملیارد',
                1000000000000       => 'تریلیون',
                1000000000000000    => 'کادریلیون ',
                1000000000000000000 => 'کوینتیلیون'
            );
       }else if($lang=='en'){
            $hyphen      = '-';
            $conjunction = ' and ';
            $separator   = ', ';
            $negative    = 'negative ';
            $decimal     = ' point ';
            $dictionary  = array(
                0                   => 'zero',
                1                   => 'one',
                2                   => 'two',
                3                   => 'three',
                4                   => 'four',
                5                   => 'five',
                6                   => 'six',
                7                   => 'seven',
                8                   => 'eight',
                9                   => 'nine',
                10                  => 'ten',
                11                  => 'eleven',
                12                  => 'twelve',
                13                  => 'thirteen',
                14                  => 'fourteen',
                15                  => 'fifteen',
                16                  => 'sixteen',
                17                  => 'seventeen',
                18                  => 'eighteen',
                19                  => 'nineteen',
                20                  => 'twenty',
                30                  => 'thirty',
                40                  => 'fourty',
                50                  => 'fifty',
                60                  => 'sixty',
                70                  => 'seventy',
                80                  => 'eighty',
                90                  => 'ninety',
                100                 => 'hundred',
                1000                => 'thousand',
                1000000             => 'million',
                1000000000          => 'billion',
                1000000000000       => 'trillion',
                1000000000000000    => 'quadrillion',
                1000000000000000000 => 'quintillion'
                );
       }else if($lang=='pa'){
            $hyphen      = ' ';
            $conjunction = ' ';
            $separator   = 'او  ';
            $negative    = 'منفی ';
            $decimal     = ' اعشاریه ';
            $dictionary  = array(
                0                   => 'صفر',
                1                   => 'یو',
                2                   => 'دوه',
                3                   => 'درې',
                4                   => 'څلور',
                5                   => 'پنځه',
                6                   => 'شپږ',
                7                   => 'اووه',
                8                   => 'اته',
                9                   => 'نه',
                10                  => 'لس',
                11                  => 'یولس',
                12                  => 'دوولس',
                13                  => 'دیارلس',
                14                  => 'څوارلس',
                15                  => 'پنځلس',
                16                  => 'شپاړلس',
                17                  => 'اوولس',
                18                  => 'اتلس',
                19                  => 'نولس',
                20                  => 'شل',
                30                  => 'دیرش',
                40                  => 'څلویښت',
                50                  => 'پنځوس',
                60                  => 'شپیته',
                70                  => 'اویا',
                80                  => 'اتیا',
                90                  => 'نوي',
                100                 => 'سوه',
                1000                => 'زره',
                1000000             => 'میلیونه',
                1000000000          => 'ملیارده',
                1000000000000       => 'تریلیونه',
                1000000000000000    => 'کادریلیونه',
                1000000000000000000 => 'کوینتیلیونه'
            );

       }
       
        if (!is_numeric($number)) {
            return false;
        }
       
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . change_number_to_words(abs($number),$lang);
        }
       
        $string = $fraction = null;
       
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
       
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                if($lang=='pa'){
                    if ($units) {
                        $string=$dictionary[$units];
                        $string .= $hyphen . $dictionary[$tens];
                    }else{
                        $string=$dictionary[$tens];
                    }
                }else{
                $string=$dictionary[$tens];
                    if ($units) {
                        $string .= $hyphen . $dictionary[$units];
                    }   
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . change_number_to_words($remainder,$lang);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = change_number_to_words($numBaseUnits,$lang) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? " ".$conjunction : " ".$separator;
                    $string .= change_number_to_words($remainder,$lang);
                }
                break;
        }
       
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
       
        return $string;
    }
}

?>
