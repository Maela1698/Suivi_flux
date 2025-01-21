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
                            KPI
                        </a>
                        <div
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdownMenuLink"
                        >
                            <a
                                class="dropdown-item"
                                href="{{ route('CRM.kpi') }}"
                                >Prevision de vente</a
                            >
                            <a class="dropdown-item" href="#">Développement</a>
                            <a class="dropdown-item" href="#">Livraison</a>
                        </div>
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
                            Tiers
                        </a>
                        <div
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdownMenuLink"
                        >
                            <a
                                class="dropdown-item"
                                href="{{ route('CRM.accueil') }}"
                                >Liste Tier</a
                            >
                            <a
                                class="dropdown-item"
                                href="{{ route('CRM.ajoutTier') }}"
                                >Ajout Tier</a
                            >
                        </div>
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
                            Commande
                        </a>
                        <div
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdownMenuLink"
                        >
                            <a
                                class="dropdown-item"
                                href="{{ route('CRM.listeDemande') }}"
                                >Liste Demande</a
                            >
                            <a
                                class="dropdown-item"
                                href="{{ route('CRM.ajoutDemande') }}"
                                >Ajout Demande</a
                            >
                        </div>
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
                            TSCF
                        </a>
                        <div
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdownMenuLink"
                        >
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#"
                                >Something else here</a
                            >
                        </div>
                    </li>
                </ul>
                <div
                    class="form-inline my-2 my-lg-0"
                    style="color: black"
                ></div>
            </div>
        </nav>
    </div>
</div>
<br />
