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
                                                                    <select class="form-control">
                                                                    <option>Oficina de Tecnologías de la Información</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <h6 class="small text-muted font-weight-500">Destino</h6>
                                                                    <select class="form-control">
                                                                    <option>Dependencia</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col">
                                                                <select class="form-control">
                                                                    <option>Alfonso Escriba Gamboa</option>
                                                                </select>
                                                                </div>
                                                                <div class="col">
                                                                <select class="form-control">
                                                                    <option>Responsable</option>
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
                                                                    <input class="custom-control-input" id="customRadio1" type="radio" name="customRadio"/>
                                                                    <label class="custom-control-label" for="customRadio1">Traslado</label>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" id="customRadio1" type="radio" name="customRadio"/>
                                                                    <label class="custom-control-label" for="customRadio1">Reparación</label>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" id="customRadio1" type="radio" name="customRadio"/>
                                                                    <label class="custom-control-label" for="customRadio1">Transferencia</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" id="customRadio1" type="radio" name="customRadio"/>
                                                                    <label class="custom-control-label" for="customRadio1">A préstamo</label>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" id="customRadio1" type="radio" name="customRadio"/>
                                                                    <label class="custom-control-label" for="customRadio1">Por baja</label>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" id="customRadio1" type="radio" name="customRadio"/>
                                                                    <label class="custom-control-label" for="customRadio1">Uso personal</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Otro</span>
                                                        </div>
                                                        <textarea class="form-control" aria-label="With textarea"></textarea>
                                                    </div>
                                                </div>
                                                <div class="sbp-preview-content">
                                                    <h6 class="small text-muted font-weight-500">Bienes:</h6>
                                                    <div class="datatable">
                                                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Código Patrimonial</th>
                                                                    <th>Descripción</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>Código Patrimonial</th>
                                                                    <th>Descripción</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </tfoot>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Airi Satou</td>
                                                                    <td>Accountant</td>
                                                                    <td><div class="badge badge-primary badge-pill">Full-time</div></td>
                                                                </tr>
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
        <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/jquery/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
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
</html>
