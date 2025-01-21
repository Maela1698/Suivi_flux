<div class="row" >
    <div class="col-xl-8 col-lg-8 col-md-8" >

        <nav class="navbar navbar-expand-lg navbar-light"
            style="margin-top: -50px;border-radius: 5px;background-color: white;width: 155%;margin-left: -15.5px;">
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            KPI
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('CRM.kpi') }}">Prevision de vente</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link" href="{{ route('DEV.planningDEV') }}" aria-haspopup="true"
                            aria-expanded="false" style="color: black">
                            Planning
                        </a>
                    </li>
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            Suivi
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('DEV.suiviPatronage') }}">Suivi Patronier</a>
                            <a class="dropdown-item" href="{{ route('DEV.suiviConso') }}">Suivi Conso</a>
                            <a class="dropdown-item" href="{{ route('DEV.suiviPlaceur') }}">Suivi Placeur</a>

                        </div>
                    </li>
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            Rapport
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('DEV.rapportMontageDev') }}">Rapport montage</a>
                            <a class="dropdown-item" href="{{ route('DEV.rapportFinition') }}">Rapport finition</a>
                            <a class="dropdown-item" href="{{ route('DEV.rapportControlePatronage') }}">Controle Patronage</a>
                            <a class="dropdown-item" href="{{ route('DEV.getControlFinalDev') }}">Controle final</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            Transmission
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('DEV.transmissionMerch') }}">Merch</a>
                            <a class="dropdown-item" href="{{ route('DEV.transmissionClientListe') }}">Client</a>
                        </div>
                    </li>
                </ul>
                <div class="form-inline my-2 my-lg-0" style="color: black;">
                    photo
                </div>
            </div>
        </nav>
    </div>

</div>
<br>
