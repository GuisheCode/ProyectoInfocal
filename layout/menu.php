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
        <div class="logo">Administración de llaves de aulas y herramientas multimedia</div>
        <div class="nav-items">
            <li><a href="../router.php">Inicio</a></li>
            <!-- <li><a href="horario/manana.php"><h5>Mañana</h5></a></li>
            <li><a href="horario/tarde.php"><h5>Tarde</h5></a></li>
            <li><a href="horario/noche.php"><h5>Noche</h5></a></li> -->
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
            <a href="#" class="nav__logo">
                <i class='bx bx-layer nav__logo-icon'></i>
                <span class="nav__logo-name">Infocal</span>
            </a>
            <div class="nav__list">
                <a href="../router.php" class="nav__link active">
                    <i class='bx bx-grid-alt nav__icon'></i>
                    <span class="nav__name">CLASES HOY</span>
                </a>
                <!-- <a href="../todas-las-clases/" class="nav__link">
                    <i class='bx bx-message-square-detail nav__icon'></i>
                    <span class="nav__name">CLASES ESTA<br>SEMANA</span>
                </a> -->
                <a href="../asignar/" class="nav__link">
                    <i class='bx bx-user nav__icon'></i>
                    <span class="nav__name">HERRAMIENTAS<br>MULTIMEDIA</span>
                </a>
                <!-- <a href="#" class="nav__link">
                    <i class='bx bx-bookmark nav__icon'></i>
                    <span class="nav__name">Favoritos</span>
                </a> -->
                <a href="../informes/" class="nav__link">
                    <i class='bx bx-folder nav__icon'></i>
                    <span class="nav__name">INFORMES</span>
                </a>
                <a href="../mi-perfil/" class="nav__link">
                    <i class='bx bx-bar-chart-alt-2 nav__icon'></i>
                    <span class="nav__name">MI PERFIL</span>
                </a>
            </div>
        </div>
        <a href="../../../logout.php" class="nav__link">
            <i class='bx bx-log-out nav__icon'></i>
            <span class="nav__name">Cerrar sesion</span>
        </a>
    </nav>
</div>