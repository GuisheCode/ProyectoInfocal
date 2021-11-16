<?php
setlocale(LC_ALL, 'es_ES');
date_default_timezone_set('America/La_Paz');
$hora = date('Gis');
?>
<header class="header" id="header">
    <div class="header__toggle">
        <i class='bx bx-menu' id="header-toggle"></i>
    </div>
    <nav class="navi">
        <div class="logo">ADMINISTRADOR</div>
        <div class="nav-items">
            <li><a href="../">Inicio</a></li>
        </div>
        <!-- <div class="search-icon">
            <span class="fas fa-search"></span>
        </div>
        <div class="menu-icon">
            <span class="fas fa-bars"></span>
        </div>
        <div class="cancel-icon">
            <span class="fas fa-times"></span>
        </div>
        <form action="#">
            <input type="search" class="search-data" placeholder="Search" required />
            <button type="submit" class="fas fa-search"></button>
        </form> -->
    </nav>
    <!-- <div class="header__img">
                <img src="assets/img/perfil.jpg" alt="">
            </div> -->
</header>

<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="#" class="nav__logo" style="text-decoration: none;">
                <i class='bx bx-layer nav__logo-icon'></i>
                <span class="nav__logo-name">Infocal</span>
            </a>
            <div class="nav__list"> 
                <a href="../" class="nav__link active" style="text-decoration: none;">
                    <i class='bx bx-message-square-detail nav__icon'></i>
                    <span class="nav__name">VER USUARIOS</span>
                </a>
                <a href="../crear-usuario/" class="nav__link" style="text-decoration: none;">
                    <i class='bx bx-grid-alt nav__icon'></i>
                    <span class="nav__name">NUEVO USUARIO</span>
                </a>
               
                <a href="../editar-usuario/" class="nav__link" style="text-decoration: none;">
                    <i class='bx bx-user nav__icon'></i>
                    <span class="nav__name">BORRAR/EDITAR<br>USUARIO</span>
                </a>
                <a href="../mi-perfil/" class="nav__link" style="text-decoration: none;">
                    <i class='bx bx-bar-chart-alt-2 nav__icon'></i>
                    <span class="nav__name">MI PERFIL</span>
                </a>
            </div>
        </div>
        <a href="../../../logout.php" class="nav__link" style="text-decoration: none;">
            <i class='bx bx-log-out nav__icon'></i>
            <span class="nav__name">Cerrar sesion</span>
        </a>
    </nav>
</div>