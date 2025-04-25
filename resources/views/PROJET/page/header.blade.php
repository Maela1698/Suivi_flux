<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>L.O.I </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/css/owl.theme.default.min.css') }}">
    <link href="{{asset('vendor/jqvmap/css/jqvmap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

</head>

<style>
    .content-body .container-fluid {
        padding-right: 15px;
        padding-left: 15px;
    }
    .container-fluid {
        width: 100%;
        margin-right: auto;
        margin-left: auto;
        margin-top: -3.5%;
    }
    .entete {

        color: #7571f9; /* Ajuster la couleur du texte si n�cessaire */
    }
    .card-small {
        height: 110px; /* Ajustez cette valeur selon vos besoins */
        padding: 10px;
    }

    .card-small .card-title {
        font-size: 1.3rem; /* Taille de la police du titre */
    }

    .card-small h2 {
        font-size: 2rem; /* Taille de la police du chiffre */
    }

    .card-small .display-5 {
        font-size: 2.2rem; /* Taille de l'ic�ne */
        opacity: 0.5; /* Garder l'opacit� comme avant */
    }


    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        transform: translate3d(0, 0, 0);
        will-change: transform;
        display: none;
    }

    .texte {
        color: black;
    }
</style>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper" class="show menu-toggle">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header" style="height: 50px;">
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="./images/logoLoi.jpeg" alt="">
                <img class="logo-compact" src="./images/file.png" alt="">
                <img class="brand-title" src="./images/file.png" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger is-active">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header" style="height: 50px;">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">

                        </div>

                        <ul class="navbar-nav header-right" style="color: blue;font-size: 20px;">
                            <li class="nav-item dropdown notification_dropdown">
                                <span id="current-time"></span>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
        <script>
            function updateTime() {
                const timeElement = document.getElementById('current-time');
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const seconds = now.getSeconds().toString().padStart(2, '0');
                timeElement.textContent = `${hours}:${minutes}:${seconds}`;
            }

            // Mettre à jour l'heure toutes les secondes
            setInterval(updateTime, 1000);

            // Initialiser l'affichage de l'heure
            updateTime();
            </script>
