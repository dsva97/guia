<?php
session_start();

if($_SESSION["s_usuario"] === null){
    header("Location: ../index.php");
}
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
                            <div class="card-header">Bienes <button class="btn btn-primary btnCrearBien">Nuevo</button></div>
                            <div class="card-body">
                                <div class="datatable">
                                    <table id="tblBienes" class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Indice</th>
                                                <th>Cod.Patrimonio</th>
                                                <th>Descripcion</th>
                                                <th>Cod Inventario</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                  <!-- <th>F.Registro</th>
                                                <th>F.Ultima Modi</th> -->
                                                <th>Estado Bien</th>
                                                <th>Estado Registro</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Indice</th>
                                                <th>Cod.Patrimonio</th>
                                                <th>Descripcion</th>
                                                <th>Cod Inventario</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <!-- <th>F.Registro</th>
                                                <th>F.Ultima Modi</th> -->
                                                <th>Estado Bien</th>
                                                <th>Estado Registro</th>
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

    <div class="modal fade" id="formCEB" tabindex="-1" role="dialog" aria-labelledby="formCEBLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCEBLabel">Nuevo Bien</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            &#10006;
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="cod_patrimonio" class="col-form-label">Cod Patrimonio<span class="text-danger">*</span> </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="cod_patrimonio" id="cod_patrimonio">
                                </div>
                            </div>

                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="descripcion" class="col-form-label">Descripcion<span class="text-danger">*</span> </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="descripcion" id="descripcion">
                                </div>
                            </div>

                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="cod_inventario" class="col-form-label">Cod Inventario <span class="text-danger">*</span> </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="cod_inventario" id="cod_inventario">
                                </div>
                            </div>
 
                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="marca" class="col-form-label">Marca <span class="text-danger">*</span> </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="marca" id="marca">
                                </div>
                            </div>

                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="modelo" class="col-form-label">Modelo <span class="text-danger">*</span> </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="modelo" id="modelo">
                                </div>
                            </div>
 
                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="serie" class="col-form-label">Serie <span class="text-danger">*</span> </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="serie" id="serie">
                                </div>
                            </div>
 
                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="estado_bien" class="col-form-label">Estado Bien <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="estado_bien" id="estado_bien">
                                         <option value="0">NINGUNO</option>
                                         <option value="1">NUEVO</option>
                                         <option value="2">BUENO </option>
                                         <option value="3">REGULAR </option>
                                         <option value="4">MALO</option>
                                    </select>
                                </div>
                            </div>
                    
                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="estado" class="col-form-label">Estado Registro <span class="text-danger">*</span> </label>
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


<!-- Bienes --> 
<script>
    window.tblBienes ;
    $(function() {

        tblBienes = $('#tblBienes').DataTable({
            ajax: "server/ajax.php?controller=bienes&action=populate"
        });
 


        // Formulario Blog
        $(".btnCrearBien").on('click', function() {
            fncCleanAll();
            $("#formCEB").find(".modal-title").html('Nuevo Bien');
            $("#formCEB").data("nIdRegistro",0);
            $("#formCEB").modal("show");
        });

        // Submit del formulario de Blog
        $("#formCEB").find("form").on('submit',function(event){
           
             event.preventDefault();

             var nIdRegistro                = $("#formCEB").data("nIdRegistro");
             var cod_patrimonio             = $("#cod_patrimonio").val();
             var descripcion                = $("#descripcion").val();
             var cod_inventario             = $("#cod_inventario").val();
             var marca                      = $("#marca").val();
             var modelo                     = $("#modelo").val();
             var serie                      = $("#serie").val();  
             var estado_bien                = $("#estado_bien").val();
             var estado                     = $("#estado").val();

              if (cod_patrimonio  == '') {
                 toastr.error('Error. Ingrese un codigo de pratimonio. Porfavor verifique');
                 return;
             }  else if (descripcion  == '') {
                 toastr.error('Error. Ingrese un descripcion . Porfavor verifique');
                 return;
             }  else if (cod_inventario  == '') {
                 toastr.error('Error. Ingrese un codigo de inventario. Porfavor verifique');
                 return;
             }  else if (marca  == '') {
                 toastr.error('Error. Ingrese una marca. Porfavor verifique');
                 return;
             }  else if (modelo  == '') {
                 toastr.error('Error. Ingrese un modelo. Porfavor verifique');
                 return;
             }  else if (serie  == '') {
                 toastr.error('Error. Ingrese una serie. Porfavor verifique');
                 return;
            }  

            var jsnData = {
                nIdRegistro     : nIdRegistro,
                cod_patrimonio  : cod_patrimonio,
                descripcion     : descripcion,
                cod_inventario  : cod_inventario,
                marca           : marca,
                modelo          : modelo,
                serie           : serie,
                estado_bien     : estado_bien,
                estado          : estado,
            };


            fncGrabarBien(jsnData, function(aryData){
                 if(aryData.success){
                     fncCleanAll();
                     $("#formCEB").modal("hide");
                     tblBienes.ajax.reload();
                     toastr.success(aryData.success);
                 } else {
                     toastr.error(aryData.error);
                 }
            });

        });

        
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var action = urlParams.get('action');

        if(action !== ""){
            if(action == "crear"){
                $(".btnCrearBien").trigger("click");
            }
        }
    
    });

    // Funciones de la tabla o layout Principal 

    function fncVerificarEliminarBien(nIdRegistro) {
        if(confirm('Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?')){
            
            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEliminarB( jsnData , function(aryData){

                if(aryData.success){
                    tblBienes.ajax.reload();
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 
        }
    }

    function fncMostrarB(nIdRegistro , sOpcion ) {

        $( "#formCEB" ).data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroB(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryData = aryResponse.aryData;

                    $("#cod_patrimonio").val(aryData.cod_patrimonio);
                    $("#descripcion").val(aryData.descripcion);
                    $("#cod_inventario").val(aryData.cod_inventario);
                    $("#marca").val(aryData.marca);
                    $("#modelo").val(aryData.modelo);
                    $("#serie").val(aryData.serie);
                    $("#estado_bien").val(aryData.estado_bien);
                    $("#estado").val(aryData.estado);

                 
                    if(sOpcion == 'editar'){
                        fncEditForm("#formCEB" , "Editar Bien");
                    } else {
                        fncViewForm("#formCEB" , "Ver Bien");
                    }

                    $("#formCEB").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    // Funciones Auxiliares
    function fncCleanAll(){
        fncRemoveDisabled( $("#formCEB").find("form") );
        fncClearInputs( $("#formCEB").find("form") );
    }
    
     
     // Llamadas al servidor

    function fncGrabarBien(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "server/ajax.php?controller=bienes&action=crear",
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

    function fncBuscarRegistroB(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "server/ajax.php?controller=bienes&action=mostrar",
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

    function fncEliminarB( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: "server/ajax.php?controller=bienes&action=eliminar",
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
<!-- Bienes -->


</html>
