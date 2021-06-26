<div id="layoutSidenav_nav">
            <nav class="sidenav shadow-right sidenav-light">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">
                        <a class="nav-link" href="admin.php">
                            <div class="nav-link-icon"><i data-feather="home"></i></div>
                            Inicio
                        </a>
                        <div class="sidenav-menu-heading"> Datos</div>
                        <a class="nav-link" href="bd-bienes.php?action=crear">
                            <div class="nav-link-icon"><i data-feather="folder-plus"></i></div>
                            Agregar Bienes
                        </a>
                        <a class="nav-link" href="bd-bienes.php">
                            <div class="nav-link-icon"><i data-feather="folder"></i></div>
                            Bienes
                        </a>
                        <a class="nav-link" href="bd-asignaciones.php">
                            <div class="nav-link-icon"><i data-feather="folder"></i></div>
                            Asignaciones
                        </a>
                        <a class="nav-link" href="bd-devoluciones.php">
                            <div class="nav-link-icon"><i data-feather="folder"></i></div>
                            Devoluciones
                        </a>

                        <a class="nav-link" href="bd-lugar-origen.php">
                            <div class="nav-link-icon"><i data-feather="folder"></i></div>
                            Lugar de origen
                        </a>

                        <a class="nav-link" href="bd-destinos.php">
                            <div class="nav-link-icon"><i data-feather="folder"></i></div>
                            Destinos
                        </a>

                        <a class="nav-link" href="bd-responsables-origen.php">
                            <div class="nav-link-icon"><i data-feather="folder"></i></div>
                            Responsables Origen
                        </a>

                        <a class="nav-link" href="bd-responsables.php">
                            <div class="nav-link-icon"><i data-feather="folder"></i></div>
                            Responsables Destino
                        </a>
                        <div class="sidenav-menu-heading">SEGURIDAD - USUARIOS</div>
                        <a class="nav-link" href="bd-usuarios.php?action=crear">
                            <div class="nav-link-icon"><i data-feather="user-plus"></i></div>
                            Agregar usuarios
                        </a>
                        <a class="nav-link" href="bd-usuarios.php">
                            <div class="nav-link-icon"><i data-feather="users"></i></div>
                            Usuarios Activos
                        </a>
                        <div class="sidenav-menu-heading">OPERACIONES</div>
                        <a class="nav-link" href="configuracion.php">
                            <div class="nav-link-icon"><i data-feather="settings"></i></div>
                            Configuración
                        </a>
                        <a class="nav-link" href="asignar.php">
                            <div class="nav-link-icon"><i data-feather="file-plus"></i></div>
                            Asignar
                        </a>
                        <a class="nav-link" href="devolver.php">
                            <div class="nav-link-icon"><i data-feather="file-minus"></i></div>
                            Devolver
                        </a>
                        <div class="sidenav-menu-heading">REPORTES</div>
                        <a class="nav-link" href="informes.php">
                            <div class="nav-link-icon"><i data-feather="printer"></i></div>
                            Informes
                        </a>
                        <a class="nav-link" href="estadisticas.php">
                            <div class="nav-link-icon"><i data-feather="pie-chart"></i></div>
                            Estadísticas
                        </a>
                    </div>
                </div>
                <div class="sidenav-footer">
                    <div class="sidenav-footer-content">
                        <div class="sidenav-footer-subtitle">Iniciaste con:</div>
                        <div class="sidenav-footer-title"><?php echo $_SESSION["s_usuario"];?></div>
                    </div>
                </div>
            </nav>
        </div>