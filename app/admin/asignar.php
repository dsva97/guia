<?php
session_start();
require_once '../bd/conexion.php';
require_once 'server/functions.php';

require_once 'server/models/Asignaciones.php';
require_once 'server/models/Responsables.php';
require_once 'server/models/Destinos.php';
require_once 'server/models/Bienes.php';

require_once 'server/models/LugarOrigen.php';
require_once 'server/models/ResponsablesOrigen.php';

$database = new Database();

$mdlResponsable  = new Responsables($database);
$mdlDestinos     = new Destinos($database);
$mdlBienes       = new Bienes($database);
$mdlAsig         = new Asignaciones($database);

$mdlLugarOrigen       = new LugarOrigen($database);
$mdlRspOrigen         = new ResponsablesOrigen($database);


if ($_SESSION["s_usuario"] === null) {
    header("Location: ../index.php");
}


$aryResponsables = $mdlResponsable->fncGetResponsable(["estado" => 1]);
$aryDestinos     = $mdlDestinos->fncGetDestinos(["estado" => 1]);
 
 
$aryDetalle   = $mdlAsig->fncGetAsignacionBienes();

$aryNotId     = fncValidateArray($aryDetalle) ? array_unique(array_column($aryDetalle, "idbien")) : [];

$aryBienes    = $mdlBienes->fncGetBienes(["aryNotId" => $aryNotId]);


$aryLugarOrigen        = $mdlLugarOrigen->fncGetLugarOrigen(["estado" =>1]);
$aryResponsableOrigen  = $mdlRspOrigen->fncGetResponsable(["estado" => 1]);

?>

