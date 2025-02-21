<?php

function normalisasi($nilai, $total)
{
    return $nilai / sqrt($total);
}

function kedekatan($positif, $negatif)
{
    return $negatif / ($negatif + $positif);
}