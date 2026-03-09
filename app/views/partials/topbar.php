
<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="<?= BASE_URL ?>">
                        <img src="<?= BASE_URL ?>static/assets/img/logo/EEM-logo-color.svg" class="navbar-logo"
                            alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="<?= BASE_URL ?>" class="nav-link">
                        Elorrieta Erreka Mari
                    </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <i class="bi bi-chevron-double-left fs-3"></i>
                </div>
            </div>
        </div>

        <ul class="list-unstyled menu-categories ps" id="accordionExample">

            <li class="menu <?= $tab == 1 ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>Pedidos" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="bi bi-box-seam fs-5"></i>
                        <span>Pedidos</span>
                    </div>
                </a>
            </li>
            <li class="menu <?= $tab == 11 ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>Inventario" data-bs-toggle="dropdown" aria-expanded="false"
                    class="dropdown-toggle">
                    <div class="">
                        <i class="bi bi-grid fs-5"></i>
                        <span>Inventario</span>
                    </div>
                </a>
                <ul class="dropdown-menu submenu list-unstyled" id="dashboard" data-bs-parent="#accordionExample">
                    <li>
                        <a href="<?= BASE_URL ?>Inventario"> Listado </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>Inventario/vereditar?id=0"> Nuevo </a>
                    </li>
                </ul>
            </li>
            <?php if ($usuario->tipo == JEFE_DEP): ?>
                <li class="menu <?= $tab == 4 ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>Proveedores" data-bs-toggle="dropdown" aria-expanded="false"
                        class="dropdown-toggle">
                        <div class="">
                            <i class="bi bi-truck fs-5"></i>
                            <span>Proveedores</span>
                        </div>
                    </a>
                    <ul class="dropdown-menu submenu list-unstyled" id="dashboard" data-bs-parent="#accordionExample">
                        <li>
                            <a href="<?= BASE_URL ?>Proveedores"> Listado </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>Proveedores/vereditar?id=0"> Alta </a>
                        </li>
                    </ul>
                </li>


                <li class="menu <?= $tab == 8 ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>AreasGastos" data-bs-toggle="dropdown" aria-expanded="false"
                        class="dropdown-toggle">
                        <div class="">
                            <i class="bi bi-stack fs-5"></i>
                            <span>Areas de Gastos</span>
                        </div>

                    </a>
                    <ul class="dropdown-menu submenu list-unstyled" id="dashboard" data-bs-parent="#accordionExample">
                        <li>
                            <a href="<?= BASE_URL ?>AreasGastos">Listado</a>
                        </li>                       
                    </ul>
                </li>

            <?php endif; ?>


            <?php if ($usuario->tipo == ADMIN): ?>
                <li class="menu <?= $tab == 4 ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>Proveedores" data-bs-toggle="dropdown" data-bs-toggle="dropdown"
                        aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <i class="bi bi-truck fs-5"></i>
                            <span>Proveedores</span>
                        </div>
                    </a>
                    <ul class="dropdown-menu submenu list-unstyled" id="dashboard" data-bs-parent="#accordionExample">
                        <li>
                            <a href="<?= BASE_URL ?>PedidosPendientes">Pendidos Pendientes</a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>Proveedores">Listado</a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>Proveedores/vereditar?id=0"> Alta </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>TiposServicio"> Tipos de servicio </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>TiposServicio/vereditar?id=0"> Nuevo tipo de servicio </a>
                        </li>
                    </ul>
                </li>
                <li class="menu <?= $tab == 12 ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>Estados" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <i class="bi bi-layers fs-5"></i>
                            <span>Estados</span>
                        </div>
                    </a>
                </li>
                <li class="menu <?= $tab == 8 ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>AreasGastos" data-bs-toggle="dropdown" aria-expanded="false"
                        class="dropdown-toggle">
                        <div class="">
                            <i class="bi bi-stack fs-5"></i>
                            <span>Areas de Gastos</span>
                        </div>

                    </a>
                    <ul class="dropdown-menu submenu list-unstyled" id="dashboard" data-bs-parent="#accordionExample">
                        <li>
                            <a href="<?= BASE_URL ?>AreasGastos">Listado</a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>AreasGastos/vereditar?id=-1"> Alta </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>Ingresos"> Ingreso / Gasto </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>Ingresos/vereditar?id=0"> Nuevo Ingreso / Gasto</a>
                        </li>
                    </ul>
                </li>
                <li class="menu <?= $tab == 7 ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>Subconceptos" data-bs-toggle="dropdown" aria-expanded="false"
                        class="dropdown-toggle">
                        <div class="">
                            <i class="bi bi-vector-pen fs-5"></i>
                            <span>Subconceptos</span>
                        </div>
                    </a>
                    <ul class="dropdown-menu submenu list-unstyled" id="dashboard" data-bs-parent="#accordionExample">
                        <li>
                            <a href="<?= BASE_URL ?>Subconceptos">Listado</a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>Subconceptos/vereditar?id=0"> Alta </a>
                        </li>
                    </ul>
                </li>
                <li class="menu <?= $tab == 2 ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>Usuarios" data-bs-toggle="dropdown" aria-expanded="false"
                        class="dropdown-toggle">
                        <div class="">
                            <i class="bi bi-people fs-5"></i>
                            <span>Usuarios</span>
                        </div>
                    </a>
                    <ul class="dropdown-menu submenu list-unstyled" id="dashboard" data-bs-parent="#accordionExample">
                        <li>
                            <a href="<?= BASE_URL ?>Usuarios">Listado</a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>Usuarios/vereditar?id=0"> Alta </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>Departamentos"> Departamentos </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>Departamentos/vereditar?id=0"> Nuevo Departamento </a>
                        </li>
                    </ul>
                </li>

                <li class="menu <?= $tab == 6 ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>Reportes" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <i class="bi bi-bar-chart fs-5"></i>
                            <span>Reportes</span>
                        </div>
                    </a>
                </li>

            <?php endif; ?>
            <li class="menu <?= $tab == 0 ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>Menu" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="bi bi-bell fs-5"></i>
                        <span>Avisos</span>
                    </div>
                </a>
            </li>
   
        </ul>

    </nav>

</div>