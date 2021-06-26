<?php
session_start();
require_once '../bd/conexion.php';
require_once 'server/functions.php';

require_once 'server/models/Destinos.php';
 

$database = new Database();

 
$mdlDestinos       = new Destinos($database);
 

if ($_SESSION["s_usuario"] === null) {
    header("Location: ../index.php");
}


$aryD = $mdlDestinos->fncGetDestinos(["estado" => 1]);
  

?>

<!DOCTYPE html>
<html lang="en">
<?php include('metas.php') ?>
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
                        <div class="card mb-4">
                            <div class="card-header">Responsables Destino <button class="btn btn-primary btnCrearResp">Crear</button></div>
                            <div class="card-body">
                                <div class="datatable">
                                    <table id="tblResponsable" class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Indice</th>
                                                <th>Nombre</th>
                                                <th>Ofc.Destino</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Indice</th>
                                                <th>Nombre</th>
                                                <th>Ofc.Destino</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="card card-icon mb-4">
                            <div class="row no-gutters">
                                <div class="col-auto card-icon-aside bg-primary"><i class="mr-1 text-white-50" data-feather="alert-triangle"></i></div>
                                <div class="col">
                                    <div class="card-body py-5">
                                        <h5 class="card-title">Third-Party Documentation Available</h5>
                                        <p class="card-text">DataTables is a third party plugin that is used to generate the demo table above. For more information about how to use DataTables with your project, please visit the official DataTables documentation.</p>
                                        <a class="btn btn-primary btn-sm" href="https://datatables.net/" target="_blank">
                                            <i class="mr-1" data-feather="external-link"></i>
                                            Visit DataTables Docs
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div> -->
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
        <script src="assets/jquery/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="assets/jsdelivr/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="assets/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="assets/datatables/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="assets/datatables/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
        <script src="assets/jsdelivr/momentjs/latest/moment.min.js" crossorigin="anonymous"></script>
        <script src="assets/jsdelivr/npm/daterangepicker/daterangepicker.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/date-range-picker-demo.js"></script>
        
        <script src="js/functions.js"></script>
        <script src="assets/demo/date-range-picker-demo.js"></script>
        <script src="assets/toast/toastr.min.js"></script>

    </body>


     <!-- Modales -->

    <div class="modal fade" id="formCER" tabindex="-1" role="dialog" aria-labelledby="formCERLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCERLabel">Nuevo Responsable</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            &#10006;
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="col-form-label">Nombre<span class="text-danger">*</span> </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="nombre" id="nombre">
                                </div>
                            </div>

                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="id_destino" class="col-form-label">Ofc.Destino <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="id_destino" id="id_destino">
                                            <option value="0">SELECCIONAR</option>
                                            <?php if (fncValidateArray($aryD)) : ?>
                                                <?php foreach ($aryD as $aryLoop) : ?>
                                                    <option value="<?= $aryLoop["id"] ?>"><?= strup($aryLoop["dependencia"]) ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                    </select>
                                </div>
                            </div>
                    
                            <div class="col-12 col-md-6 d-none"> 
                                <div class="form-group"> 
                                    <label for="estado" class="col-form-label">Estado <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="estado" id="estado">
                                         <option value="1">ACTIVO</option>
                                         <option value="0">DESACTIVO</option>
                                    </select>
                                </div>
                            </div>


                        </div>  
                    </div>                       
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-fw btn-submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Fin de modales -->


<!-- Responsable --> 
<script>
    window.tblResponsable ;
    $(function() {

        tblResponsable = $('#tblResponsable').DataTable({
            ajax: "server/ajax.php?controller=responsables&action=populate"
        });

        // Formulario Blog
        $(".btnCrearResp").on('click', function() {
            fncCleanAll();
            $("#formCER").find(".modal-title").html('Nuevo Responsable');
            $("#formCER").data("nIdRegistro",0);
            $("#formCER").modal("show");
        });

        // Submit del formulario de Blog
        $("#formCER").find("form").on('submit',function(event){
           
             event.preventDefault();

             var nIdRegistro   = $("#formCER").data("nIdRegistro");
             var nombre        = $("#nombre").val();
             var id_destino    = $("#id_destino").val();
             var estado        = $("#estado").val();
             
              if (nombre  == '') {
                 toastr.error('Error. Ingrese una nombre. Porfavor verifique');
                 return;
             }   

            var jsnData = {
                nIdRegistro     : nIdRegistro,
                nombre          : nombre,
                id_destino      : id_destino,
                estado          : 1
            };

            fncGrabarResponsable(jsnData, function(aryData){
                 if(aryData.success){
                     fncCleanAll();
                     $("#formCER").modal("hide");
                     tblResponsable.ajax.reload();
                     toastr.success(aryData.success);
                 } else {
                     toastr.error(aryData.error);
                 }
            });

        });
    });

    // Funciones de la tabla o layout Principal 

    function fncVerificarEliminarR(nIdRegistro) {
        if(confirm('Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?')){
            
            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEliminarR( jsnData , function(aryData){

                if(aryData.success){
                    tblResponsable.ajax.reload();
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 
        }
    }

    function fncMostrarR(nIdRegistro , sOpcion ) {

        $( "#formCER" ).data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroR(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryData = aryResponse.aryData;

                    $("#nombre").val(aryData.nombre);
                    $("#estado").val(aryData.estado);

                    if(sOpcion == 'editar'){
                        fncEditForm("#formCER" , "Editar Responsable");
                    } else {
                        fncViewForm("#formCER" , "Ver Responsable");
                    }

                    $("#formCER").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    // Funciones Auxiliares
    function fncCleanAll(){
        fncRemoveDisabled( $("#formCER").find("form") );
        fncClearInputs( $("#formCER").find("form") );
    }
    
     
     // Llamadas al servidor

    function fncGrabarResponsable(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "server/ajax.php?controller=responsables&action=crear",
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

    function fncBuscarRegistroR(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "server/ajax.php?controller=responsables&action=mostrar",
            data: jsnData ,
            beforeSend: function () {
                fncMostrarLoader();
            },
            success: function (data) {
                fncCallback(data);
            },
            complete: function () {
                fncOcultarLoader();
            }
        });
    }

    function fncEliminarR( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: "server/ajax.php?controller=responsables&action=eliminar",
            data: jsnData,
            dataType: 'json',
            beforeSend: function () {
                fncMostrarLoader();
            },
            success: function( data ) {
                fncCallback(data);
            },
            complete: function () {
                fncOcultarLoader();
            }

        });
    }
 

</script>
<!-- Responsable -->


</html>
