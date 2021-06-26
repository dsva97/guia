<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle"><i data-feather="menu"></i></button>
        <form class="form-inline mr-auto d-none d-md-block mr-3">
            <div class="input-group input-group-joined input-group-solid">
                <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search" />
                <div class="input-group-append">
                    <div class="input-group-text"><i data-feather="search"></i></div>
                </div>
            </div>
        </form>
        <ul class="navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown no-caret mr-3 d-md-none">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="searchDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="search"></i></a>
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--fade-in-up" aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100">
                            <div class="input-group input-group-joined input-group-solid">
                                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                                <div class="input-group-append">
                                    <div class="input-group-text"><i data-feather="search"></i></div>
                                </div>
                            </div>
                        </form>
                    </div>
            </li>
            <li class="nav-item dropdown no-caret mr-3 mr-lg-0 dropdown-user">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="img/iconos/icon-user.png" /></a>
                <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="img/iconos/icon-user.png"/>
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name"><?php echo $_SESSION["s_usuario"];?></div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../bd/logout.php">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>Cerrar sesión
                    </a>
                </div>
            </li>
        </ul>
    </nav>