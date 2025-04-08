<?php
function getCantidadFormateada($cantidad, $locale = 'de_DE')
{
    $fmt = new \NumberFormatter($locale, \NumberFormatter::DECIMAL);
    $fmt->setAttribute(\NumberFormatter::FRACTION_DIGITS, 2);
    return $fmt->format($cantidad);
}