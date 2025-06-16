<?php
function format_nomor($nomor)
{
    $nomor = preg_replace('/[^0-9]/', '', $nomor);
    if (substr($nomor, 0, 1) === '0') {
        $nomor = '62' . substr($nomor, 1);
    }

    $kode = substr($nomor, 2, 3);
    $bag1 = substr($nomor, 5, 4);
    $bag2 = substr($nomor, 9, 5);

    return '+62 ' . $kode . '-' . $bag1 . '-' . $bag2;
}
