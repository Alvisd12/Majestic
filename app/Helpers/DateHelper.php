<?php

if (!function_exists('dayNameIndonesian')) {
    /**
     * Convert English day name to Indonesian
     *
     * @param mixed $date
     * @return string
     */
    function dayNameIndonesian($date)
    {
        $englishDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $indonesianDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        $englishDay = \Carbon\Carbon::parse($date)->format('l');
        return str_replace($englishDays, $indonesianDays, $englishDay);
    }
}