<!DOCTYPE html>
<html lang="en">
<?php include('metas.php') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css" integrity="sha512-CbQfNVBSMAYmnzP3IC+mZZmYMP2HUnVkV4+PwuhpiMUmITtSpS7Prr3fNncV1RBOnWxzz4pYQ5EAGG4ck46Oig==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<body class="nav-fixed">
    <div class="page-loader">
        <div class="loader-dual-ring"></div>
    </div>
    <?php include('head.php') ?>
    <div id="layoutSidenav">
        <?php include('menu.php') ?>
        <div id="layoutSidenav_content">
            <main>
                <?php include('header.php') ?>
                <div class="container mt-n10">
                    <div class="row">
                        <div class="col-lg-9">
                            <!-- Default Bootstrap Form Controls-->
                            <div id="default">
                                <div class="card mb-4">
                                    <img class="logo" src="../img/iconos/logo-mimpv.png" style="width:400px;">
                                    <div class="card-header">Guía de Desplazamiento de Bienes</div>
                                    <div class="card-body">
                                        <div class="sbp-preview">
                                            <div class="sbp-preview-content">
                                                <form>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6 class="small text-muted font-weight-500">Origen</h6>
                                                                <select id="id_lugar_origen" name="id_lugar_origen" class="form-control">
                                                                    <option value="0">SELECCIONAR</option>
                                                                    <?php if (fncValidateArray($aryLugarOrigen)) : ?>
                                                                        <?php foreach ($aryLugarOrigen as $aryLoop) : ?>
                                                                            <option value="<?= $aryLoop["idlugarorigen"] ?>"><?= strup( $aryLoop["nombre"]) ?></option>
                                                                        <?php endforeach ?>
                                                                    <?php endif ?>
                                                                </select>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="small text-muted font-weight-500">Destino</h6>
                                                                <select id="id_destino" name="id_destino" class="form-control">
                                                                    <option value="0">SELECCIONAR</option>
                                                                    <?php if (fncValidateArray($aryDestinos)) : ?>
                                                                        <?php foreach ($aryDestinos as $aryLoop) : ?>
                                                                            <option value="<?= $aryLoop["id"] ?>"><?= strup($aryLoop["dependencia"]) ?></option>
                                                                        <?php endforeach ?>
                                                                    <?php endif ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col">
                                                                <select id="id_responsable_origen" name="id_responsable_origen" class="form-control">
                                                                    <option value="0">RESPONSABLE ORIGEN</option>
                                                                    <!-- <?php if (fncValidateArray($aryResponsableOrigen)) : ?>
                                                                        <?php foreach ($aryResponsableOrigen as $aryLoop) : ?>
                                                                            <option value="<?= $aryLoop["id"] ?>"><?= strup($aryLoop["nombre"]) ?></option>
                                                                        <?php endforeach ?>
                                                                    <?php endif ?> -->
                                                                </select>
                                                            </div>
                                                            <div class="col">
                                                                <select id="id_responsable_destino" name="id_responsable_destino" class="form-control">
                                                                    <option value="0">RESPONSABLE DESTINO</option>
                                                                    <!-- <?php if (fncValidateArray($aryResponsables)) : ?>
                                                                        <?php foreach ($aryResponsables as $aryLoop) : ?>
                                                                            <option value="<?= $aryLoop["id"] ?>"><?= strup($aryLoop["nombre"]) ?></option>
                                                                        <?php endforeach ?>
                                                                    <?php endif ?>-->
                                                                 </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="sbp-preview-content">
                                                <h6 class="small text-muted font-weight-500">Motivo:</h6>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" id="customRadio1" type="radio" name="customRadio" value="Traslado" />
                                                                <label class="custom-control-label" for="customRadio1">Traslado</label>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" id="customRadio2" type="radio" name="customRadio" value="Reparación" />
                                                                <label class="custom-control-label" for="customRadio2">Reparación</label>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" id="customRadio3" type="radio" name="customRadio" value="Transferencia" />
                                                                <label class="custom-control-label" for="customRadio3">Transferencia</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" id="customRadio4" type="radio" name="customRadio" value="A préstamo" />
                                                                <label class="custom-control-label" for="customRadio4">A préstamo</label>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" id="customRadio5" type="radio" name="customRadio" value="Por baja" />
                                                                <label class="custom-control-label" for="customRadio5">Por baja</label>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" id="customRadio6" type="radio" name="customRadio" value="Uso personal" />
                                                                <label class="custom-control-label" for="customRadio6">Uso personal</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Otro</span>
                                                    </div>
                                                    <textarea id="otro" class="form-control" aria-label="With textarea"></textarea>
                                                </div>
                                            </div>
                                            <div class="sbp-preview-content">
                                                <h6 class="small text-muted font-weight-500">Bienes:</h6>
                                                
                                                <div class="row">
                            
                                                    <div class="col-12 col-md-11">
                                                        <div class="form-group">
                                                            <label for="bienes" class="col-form-label">Agregar Bien <span class="text-danger">*</span> </label>
                                                            <select id="bienes" name="bienes" class="form-control">
                                                                <option value="0">Seleccionar</option>
                                                                <?php if (fncValidateArray($aryBienes)) : ?>
                                                                    <?php foreach ($aryBienes as $aryLoop) : ?>
                                                                        <option data-nombre_estado_bien="<?=$aryLoop["nombre_estado_bien"]?>" data-estado="<?=$aryLoop["estado"]?>" data-descripcion ="<?=$aryLoop["descripcion"]?>" data-cod_patrimonio ="<?=$aryLoop["cod_patrimonio"]?>" value="<?= $aryLoop["id"] ?>">
                                                                                <?=   "Desc : ". $aryLoop["descripcion"] ." | " . "Cod.Patri : " . $aryLoop["cod_patrimonio"] 
                                                                                 . " | ". "Cod.Inve : " . $aryLoop["cod_inventario"] . " | ".
                                                                                 "Marca : " . $aryLoop["marca"] . " | " . " Modelo :  ". $aryLoop["modelo"] . " | "  .
                                                                                  " Serie :  ". $aryLoop["serie"]   
                                                                               ?> 
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                <?php endif ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-1 mb-2">
                                                        <label class="col-form-label d-none d-md-block"> &nbsp; </label>
                                                        <button class="btn btn-info" id="btnAgregarBien"> + </button>
                                                    </div>
                                                </div>  
                                                                        
                                                
                                                <div class="datatable">
                                                    <table class="table table-bordered table-hover" id="tblBienes" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th>Código Patrimonial</th>
                                                                <th>Descripción</th>
                                                                <th>Estado</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                       
                                                        <tbody>
                                                             
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right">
                                                <button id="btnCrearAsignacion" class="btn btn-primary">Guardar</button>
                                            </div>
                                            <div class="sbp-preview-content">



                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="footer mt-auto footer-light">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 small">Copyright &#xA9; Your Website 2021</div>
                        <div class="col-md-6 text-md-right small">
                            <a href="#!">Privacy Policy</a>
                            &#xB7;
                            <a href="#!">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>








     <!-- Modales -->

     

    <!-- Fin de modales -->




    <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/jquery/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="assets/jsdelivr/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="js/functions.js"></script>

    <script src="assets/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="assets/datatables/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <!-- <script src="assets/demo/datatables-demo.js"></script> -->
    <script src="assets/jsdelivr/momentjs/latest/moment.min.js" crossorigin="anonymous"></script>
    <script src="assets/jsdelivr/npm/daterangepicker/daterangepicker.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/date-range-picker-demo.js"></script>
    <script src="assets/toast/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>





