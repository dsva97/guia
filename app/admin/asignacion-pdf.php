<?php

use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
require_once 'server/functions.php';
require_once 'server/vendor/autoload.php';
require_once '../bd/conexion.php';
require_once 'server/models/Asignaciones.php';


if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $database = new Database();

    $mdlAsignaciones = new Asignaciones($database);

    ob_start();

    $aryAsig  = $mdlAsignaciones->fncGetAsignaciones(["idasignacion" => $id]);
    
    if (!fncValidateArray($aryAsig)) {
        fncException("Error. No se encontro datos sobre la asignacion problablemente se haya eliminado o no exista. Porfavor verifique.");
    }
    
    $aryAsig    = $aryAsig[0];
    $aryDetalle = $mdlAsignaciones->fncGetAsignacionBienes(["idasignacion" => $id]);

    require_once 'template-asignacion-pdf.php';

    $html = ob_get_contents();
    ob_end_clean();

    // echo $html;

    // exit;



    $mpdf = new \Mpdf\Mpdf();
    $mpdf->debug = true;
    $mpdf->WriteHTML($html);
    $mpdf->Output();
} else {
    exit("No se pudo ubicar el id");
}
