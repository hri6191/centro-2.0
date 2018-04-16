<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename='', $print, $stream=TRUE) 
{
    require_once("dompdf/dompdf_config.inc.php");

    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper('A4', 'portrait');
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf", $print);
    } else {
        return $dompdf->output();
    }
}
?>