<div class="row">
    <div class="col-xl-8 col-lg-8 col-md-8">
        <nav
            class="navbar navbar-expand-lg navbar-light"
            style="
                margin-top: -50px;
                border-radius: 5px;
                background-color: white;
                width: 155%;
                margin-left: -15.5px;
            "
        >
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown mr-5">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="navbarDropdownMenuLink"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            style="color: black"
                        >
                            Suivi
                        </a>
                        <div
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdownMenuLink"
                        >
                            <a class="dropdown-item" href="{{ route('MES.suiviFlux') }}">Flux</a>
                            <a class="dropdown-item" href="#">Horraire</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link" href="{{ route('MES.demande') }}" aria-haspopup="true"
                            aria-expanded="false" style="color: black">
                            Demande
                        </a>
                    </li>
                    <li class="nav-item dropdown mr-5">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="navbarDropdownMenuLink"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            style="color: black"
                        >
                            Gestion
                        </a>
                        <div
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdownMenuLink"
                        >
                            <a class="dropdown-item" href="#">Humaine</a>
                            <a class="dropdown-item" href="#">Compétences</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<br />
