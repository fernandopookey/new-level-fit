<?php

function formatRupiah($nominal, $prefix = null)
{
    $prefix = $prefix ? $prefix : 'Rp. ';
    return $prefix . number_format($nominal, 0, ',', '.');
}

function DateFormat($date, $format)
{
    return \Carbon\Carbon::parse($date)->isoFormat($format);
}

function DateDiff($oldDate, $newDate)
{
    $oldDate = \Carbon\Carbon::parse($oldDate);
    $newDate = \Carbon\Carbon::parse($newDate);

    return $oldDate->diffInDays($newDate);
}