<!-- Asignar --> 
<script>
     $(function() {

        $.fn.select2.defaults.set("theme", "bootstrap");
        $("#bienes").select2();


        // Submit del formulario de Blog
        $("#btnCrearAsignacion").on('click',function( ){
           
 
             var nIdRegistro                = 0;
             var id_lugar_origen            = $("#id_lugar_origen").find("option:selected").val().trim();
             var id_responsable_origen      = $("#id_responsable_origen").find("option:selected").val().trim();
             var id_destino                 = $("#id_destino").find("option:selected").val().trim();
             var id_responsable_destino     = $("#id_responsable_destino").find("option:selected").val().trim();
             var motivo                     = $("input[type='radio'][name='customRadio']:checked").val();
             var otro                       = $("#otro").val();
             var aryDetalle                 = fncGetDataForTable("#tblBienes");

              if (id_lugar_origen  == '0') {
                 toastr.error('Error. Seleccione un lugar de origen. Porfavor verifique');
                 return;
             }  else if (id_responsable_origen  == '0') {
                 toastr.error('Error. Seleccione un responsable de origen. Porfavor verifique');
                 return;
             }  else if (id_destino  == '0') {
                 toastr.error('Error. Seleccione un destino . Porfavor verifique');
                 return;
             }   else if (id_responsable_destino== '0') {
                 toastr.error('Error. Seleccion un responsable de destino. Porfavor verifique');
                 return;
             }   else if (motivo  == '' || typeof motivo == "undefined") {
                 toastr.error('Error. Seleccione un motivo. Porfavor verifique');
                 return;
             }  else if (aryDetalle.length == 0) {
                 toastr.error('Error. Debe de ingresar un bien como minimo . Porfavor verifique');
                 return;
             } 


            var jsnData = {
                nIdRegistro             : nIdRegistro,
                id_lugar_origen         : id_lugar_origen,
                id_responsable_origen   : id_responsable_origen,
                id_destino              : id_destino,
                id_responsable_destino  : id_responsable_destino,
                motivo                  : motivo,
                otro                    : otro,
                aryDetalle              : aryDetalle,
                devuelto                : 0,
                estado                  : 1

            };


            fncGrabarAsig(jsnData, function(aryData){
                 if(aryData.success){
                     fncCleanAll();
                     
                     $("#formCEB").modal("hide");
                     
                     toastr.success(aryData.success);

                    if(confirm("¿Desea Imprimir o buscar una guia generada?")){
                        fncCleanAll();
                        window.open("asignacion-pdf.php?id="+aryData.nIdAsigNew, '_blank');
                        fncDrawBienes("#bienes",0);
                    } else {
                        location.replace("bd-asignaciones.php");
                    }

                 } else {
                     toastr.error(aryData.error);
                 }
            });

        });


        // $("#otro").on("focus keyup blur",function(){
        //     $("input[type='radio'][name='customRadio']:checked").val([]).trigger("change");
        // });

        // $('input[type=radio][name=customRadio]').change(function() {
        //     $("#otro").val(""); 
        // });

        $("#id_lugar_origen").on("change",function(){
            if($(this).val() == 0) {
                $("#id_responsable_origen").html(`<option value="0">SELECCIONAR</option>`);
                return; 
            }
            var jsnData = {
                idlugarorigen : $(this).val()
            };
            fncDrawRO(jsnData,"#id_responsable_origen");
        });

        $("#id_destino").on("change",function(){
            if($(this).val() == 0) {
                $("#id_responsable_destino").html(`<option value="0">SELECCIONAR</option>`);
                return; 
            }
            var jsnData = {
                id_destino : $(this).val()
            };
            fncDrawRD(jsnData,"#id_responsable_destino");
        });
    
    });

    // Funciones de la tabla o layout Principal 

   

    // Funciones Auxiliares
    function fncCleanAll(){
         $("#id_lugar_origen,#id_destino,#id_responsable_origen,#id_responsable_destino").val(0);
         $("input[type='radio'][name='customRadio']:checked").val([]).trigger("change");
         $("#otro").val(""); 
         $("#tblBienes").find("tbody").html("");
    }


    function fncDrawRO(jsnData, sHtmlTag, nid = null) {

        getResponsableByLO(jsnData, function(aryData) {

            let sOptions = ``;

            if (aryData.success) {

                sOptions += `<option value="0">SELECCIONAR</option>`;

                aryData.aryData.forEach(aryElement => {
                    sOptions += `<option value="${aryElement.id}">${aryElement.nombre}</option>`;
                });

             
                $(sHtmlTag).html(sOptions);

                if (nid != null) {
                    $(sHtmlTag).val(nid);
                }

                
                
            }

        });

    }

    function fncDrawRD(jsnData, sHtmlTag, nid = null) {

        getResponsableByDestino(jsnData, function(aryData) {

            let sOptions = ``;

            if (aryData.success) {

                sOptions += `<option value="0">SELECCIONAR</option>`;

                aryData.aryData.forEach(aryElement => {
                    sOptions += `<option value="${aryElement.id}">${aryElement.nombre}</option>`;
                });

            
                $(sHtmlTag).html(sOptions);

                if (nid != null) {
                    $(sHtmlTag).val(nid);
                }

               
                
            }

        });

    }
    
     
     // Llamadas al servidor

    function fncGrabarAsig(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "server/ajax.php?controller=asignaciones&action=crear",
            data: jsnData,
           
            beforeSend: function() {
                fncMostrarLoader();
            },
            success: function(data) {
                fncCallback(data);
            },
            complete: function() {
                fncOcultarLoader();
            }
        });
    }

    
    function fncGetDataForTable(sTable) {
        
        var aryData = [];

        $(sTable).find("tbody").find("tr").each(function() {

            var idbien          = $(this).find("td").eq(0).data("id");
            var nombrebien       = $(this).find("td").eq(1).text();
 
            aryData.push({
                idbien      : idbien,
                nombrebien  : nombrebien,
             });

        });

        return aryData;
    }


  
    function getResponsableByLO(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "server/ajax.php?controller=responsablesOrigen&action=getResponsableByLO",
            data: jsnData,
           
            beforeSend: function() {
                fncMostrarLoader();
            },
            success: function(data) {
                fncCallback(data);
            },
            complete: function() {
                fncOcultarLoader();
            }
        });
    }
  
    function getResponsableByDestino(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "server/ajax.php?controller=responsables&action=getResponsableByDestino",
            data: jsnData,
           
            beforeSend: function() {
                fncMostrarLoader();
            },
            success: function(data) {
                fncCallback(data);
            },
            complete: function() {
                fncOcultarLoader();
            }
        });
    }
 

