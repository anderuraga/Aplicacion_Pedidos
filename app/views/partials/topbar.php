
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-chevrons-left">
                        <polyline points="11 17 6 12 11 7"></polyline>
                        <polyline points="18 17 13 12 18 7"></polyline>
                    </svg>
                </div>
            </div>
        </div>

        <ul class="list-unstyled menu-categories ps" id="accordionExample">

            <li class="menu <?= $tab == 1 ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>Pedidos" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-package">
                            <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                            <path
                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                            </path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <span>Pedidos</span>
                    </div>
                </a>
            </li>
            <li class="menu <?= $tab == 11 ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>Inventario" data-bs-toggle="dropdown" aria-expanded="false"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-grid">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-truck">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
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
            <?php endif; ?>
            <?php if ($usuario->tipo == ADMIN): ?>
                <li class="menu <?= $tab == 4 ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>Proveedores" data-bs-toggle="dropdown" data-bs-toggle="dropdown"
                        aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-truck">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                            <span>Proveedores</span>
                        </div>
                    </a>
                    <ul class="dropdown-menu submenu list-unstyled" id="dashboard" data-bs-parent="#accordionExample">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-layers">
                                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                <polyline points="2 17 12 22 22 17"></polyline>
                                <polyline points="2 12 12 17 22 12"></polyline>
                            </svg>
                            <span>Estados</span>
                        </div>
                    </a>
                </li>
                <li class="menu <?= $tab == 8 ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>AreasGastos" data-bs-toggle="dropdown" aria-expanded="false"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-layers">
                                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                <polyline points="2 17 12 22 22 17"></polyline>
                                <polyline points="2 12 12 17 22 12"></polyline>
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-pen-tool">
                                <path d="M12 19l7-7 3 3-7 7-3-3z"></path>
                                <path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path>
                                <path d="M2 2l7.586 7.586"></path>
                                <circle cx="11" cy="11" r="2"></circle>
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-bar-chart-2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                            <span>Reportes</span>
                        </div>
                    </a>
                </li>

            <?php endif; ?>
            <li class="menu <?= $tab == 0 ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>Menu" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-bell">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span>Avisos</span>
                    </div>
                </a>
            </li>
   
        </ul>

    </nav>

</div>