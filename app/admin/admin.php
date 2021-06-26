<?php
require_once '../bd/conexion.php';
require_once 'server/models/Asignaciones.php';
require_once 'server/models/Responsables.php';

session_start();

if ($_SESSION["s_usuario"] === null) {
    header("Location: ../index.php");
}

$database = new Database();

$mdlAsig          = new Asignaciones($database);
$mdlResponsable   = new Responsables($database); // Estos son los responsables pero para destino

$aryAsig = $mdlAsig->fncGetAsignaciones();
$aryRD = $mdlResponsable->fncGetResponsable();

?>

<!DOCTYPE html>
<html lang="en">
<?php include('metas.php') ?>

<body class="nav-fixed">
    <?php include('head.php') ?>
    <div id="layoutSidenav">
        <?php include('menu.php') ?>
        <div id="layoutSidenav_content">
            <main>
                <?php include('header.php') ?>
                <div class="container mt-n10">
                    <div class="row">
                        <div class="col-xxl-3 col-lg-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mr-3">
                                            <div class="text-white-75 small">Guías asignadas</div>
                                            <div class="text-lg font-weight-bold"><?= count($aryAsig) ?></div>
                                        </div>
                                        <i class="feather-xl text-white-50" data-feather="calendar"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="asignar.php">Asignar Bien</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mr-3">
                                            <div class="text-white-75 small">Responsable Destino</div>
                                            <div class="text-lg font-weight-bold"><?= count($aryRD) ?></div>
                                        </div>
                                        <i class="feather-xl text-white-50" data-feather="calendar"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="bd-responsables.php">Ver responsables</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mr-3">
                                            <div class="text-white-75 small">Task Completion</div>
                                            <div class="text-lg font-weight-bold">24</div>
                                        </div>
                                        <i class="feather-xl text-white-50" data-feather="check-square"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Tasks</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-lg-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mr-3">
                                            <div class="text-white-75 small">Pending Requests</div>
                                            <div class="text-lg font-weight-bold">17</div>
                                        </div>
                                        <i class="feather-xl text-white-50" data-feather="message-circle"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Requests</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">Bienes</div>
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
</body>


<!-- Bienes -->
<script>
    window.tblBienes;
    $(function() {

        tblBienes = $('#tblBienes').DataTable({
            ajax: "server/ajax.php?controller=bienes&action=populate",
            "columnDefs": [{
                    "targets": [9],
                    "visible": false,
                    "searchable": false
                }

            ]
        });


    });
</script>
<!-- Bienes -->

</html>