</script>
<!-- Asignar -->

<!-- Logica Buscador Bienes -->
<script>
    $(function() {

       

         $("#btnAgregarBien").on('click',function(event){
            
            event.preventDefault();

            var idbien              = $("#bienes").val();
            var cod_patrimonio      = $("#bienes").find("option:selected").data("cod_patrimonio");
            var descripcion         = $("#bienes").find("option:selected").data("descripcion");
            var nombre_estado_bien  = $("#bienes").find("option:selected").data("nombre_estado_bien");

            var bExisteRepetido = false;

            if(idbien == 0){
                toastr.error("Error.Debe de seleccionar un bien .Porfavor verifique");
                return;
            }

            
            $("#tblBienes").find("tbody").find("tr").each(function() {

                var idbienItem = $(this).find("td").eq(0).data("id");
                
                if(idbienItem == idbien){
                    bExisteRepetido = true;
                }

            });


            if(bExisteRepetido){
                toastr.error("Error.Ya agregaste este bien.Porfavor verifique");
                return;
            }

            var fila = `
                <tr>
                    <td data-id="${idbien}" >${cod_patrimonio}</td>
                    <td>${descripcion}</td>
                    <td>${nombre_estado_bien}</td>
                    <td><a class="text-danger" onclick="eliminarFila($(this));" >Eliminar</a></td>
                </tr>
            `;

            $("#tblBienes").find("tbody").append(fila);
            $("#bienes").val("0").trigger("change");
    
        });

    
    });

    function eliminarFila(element){
        element.parent().parent().remove();
    }

    function fncDrawBienes(sHtmlTag, nid = null) {

        obtenerBienesDisponibles(null, function(aryData) {

            let sOptions = ``;

            if (aryData.success) {

                sOptions += `<option value="0">SELECCIONAR</option>`;

                aryData.aryData.forEach(aryElement => {
                    sOptions += `<option data-nombre_estado_bien="${aryElement.nombre_estado_bien}"  data-estado="${aryElement.estado}" data-descripcion="${aryElement.descripcion}" data-cod_patrimonio="${aryElement.cod_patrimonio}" value="${aryElement.id}"> 
                       Desc : ${aryElement.descripcion}  | Cod.Patri : ${aryElement.cod_patrimonio} |  Cod.Inve : ${aryElement.cod_inventario} | Marca :  ${aryElement.marca} |  Modelo :  ${aryElement.modelo} | Serie : ${aryElement.serie}   
                    </option>`;
                });

                console.log(  $(sHtmlTag), sOptions);
               
                $(sHtmlTag).html(sOptions);

                if (nid != null) {
                    $(sHtmlTag).val(nid);
                }

                setTimeout(() => {
                    $(sHtmlTag).select2();
                }, 200);
                
            }

        });

    }

    // Llamadas al servidor

    function obtenerBienesDisponibles(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "server/ajax.php?controller=bienes&action=obtenerBienesDisponibles",
            data: jsnData,
           
            beforeSend: function() {
                fncMostrarLoader();
            },
            success: function(data) {
                fncCallback(data);
            },
            complete: function() {
                fncOcultarLoader();
            }
        });
    }


     
 
 

</script>
<!-- Logica Buscador Bienes -->



</html>