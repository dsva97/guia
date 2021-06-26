<?php



try {
    try {
        require_once '../../bd/conexion.php';

        require_once "models/Asignaciones.php";
        require_once "models/Devoluciones.php";

        require_once "models/Usuario.php";
        require_once "models/Bienes.php";
        require_once "models/Destinos.php";
        require_once "models/Responsables.php";

        require_once "models/LugarOrigen.php";
        require_once "models/ResponsablesOrigen.php";



        require_once 'functions.php';
    } catch (\Throwable $t) {
        echo "caught!\n";

        echo $t->getMessage(), " at ", $t->getFile(), ":", $t->getLine(), "\n";
    }



    $controller = isset($_REQUEST["controller"]) ? $_REQUEST["controller"] : $_REQUEST["controller"];
    $action     = isset($_REQUEST["action"]) ? $_REQUEST["action"] : $_REQUEST["action"];
    $database   = new Database();

    switch ($controller) {

        case "bienes":

            $mdlBienes  = new Bienes($database);
            $mdlAsig  = new Asignaciones($database);
            switch ($action) {
                case "crear":

                    $nIdRegistro        = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    $cod_patrimonio     = isset($_POST['cod_patrimonio']) ? $_POST['cod_patrimonio'] : null;
                    $descripcion        = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
                    $cod_inventario     = isset($_POST['cod_inventario']) ? $_POST['cod_inventario'] : null;
                    $marca              = isset($_POST['marca']) ? $_POST['marca'] : null;

                    $modelo             = isset($_POST['modelo']) ? $_POST['modelo'] : null;
                    $serie              = isset($_POST['serie']) ? $_POST['serie'] : null;
                    $estado_bien        = isset($_POST['estado_bien']) ? $_POST['estado_bien'] : null;

                    $estado             = isset($_POST['estado']) ? $_POST['estado'] : null;

                    // Valida valores del formulario
                    if (is_null($nIdRegistro)) {
                        fncException('Error. Existen valores vacios. Por favor verifique.');
                    }

                    $nIdBienNew = null;

                    // Crear
                    if ($nIdRegistro == 0) {
                        $nIdBienNew = $mdlBienes->fncGrabarRegistro(
                            $cod_patrimonio,
                            $descripcion,
                            $cod_inventario,
                            $marca,
                            $modelo,
                            $serie,
                            $estado_bien,
                            $estado
                        );
                    } else {

                        //Actualizar
                        $mdlBienes->fncActualizarRegistro(
                            $nIdRegistro,
                            $cod_patrimonio,
                            $descripcion,
                            $cod_inventario,
                            $marca,
                            $modelo,
                            $serie,
                            $estado_bien,
                            $estado
                        );
                    }

                    $sSuccess =  $nIdRegistro == 0 ? 'Bien registrado exitosamente...' : 'Bien actualizado exitosamente...';

                    json(array("success" => $sSuccess, "nIdBienNew" => $nIdBienNew));




                    break;
                case  "mostrar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $aryData = $mdlBienes->fncGetBienes(["id" => $nIdRegistro]);

                    json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null));

                    break;
                case  "eliminar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $mdlBienes->fncEliminarRegistro($nIdRegistro);
                    json(array("success" => 'Bien eliminado exitosamente.'));
                    break;
                case "populate":

                    // Valida valores del formulario
                    $aryRows  = [];
                    $aryData  = $mdlBienes->fncGetBienes();


                    if (fncValidateArray($aryData)) {
                        foreach ($aryData as $key => $aryLoop) {
                            $sActionShow      = "fncMostrarB(" . $aryLoop['id'] . ", 'ver' );";
                            $sActionEdit      = "fncMostrarB(" . $aryLoop['id'] . ", 'editar' );";
                            $sActionEliminar  = "fncVerificarEliminarBien(" . $aryLoop['id'] . ");";


                            $sLinkShow   = '<button onclick="' . $sActionShow . '" class="btn  ">Ver</button>';
                            $sLinkEdit   = '<button onclick="' . $sActionEdit . '" class="btn  ">Editar</button>';
                            $sLinkDelete = '<button onclick="' . $sActionEliminar . '" class="btn  ">Eliminar</button>';


                            $sAcciones = '<div class="content-acciones">' . $sLinkShow . ' ' . $sLinkEdit . '' . $sLinkDelete . '</div>';

                            $aryRows[] = [
                                ($key + 1),
                                $aryLoop["cod_patrimonio"],
                                $aryLoop["descripcion"],
                                $aryLoop["cod_inventario"],
                                $aryLoop["marca"],
                                $aryLoop["modelo"],
                                $aryLoop["serie"],
                                $aryLoop["nombre_estado_bien"],
                                // $aryLoop["f_registro"],
                                // $aryLoop["f_modifica"],
                                $aryLoop["estado"] == 1 ? "ACTIVO" : "DESACTIVO",
                                $sAcciones
                            ];
                        }
                    }
                    json(array("data" => $aryRows));

                    break;

                case "obtenerBienesDisponibles":

                    // Valida valores del formulario
                    $aryRows  = [];

                    $aryDetalle = $mdlAsig->fncGetAsignacionBienes();

                    $aryNotId   = fncValidateArray($aryDetalle) ? array_unique(array_column($aryDetalle, "idbien")) : [];

                    $aryData    = $mdlBienes->fncGetBienes(["aryNotId" => $aryNotId]);

                    json(array("success" => "Mostrando resultados obtenidos..", "aryData" => $aryData));

                    break;
            }


            break;


        case 'asignaciones':

            $mdlAsig  = new Asignaciones($database);

            switch ($action) {
                case "crear":

                    $nIdRegistro              = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    $id_lugar_origen          = isset($_POST['id_lugar_origen']) ? $_POST['id_lugar_origen'] : null;
                    $id_responsable_origen    = isset($_POST['id_responsable_origen']) ? $_POST['id_responsable_origen'] : null;
                    $id_destino               = isset($_POST['id_destino']) ? $_POST['id_destino'] : null;
                    $id_responsable_destino   = isset($_POST['id_responsable_destino']) ? $_POST['id_responsable_destino'] : null;
                    $motivo                   = isset($_POST['motivo']) ? $_POST['motivo'] : null;
                    $otro                     = isset($_POST['otro']) ? $_POST['otro'] : null;

                    $aryDetalle               = isset($_POST['aryDetalle']) ? $_POST['aryDetalle'] : null;
                    $devuelto                 = isset($_POST['devuelto']) ? $_POST['devuelto'] : null;
                    $estado                   = isset($_POST['estado']) ? $_POST['estado'] : null;

                    // Valida valores del formulario
                    if (is_null($nIdRegistro)) {
                        fncException('Error. Existen valores vacios. Por favor verifique.');
                    }

                    $nIdAsigNew = null;

                    // Crear
                    if ($nIdRegistro == 0) {
                        $nIdAsigNew = $mdlAsig->fncGrabarRegistro(

                            $id_lugar_origen,
                            $id_responsable_origen,
                            $id_destino,
                            $id_responsable_destino,
                            $motivo,
                            $otro,
                            $devuelto,
                            $estado

                        );


                        if (fncValidateArray($aryDetalle)) {
                            foreach ($aryDetalle as $aryLoop) {
                                $mdlAsig->fncGrabarAsigBien(
                                    $nIdAsigNew,
                                    $aryLoop["idbien"],
                                    $aryLoop["nombrebien"],
                                    $estado
                                );
                            }
                        }
                    } else {

                        //Actualizar
                        $mdlAsig->fncActualizarRegistro(
                            $idasignacion,
                            $id_lugar_origen,
                            $id_responsable_origen,
                            $id_destino,
                            $id_responsable_destino,
                            $motivo,
                            $otro,
                            $devuelto,
                            $estado
                        );

                        $mdlAsig->fncEliminarByAsig($nIdRegistro);

                        if (fncValidateArray($aryDetalle)) {
                            foreach ($aryDetalle as $aryLoop) {
                                $mdlAsig->fncGrabarAsigBien(
                                    $nIdAsigNew,
                                    $aryLoop["idbien"],
                                    $aryLoop["nombrebien"],
                                    $estado
                                );
                            }
                        }
                    }

                    $sSuccess =  $nIdRegistro == 0 ? 'Asignacion registrado exitosamente...' : 'Asignacion actualizado exitosamente...';

                    json(array("success" => $sSuccess, "nIdAsigNew" => $nIdAsigNew));

                    break;
                case  "mostrar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $aryData    = $mdlAsig->fncGetAsignaciones(["idasignacion" => $nIdRegistro]);
                    $aryDetalle = $mdlAsig->fncGetAsignacionBienes(["idasignacion" => $nIdRegistro]);

                    json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null, "aryDetalle" => $aryDetalle));

                    break;
                case  "eliminar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $mdlAsig->fncEliminarRegistro($nIdRegistro);
                    json(array("success" => 'Bien eliminado exitosamente.'));
                    break;

                case  "devolver":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    $devuelto = isset($_POST['devuelto']) ? $_POST['devuelto'] : null;

                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $mdlAsig->fncActualizarDevolucion($nIdRegistro, $devuelto);
                    json(array("success" => 'Asignación devuelta exitosamente.'));
                    break;

                case "populate":

                    // Valida valores del formulario
                    $aryRows  = [];
                    $aryData  = $mdlAsig->fncGetAsignaciones();


                    if (fncValidateArray($aryData)) {
                        foreach ($aryData as $key => $aryLoop) {
                            $sActionShow      = "fncMostrarA(" . $aryLoop['idasignacion'] . ", 'ver' );";
                            $sActionEdit      = "fncMostrarA(" . $aryLoop['idasignacion'] . ", 'editar' );";
                            $sActionEliminar  = "fncVerificarEliminarA(" . $aryLoop['idasignacion'] . ");";

                            $sUrlPdf   = "asignacion-pdf.php?id=" . $aryLoop["idasignacion"];

                            $sLinkPDF   = '<a target="_blank" href="' . $sUrlPdf . '" class="btn  ">Ver PDF</a>';

                            $sLinkShow   = '<button onclick="' . $sActionShow . '" class="btn  ">Ver</button>';
                            $sLinkEdit   = '<button onclick="' . $sActionEdit . '" class="btn  ">Editar</button>';
                            $sLinkDelete = '<button onclick="' . $sActionEliminar . '" class="btn  ">Eliminar</button>';


                            $sAcciones = '<div class="content-acciones">' . $sLinkPDF . $sLinkShow  . $sLinkDelete . '</div>';

                            $aryRows[] = [
                                ($key + 1),
                                sp($aryLoop["idasignacion"]),
                                $aryLoop["lugar_origen"],
                                $aryLoop["resposable_origen"],
                                $aryLoop["destino"],
                                $aryLoop["responsable_destino"],
                                $aryLoop["motivo"],
                                //$aryLoop["f_creacion"],
                                // $aryLoop["f_modificar"],
                                //$aryLoop["estado"] == 1 ? "ACTIVO" : "DESACTIVO",
                                $aryLoop["devuelto"] == 1 ? "DEVUELTO" : "NO DEVUELTO",
                                $sAcciones
                            ];
                        }
                    }

                    json(array("data" => $aryRows));

                    break;


                    case "populateNoDevuelto":

                    // Valida valores del formulario
                    $aryRows  = [];
                    $aryData  = $mdlAsig->fncGetAsignaciones(["devuelto" => 0]);
                    //$aryData    = $mdlAsig->fncGetAsignacionesDevoluciones(["idasignacion" => $nIdRegistro]);


                    if (fncValidateArray($aryData)) {
                        foreach ($aryData as $key => $aryLoop) {
                            $sActionShow      = "fncMostrarA(" . $aryLoop['idasignacion'] . ", 'ver' );";
                            $sActionEdit      = "fncMostrarA(" . $aryLoop['idasignacion'] . ", 'editar' );";
                            $sActionEliminar  = "fncVerificarDevolverA(" . $aryLoop['idasignacion'] . ");";

                            $sUrlPdf   = "asignacion-pdf.php?id=" . $aryLoop["idasignacion"];

                            $sLinkPDF   = '<a target="_blank" href="' . $sUrlPdf . '" class="btn  ">Ver PDF</a>';

                            $sLinkShow   = '<button onclick="' . $sActionShow . '" class="btn  ">Ver</button>';
                            $sLinkEdit   = '<button onclick="' . $sActionEdit . '" class="btn  ">Editar</button>';
                            $sLinkDelete = '<button onclick="' . $sActionEliminar . '" class="btn  ">Devolver</button>';


                            $sAcciones = '<div class="content-acciones">' . $sLinkPDF . $sLinkShow  . $sLinkDelete . '</div>';

                            $aryRows[] = [
                                ($key + 1),
                                sp($aryLoop["idasignacion"]),
                                $aryLoop["lugar_origen"],
                                $aryLoop["resposable_origen"],
                                $aryLoop["destino"],
                                $aryLoop["responsable_destino"],
                                $aryLoop["motivo"],
                                //$aryLoop["f_creacion"],
                                // $aryLoop["f_modificar"],
                                //$aryLoop["estado"] == 1 ? "ACTIVO" : "DESACTIVO",
                                $aryLoop["devuelto"] == 1 ? "DEVUELTO" : "NO DEVUELTO",
                                $sAcciones
                            ];
                        }
                    }

                    json(array("data" => $aryRows));

                    break;                
            }




            break;



        case 'devoluciones':

            $mdlAsig  = new Devoluciones($database);

            switch ($action) {
                case "crear":

                    $nIdRegistro              = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    $id_lugar_origen          = isset($_POST['id_lugar_origen']) ? $_POST['id_lugar_origen'] : null;
                    $id_responsable_origen    = isset($_POST['id_responsable_origen']) ? $_POST['id_responsable_origen'] : null;
                    $id_destino               = isset($_POST['id_destino']) ? $_POST['id_destino'] : null;
                    $id_responsable_destino   = isset($_POST['id_responsable_destino']) ? $_POST['id_responsable_destino'] : null;
                    $motivo                   = isset($_POST['motivo']) ? $_POST['motivo'] : null;
                    $otro                     = isset($_POST['otro']) ? $_POST['otro'] : null;

                    $aryDetalle               = isset($_POST['aryDetalle']) ? $_POST['aryDetalle'] : null;
                    $devuelto                 = isset($_POST['devuelto']) ? $_POST['devuelto'] : null;
                    $estado                   = isset($_POST['estado']) ? $_POST['estado'] : null;

                    // Valida valores del formulario
                    if (is_null($nIdRegistro)) {
                        fncException('Error. Existen valores vacios. Por favor verifique.');
                    }

                    $nIdAsigNew = null;

                    // Crear
                    if ($nIdRegistro == 0) {
                        $nIdAsigNew = $mdlAsig->fncGrabarRegistro(

                            $id_lugar_origen,
                            $id_responsable_origen,
                            $id_destino,
                            $id_responsable_destino,
                            $motivo,
                            $otro,
                            $devuelto,
                            $estado

                        );


                        if (fncValidateArray($aryDetalle)) {
                            foreach ($aryDetalle as $aryLoop) {
                                $mdlAsig->fncGrabarAsigBien(
                                    $nIdAsigNew,
                                    $aryLoop["idbien"],
                                    $aryLoop["nombrebien"],
                                    $estado
                                );
                            }
                        }
                    } else {

                        //Actualizar
                        $mdlAsig->fncActualizarRegistro(
                            $idasignacion,
                            $id_lugar_origen,
                            $id_responsable_origen,
                            $id_destino,
                            $id_responsable_destino,
                            $motivo,
                            $otro,
                            $devuelto,
                            $estado
                        );

                        $mdlAsig->fncEliminarByAsig($nIdRegistro);

                        if (fncValidateArray($aryDetalle)) {
                            foreach ($aryDetalle as $aryLoop) {
                                $mdlAsig->fncGrabarAsigBien(
                                    $nIdAsigNew,
                                    $aryLoop["idbien"],
                                    $aryLoop["nombrebien"],
                                    $estado
                                );
                            }
                        }
                    }

                    $sSuccess =  $nIdRegistro == 0 ? 'Devolucion registrado exitosamente...' : 'Devolucion actualizado exitosamente...';

                    json(array("success" => $sSuccess, "nIdAsigNew" => $nIdAsigNew));

                    break;
                case  "mostrar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $aryData    = $mdlAsig->fncGetAsignacionesDevoluciones(["idasignacion" => $nIdRegistro]);
                    $aryDetalle = $mdlAsig->fncGetAsignacionBienes(["idasignacion" => $nIdRegistro]);

                    json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null, "aryDetalle" => $aryDetalle));

                    break;
                case  "eliminar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $mdlAsig->fncEliminarRegistro($nIdRegistro);
                    json(array("success" => 'Devolucion eliminado exitosamente.'));
                    break;
                
                case "populate":

                    // Valida valores del formulario
                    $aryRows  = [];
                    $aryData  = $mdlAsig->fncGetAsignacionesDevoluciones(["devuelto" => 1]);


                    if (fncValidateArray($aryData)) {
                        foreach ($aryData as $key => $aryLoop) {
                            $sActionShow      = "fncMostrarA(" . $aryLoop['idasignacion'] . ", 'ver' );";
                            $sActionEdit      = "fncMostrarA(" . $aryLoop['idasignacion'] . ", 'editar' );";
                            $sActionEliminar  = "fncVerificarEliminarA(" . $aryLoop['idasignacion'] . ");";

                            $sUrlPdf   = "asignacion-pdf.php?id=" . $aryLoop["idasignacion"];

                            $sLinkPDF   = '<a target="_blank" href="' . $sUrlPdf . '" class="btn  ">Ver PDF</a>';

                            $sLinkShow   = '<button onclick="' . $sActionShow . '" class="btn  ">Ver</button>';
                            $sLinkEdit   = '<button onclick="' . $sActionEdit . '" class="btn  ">Editar</button>';
                            $sLinkDelete = '<button onclick="' . $sActionEliminar . '" class="btn  ">Eliminar</button>';


                            $sAcciones = '<div class="content-acciones">' . $sLinkPDF . $sLinkShow  . $sLinkDelete . '</div>';

                            $aryRows[] = [
                                ($key + 1),
                                sp($aryLoop["idasignacion"]),
                                $aryLoop["lugar_origen"],
                                $aryLoop["resposable_origen"],
                                $aryLoop["destino"],
                                $aryLoop["responsable_destino"],
                                //$aryLoop["f_creacion"],
                                // $aryLoop["f_modificar"],
                                $aryLoop["f_creacion"],
                                $aryLoop["f_modificar"],
                                //$aryLoop["devuelto"] == 1 ? "DEVUELTO" : "NO DEVUELTO",
                                $sAcciones
                            ];
                        }
                    }

                    json(array("data" => $aryRows));

                    break;
            }




            break;




        case 'destinos':

            $mdlDestinos  = new Destinos($database);

            switch ($action) {
                case "crear":

                    $nIdRegistro            = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    $dependencia            = isset($_POST['dependencia']) ? $_POST['dependencia'] : null;

                    $estado                 = isset($_POST['estado']) ? $_POST['estado'] : null;

                    // Valida valores del formulario
                    if (is_null($nIdRegistro)) {
                        fncException('Error. Existen valores vacios. Por favor verifique.');
                    }

                    $nIdNew = null;

                    // Crear
                    if ($nIdRegistro == 0) {
                        $nIdNew = $mdlDestinos->fncGrabarRegistro(
                            $dependencia,
                            $estado
                        );
                    } else {

                        //Actualizar
                        $mdlDestinos->fncActualizarRegistro(
                            $nIdRegistro,
                            $dependencia,
                            $estado
                        );
                    }

                    $sSuccess =  $nIdRegistro == 0 ? 'Destino registrado exitosamente...' : 'Destino actualizado exitosamente...';

                    json(array("success" => $sSuccess, "nIdNew" => $nIdNew));

                    break;
                case  "mostrar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $aryData    = $mdlDestinos->fncGetDestinos(["id" => $nIdRegistro]);

                    json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null));

                    break;
                case  "eliminar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $mdlDestinos->fncEliminarRegistro($nIdRegistro);
                    json(array("success" => 'Bien eliminado exitosamente.'));
                    break;
                case "populate":

                    // Valida valores del formulario
                    $aryRows  = [];
                    $aryData  = $mdlDestinos->fncGetDestinos();


                    if (fncValidateArray($aryData)) {
                        foreach ($aryData as $key => $aryLoop) {
                            $sActionShow      = "fncMostrarD(" . $aryLoop['id'] . ", 'ver' );";
                            $sActionEdit      = "fncMostrarD(" . $aryLoop['id'] . ", 'editar' );";
                            $sActionEliminar  = "fncVerificarEliminarD(" . $aryLoop['id'] . ");";



                            $sLinkShow   = '<button onclick="' . $sActionShow . '" class="btn  ">Ver</button>';
                            $sLinkEdit   = '<button onclick="' . $sActionEdit . '" class="btn  ">Editar</button>';
                            $sLinkDelete = '<button onclick="' . $sActionEliminar . '" class="btn  ">Eliminar</button>';


                            $sAcciones = '<div class="content-acciones">' . $sLinkShow . $sLinkEdit  . $sLinkDelete . '</div>';

                            $aryRows[] = [
                                ($key + 1),
                                $aryLoop["dependencia"],
                                $aryLoop["estado"] == 1 ? "ACTIVO" : "DESACTIVO",
                                $sAcciones
                            ];
                        }
                    }

                    json(array("data" => $aryRows));

                    break;
            }




            break;

        case 'responsables':

            $mdlResponsable  = new Responsables($database);

            switch ($action) {
                case "crear":

                    $nIdRegistro            = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    $nombre                 = isset($_POST['nombre']) ? $_POST['nombre'] : null;
                    $id_destino             = isset($_POST['id_destino']) ? $_POST['id_destino'] : null;

                    $estado                 = isset($_POST['estado']) ? $_POST['estado'] : null;

                    // Valida valores del formulario
                    if (is_null($nIdRegistro)) {
                        fncException('Error. Existen valores vacios. Por favor verifique.');
                    }

                    $nIdNew = null;

                    // Crear
                    if ($nIdRegistro == 0) {
                        $nIdNew = $mdlResponsable->fncGrabarRegistro(
                            $nombre,
                            $id_destino,
                            $estado
                        );
                    } else {

                        //Actualizar
                        $mdlResponsable->fncActualizarRegistro(
                            $nIdRegistro,
                            $nombre,
                            $id_destino,
                            $estado
                        );
                    }

                    $sSuccess =  $nIdRegistro == 0 ? 'Responsable registrado exitosamente...' : 'Responsable actualizado exitosamente...';

                    json(array("success" => $sSuccess, "nIdNew" => $nIdNew));

                    break;
                case  "mostrar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $aryData    = $mdlResponsable->fncGetResponsable(["id" => $nIdRegistro]);

                    json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null));

                    break;
                case  "eliminar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $mdlResponsable->fncEliminarRegistro($nIdRegistro);
                    json(array("success" => 'Bien eliminado exitosamente.'));
                    break;
                case "populate":

                    // Valida valores del formulario
                    $aryRows  = [];
                    $aryData  = $mdlResponsable->fncGetResponsable();


                    if (fncValidateArray($aryData)) {
                        foreach ($aryData as $key => $aryLoop) {
                            $sActionShow      = "fncMostrarR(" . $aryLoop['id'] . ", 'ver' );";
                            $sActionEdit      = "fncMostrarR(" . $aryLoop['id'] . ", 'editar' );";
                            $sActionEliminar  = "fncVerificarEliminarR(" . $aryLoop['id'] . ");";



                            $sLinkShow   = '<button onclick="' . $sActionShow . '" class="btn  ">Ver</button>';
                            $sLinkEdit   = '<button onclick="' . $sActionEdit . '" class="btn  ">Editar</button>';
                            $sLinkDelete = '<button onclick="' . $sActionEliminar . '" class="btn  ">Eliminar</button>';


                            $sAcciones = '<div class="content-acciones">' . $sLinkShow . $sLinkEdit  . $sLinkDelete . '</div>';

                            $aryRows[] = [
                                ($key + 1),
                                $aryLoop["nombre"],
                                $aryLoop["dependencia"],
                                $sAcciones
                            ];
                        }
                    }

                    json(array("data" => $aryRows));

                    break;
                case "getResponsableByDestino":

                    $id_destino = isset($_POST['id_destino']) ? $_POST['id_destino'] : null;

                    // Valida valores del formulario
                    $aryData  = $mdlResponsable->fncGetResponsable(["id_destino" => $id_destino]);
                    json(array("success" => "Mostrando resultados..", "aryData" => $aryData));
                break;
            }




            break;


        case 'responsablesOrigen':

            $mdlResponsableO  = new ResponsablesOrigen($database);

            switch ($action) {
                case "crear":

                    $nIdRegistro            = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    $nombre                 = isset($_POST['nombre']) ? $_POST['nombre'] : null;
                    $idlugarorigen          = isset($_POST['idlugarorigen']) ? $_POST['idlugarorigen'] : null;

                    $estado                 = isset($_POST['estado']) ? $_POST['estado'] : null;

                    // Valida valores del formulario
                    if (is_null($nIdRegistro)) {
                        fncException('Error. Existen valores vacios. Por favor verifique.');
                    }

                    $nIdNew = null;

                    // Crear
                    if ($nIdRegistro == 0) {
                        $nIdNew = $mdlResponsableO->fncGrabarRegistro(
                            $nombre,
                            $idlugarorigen,
                            $estado
                        );
                    } else {

                        //Actualizar
                        $mdlResponsableO->fncActualizarRegistro(
                            $nIdRegistro,
                            $nombre,
                            $idlugarorigen,
                            $estado
                        );
                    }

                    $sSuccess =  $nIdRegistro == 0 ? 'Responsable registrado exitosamente...' : 'Responsable actualizado exitosamente...';

                    json(array("success" => $sSuccess, "nIdNew" => $nIdNew));

                    break;
                case  "mostrar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $aryData    = $mdlResponsableO->fncGetResponsable(["id" => $nIdRegistro]);

                    json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null));

                    break;
                case  "eliminar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $mdlResponsableO->fncEliminarRegistro($nIdRegistro);
                    json(array("success" => 'Bien eliminado exitosamente.'));
                    break;
                case "populate":

                    // Valida valores del formulario
                    $aryRows  = [];
                    $aryData  = $mdlResponsableO->fncGetResponsable();


                    if (fncValidateArray($aryData)) {
                        foreach ($aryData as $key => $aryLoop) {
                            $sActionShow      = "fncMostrarR(" . $aryLoop['id'] . ", 'ver' );";
                            $sActionEdit      = "fncMostrarR(" . $aryLoop['id'] . ", 'editar' );";
                            $sActionEliminar  = "fncVerificarEliminarR(" . $aryLoop['id'] . ");";


                            $sLinkShow   = '<button onclick="' . $sActionShow . '" class="btn  ">Ver</button>';
                            $sLinkEdit   = '<button onclick="' . $sActionEdit . '" class="btn  ">Editar</button>';
                            $sLinkDelete = '<button onclick="' . $sActionEliminar . '" class="btn  ">Eliminar</button>';


                            $sAcciones = '<div class="content-acciones">' . $sLinkShow . $sLinkEdit  . $sLinkDelete . '</div>';

                            $aryRows[] = [
                                ($key + 1),
                                $aryLoop["nombre"],
                                $aryLoop["oficina"],
                                $sAcciones
                            ];
                        }
                    }

                    json(array("data" => $aryRows));

                break;

                case "getResponsableByLO":

                    $idlugarorigen = isset($_POST['idlugarorigen']) ? $_POST['idlugarorigen'] : null;
                    
                    // Valida valores del formulario
                    $aryData  = $mdlResponsableO->fncGetResponsable(["idlugarorigen" => $idlugarorigen]);
                    json(array("success" => "Mostrando resultados..", "aryData" => $aryData));

                break;



            }




            break;


        case 'lugar_origen':

            $mdlLO  = new LugarOrigen($database);

            switch ($action) {
                case "crear":

                    $nIdRegistro            = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    $nombre                 = isset($_POST['nombre']) ? $_POST['nombre'] : null;
                    $estado                 = isset($_POST['estado']) ? $_POST['estado'] : null;

                    // Valida valores del formulario
                    if (is_null($nIdRegistro)) {
                        fncException('Error. Existen valores vacios. Por favor verifique.');
                    }

                    $nIdNew = null;

                    // Crear
                    if ($nIdRegistro == 0) {
                        $nIdNew = $mdlLO->fncGrabarRegistro(
                            $nombre,
                            $estado
                        );
                    } else {

                        //Actualizar
                        $mdlLO->fncActualizarRegistro(
                            $nIdRegistro,
                            $nombre,
                            $estado
                        );
                    }

                    $sSuccess =  $nIdRegistro == 0 ? 'Lugar de origen registrado exitosamente...' : 'Lugar de origen  actualizado exitosamente...';

                    json(array("success" => $sSuccess, "nIdNew" => $nIdNew));

                    break;
                case  "mostrar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $aryData    = $mdlLO->fncGetLugarOrigen(["idlugarorigen" => $nIdRegistro]);

                    json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null));

                    break;
                case  "eliminar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $mdlLO->fncEliminarRegistro($nIdRegistro);
                    json(array("success" => 'Lugar de origen eliminado exitosamente.'));
                    break;
                case "populate":

                    // Valida valores del formulario
                    $aryRows  = [];
                    $aryData  = $mdlLO->fncGetLugarOrigen();


                    if (fncValidateArray($aryData)) {
                        foreach ($aryData as $key => $aryLoop) {
                            $sActionShow      = "fncMostrarL(" . $aryLoop['idlugarorigen'] . ", 'ver' );";
                            $sActionEdit      = "fncMostrarL(" . $aryLoop['idlugarorigen'] . ", 'editar' );";
                            $sActionEliminar  = "fncVerificarEliminarL(" . $aryLoop['idlugarorigen'] . ");";


                            $sLinkShow   = '<button onclick="' . $sActionShow . '" class="btn  ">Ver</button>';
                            $sLinkEdit   = '<button onclick="' . $sActionEdit . '" class="btn  ">Editar</button>';
                            $sLinkDelete = '<button onclick="' . $sActionEliminar . '" class="btn  ">Eliminar</button>';


                            $sAcciones = '<div class="content-acciones">' . $sLinkShow . $sLinkEdit  . $sLinkDelete . '</div>';

                            $aryRows[] = [
                                ($key + 1),
                                $aryLoop["nombre"],
                                $aryLoop["estado"] == 1 ? "ACTIVO" : "DESACTIVO",
                                $sAcciones
                            ];
                        }
                    }

                    json(array("data" => $aryRows));

                    break;
            }




            break;

        case 'usuarios':

            $mdlUsuario  = new Usuario($database);

            switch ($action) {
                case "crear":

                    $nIdRegistro            = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    $usuario                 = isset($_POST['usuario']) ? $_POST['usuario'] : null;
                    $password               = isset($_POST['password']) ? $_POST['password'] : null;

                    // Valida valores del formulario
                    if (is_null($nIdRegistro)) {
                        fncException('Error. Existen valores vacios. Por favor verifique.');
                    }

                    $nIdNew = null;

                    // Crear
                    if ($nIdRegistro == 0) {
                        $nIdNew = $mdlUsuario->fncGrabarRegistro(
                            $usuario,
                            $password
                        );
                    } else {

                        //Actualizar
                        $mdlUsuario->fncActualizarRegistro(
                            $nIdRegistro,
                            $usuario,
                            $password
                        );
                    }

                    $sSuccess =  $nIdRegistro == 0 ? 'Usuario registrado exitosamente...' : 'Usuario actualizado exitosamente...';

                    json(array("success" => $sSuccess, "nIdNew" => $nIdNew));

                    break;
                case  "mostrar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $aryData    = $mdlUsuario->fncGetUsuarios(["id" => $nIdRegistro]);

                    json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null));

                    break;
                case  "eliminar":

                    $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

                    // Valida valores del formulario
                    if ($nIdRegistro == null) {
                        fncException('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
                    }

                    $mdlUsuario->fncEliminarRegistro($nIdRegistro);
                    json(array("success" => 'Usuario eliminado exitosamente.'));
                    break;
                case "populate":

                    // Valida valores del formulario
                    $aryRows  = [];
                    $aryData  = $mdlUsuario->fncGetUsuarios();


                    if (fncValidateArray($aryData)) {
                        foreach ($aryData as $key => $aryLoop) {
                            $sActionShow      = "fncMostrarU(" . $aryLoop['id'] . ", 'ver' );";
                            $sActionEdit      = "fncMostrarU(" . $aryLoop['id'] . ", 'editar' );";
                            $sActionEliminar  = "fncVerificarEliminarU(" . $aryLoop['id'] . ");";


                            $sLinkShow   = '<button onclick="' . $sActionShow . '" class="btn  ">Ver</button>';
                            $sLinkEdit   = '<button onclick="' . $sActionEdit . '" class="btn  ">Editar</button>';
                            $sLinkDelete = $aryLoop['id'] == 1  ? '' : '<button onclick="' . $sActionEliminar . '" class="btn  ">Eliminar</button>';


                            $sAcciones = '<div class="content-acciones">' . $sLinkShow . $sLinkEdit  . $sLinkDelete . '</div>';

                            $aryRows[] = [
                                ($key + 1),
                                $aryLoop["usuario"],
                                $sAcciones
                            ];
                        }
                    }

                    json(array("data" => $aryRows));

                    break;
            }



            break;
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
