<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default configuration for FPDF
    |--------------------------------------------------------------------------
    |
    | Specify the default values for creating a PDF with FPDF
    |
    */

    'orientation'   => 'P',
    'unit'          => 'cm',
    'size'          => 'A4',
    'format'        => 'A4', // See https://mpdf.github.io/paging/page-size-orientation.html
    'author'        => 'Digihealth',
    'subject'       => 'Dokument ini di cetak dari SISFO Rumah Sakit .',
    'keywords'      => 'PDF, Laravel, Package, Peace', // Separate values with comma
    'creator'       => 'Digihealth',
    'display_mode'  => 'fullpage'

];
