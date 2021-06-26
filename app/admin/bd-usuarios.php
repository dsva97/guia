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
                            <div class="card-header">Usuarios <button class="btn btn-primary btnAdd">Nuevo</button></div>
                            <div class="card-body">
                                <div class="datatable">
                                    <table id="tblUsuarios" class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Indice</th>
                                                <th>Usuario</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Indice</th>
                                                <th>Usuario</th>
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
                        <h5 class="modal-title" id="formCEBLabel">Nuevo Usuario</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            &#10006;
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="usuario" class="col-form-label">Usuario<span class="text-danger">*</span> </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="usuario" id="usuario">
                                </div>
                            </div>

                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="password" class="col-form-label">Clave<span class="text-danger">*</span> </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="password" id="password">
                                </div>
                            </div>

                          
                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="r_password" class="col-form-label">Repetir Clave<span class="text-danger">*</span> </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="r_password" id="r_password">
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


<!-- Usuarios --> 
<script>
    window.tblUsuarios ;
    $(function() {

        tblUsuarios = $('#tblUsuarios').DataTable({
            ajax: "server/ajax.php?controller=usuarios&action=populate"
        });
 

        // Formulario Blog
        $(".btnAdd").on('click', function() {
            fncCleanAll();
            $("#formCEB").find(".modal-title").html('Nuevo Usuario');
            $("#formCEB").data("nIdRegistro",0);
            $("#formCEB").modal("show");
        });

        // Submit del formulario de Blog
        $("#formCEB").find("form").on('submit',function(event){
           
             event.preventDefault();

             var nIdRegistro            = $("#formCEB").data("nIdRegistro");
             var usuario                = $("#usuario").val();
             var password               = $("#password").val();
             var r_password             = $("#r_password").val();
 

              if (usuario  == '') {
                 toastr.error('Error. Ingrese un usuario. Porfavor verifique');
                 return;
             }  else if (password  == '') {
                 toastr.error('Error. Ingrese una password . Porfavor verifique');
                 return;
             }  else if (password  != r_password ) {
                 toastr.error('Error. Las clave son distintas. Porfavor verifique');
                 return;
             }  

            var jsnData = {
                nIdRegistro     : nIdRegistro,
                usuario         : usuario,
                password        : password,
                r_password      : r_password,
             };


            fncGrabarUsuario(jsnData, function(aryData){
                 if(aryData.success){
                     fncCleanAll();
                     $("#formCEB").modal("hide");
                     tblUsuarios.ajax.reload();
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
                $(".btnAdd").trigger("click");
            }
        }
    
    });

    // Funciones de la tabla o layout Principal 

    function fncVerificarEliminarU(nIdRegistro) {
        if(confirm('Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?')){
            
            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEliminarU( jsnData , function(aryData){

                if(aryData.success){
                    tblUsuarios.ajax.reload();
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 
        }
    }

    function fncMostrarU(nIdRegistro , sOpcion ) {

        $( "#formCEB" ).data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroU(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryData = aryResponse.aryData;

                    $("#usuario").val(aryData.usuario);
                    $("#password").val(aryData.password);
                    $("#r_password").val(aryData.password);

                    if(sOpcion == 'editar'){
                        fncEditForm("#formCEB" , "Editar Usuario");
                    } else {
                        fncViewForm("#formCEB" , "Ver Usuario");
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

    function fncGrabarUsuario(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "server/ajax.php?controller=usuarios&action=crear",
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

    function fncBuscarRegistroU(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "server/ajax.php?controller=usuarios&action=mostrar",
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

    function fncEliminarU( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: "server/ajax.php?controller=usuarios&action=eliminar",
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
<!-- Usuarios -->


</html>
