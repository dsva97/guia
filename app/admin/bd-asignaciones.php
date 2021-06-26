<?php
session_start();

if ($_SESSION["s_usuario"] === null) {
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
                        <div class="card-header">Asignaciones
                            <!-- <button class="btn btn-primary btnCrearBien">Nuevo</button> -->
                        </div>
                        <div class="card-body">
                            <div class="datatable">
                                <table id="tblAsig" class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Indice</th>
                                            <th>ID Asignacion</th>
                                            <th>Origen</th>
                                            <th>Ori.Responsable</th>
                                            <th>Destino</th>
                                            <th>D.Responsable</th>
                                            <th>Motivo</th>
                                            <!--  <th>F.Registro</th>
                                            <th>F.Ultima Modi</th> -->
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Indice</th>
                                            <th>ID Asignacion</th>
                                            <th>Origen</th>
                                            <th>Ori.Responsable</th>
                                            <th>Destino</th>
                                            <th>D.Responsable</th>
                                            <th>Motivo</th>
                                            <!--  <th>F.Registro</th>
                                            <th>F.Ultima Modi</th> -->
                                            <th>Estado</th>
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

<div class="modal fade" id="formCEA" tabindex="-1" role="dialog" aria-labelledby="formCEA" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="formCEA">Ver Asignacion</h5>
                    <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                        &#10006;
                    </button>
                </div>
                <div class="modal-body">


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
                                                        <select id="lugar_origen" name="lugar_origen" class="form-control">
                                                            <option>Oficina de Tecnologías de la Información</option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <h6 class="small text-muted font-weight-500">Destino</h6>
                                                        <select id="destino" name="destino" class="form-control">
                                                            <option value="0">Seleccionar</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col">
                                                        <select id="resposable_origen" name="resposable_origen" class="form-control">
                                                            <option>Alfonso Escriba Gamboa</option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <select id="responsable_destino" name="responsable_destino" class="form-control">
                                                            <option value="0">Responsable</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="sbp-preview-content">
                                        <h6 class="small text-muted font-weight-500">Motivo: </h6> <span id="smotivo"></span>
                                        
                                    </div>

                                    <div class="sbp-preview-content">
                                        <h6 class="small text-muted font-weight-500">Otro: </h6> <span id="sotro"></span>
                                    </div>

                                    <div class="sbp-preview-content">
                                        <h6 class="small text-muted font-weight-500">Bienes:  </h6>
                                        <div class="datatable">
                                            <table class="table table-bordered table-hover" id="tblBienes" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Código Patrimonial</th>
                                                        <th>Descripción</th>
                                                        <th>Estado</th>
                                                     </tr>
                                                </thead>

                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                  
                                    <div class="sbp-preview-content">



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>

            </form>
        </div>
    </div>
</div>

<!-- Fin de modales -->


<!-- ASIg -->
<script>
    window.tblAsig;
    $(function() {

        tblAsig = $('#tblAsig').DataTable({
            ajax: "server/ajax.php?controller=asignaciones&action=populate"
        });


    });

    // // Funciones de la tabla o layout Principal 

    function fncVerificarEliminarA(nIdRegistro) {
        if (confirm('Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?')) {

            var jsnData = {
                nIdRegistro: nIdRegistro
            };

            fncEliminarA(jsnData, function(aryData) {

                if (aryData.success) {
                    tblAsig.ajax.reload();
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }

            });
        }
    }

    function fncMostrarA(nIdRegistro, sOpcion) {

        $("#formCEA").data("nIdRegistro", nIdRegistro);

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroA(jsnData, function(aryResponse) {

            if (aryResponse.success) {

                var aryData = aryResponse.aryData;
                var aryDetalle = aryResponse.aryDetalle;

                $("#lugar_origen").html(`<option>${aryData.lugar_origen}</option>`);
                $("#resposable_origen").html(`<option>${aryData.resposable_origen}</option>`);
                $("#destino").html(`<option>${aryData.destino}</option>`);
                $("#responsable_destino").html(`<option>${aryData.responsable_destino}</option>`);
                $("#smotivo").html(`${aryData.motivo}`);
                $("#sotro").html(`${aryData.otro}`);

                console.log(aryDetalle,aryDetalle.length);

                if(aryDetalle.length > 0){
                    
                    var filas = ``;

                    aryDetalle.forEach(element => {
                          filas += `
                            <tr>
                                <td>${element.cod_patrimonio}</td>
                                <td>${element.nombrebien}</td>
                                <td>${element.nombre_estado_bien}</td>
                            </tr>
                        `;

                    });
                    console.log(filas);
                    $("#tblBienes").find("tbody").html(filas);
                }


                if(sOpcion == 'editar'){
                    fncEditForm("#formCEA" , "Editar Asignacion");
                } else {
                    fncViewForm("#formCEA" , "Ver Asignacion");
                }

                $("#formCEA").modal("show");

            } else {
                toastr.error(aryData.error);
            }
        });

    }

    // Funciones Auxiliares
    function fncCleanAll() {
        fncRemoveDisabled($("#formCEA").find("form"));
        fncClearInputs($("#formCEA").find("form"));
    }


    // Llamadas al servidor


    function fncBuscarRegistroA(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "server/ajax.php?controller=asignaciones&action=mostrar",
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

    function fncEliminarA(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            url: "server/ajax.php?controller=asignaciones&action=eliminar",
            data: jsnData,
            dataType: 'json',
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
<!-- ASIg -->


</html>