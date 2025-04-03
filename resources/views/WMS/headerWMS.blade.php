<div class="row mb-4">
    <div class="col-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-white" style="margin-top: -50px; border-radius: 5px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown mr-3">
                        <a class="nav-link" href="{{ route('WMS.parite') }}" style="color: black">Parité</a>
                    </li>
                    <li class="nav-item dropdown mr-3">
                        <a class="nav-link" href="{{ route('WMS.rack') }}" style="color: black">Rack</a>
                    </li>
                    <li class="nav-item dropdown mr-3">
                        <a class="nav-link" href="{{ route('WMS.section') }}" style="color: black">Section</a>
                    </li>
                    <li class="nav-item dropdown mr-3">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMagasin"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            Magasin
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMagasin">
                            <a class="dropdown-item" href="{{ route('WMS.magasin-tissu') }}">Tissu</a>
                            {{-- TODO: FIXME --}}
                            <a class="dropdown-item" href="{{ route('WMS.tissu-stock-obsolete') }}">Tissu obsolète</a>
                            <a class="dropdown-item"
                                href="{{ route('WMS.page-magasin-wms', ['idtypewms' => 1]) }}">Accessoire</a>
                            <a class="dropdown-item" href="{{ route('WMS.page-obsolete-accessoire') }}">Accessoire
                                obsolète</a>
                            <a class="dropdown-item"
                                href="{{ route('WMS.page-magasin-wms', ['idtypewms' => 2]) }}">Serigraphie</a>
                            <a class="dropdown-item"
                                href="{{ route('WMS.page-magasin-wms', ['idtypewms' => 3]) }}">Teinture et lavage</a>
                            <a class="dropdown-item"
                                href="{{ route('WMS.page-magasin-wms', ['idtypewms' => 4]) }}">Maintenance</a>
                            <a class="dropdown-item"
                                href="{{ route('WMS.page-magasin-wms', ['idtypewms' => 5]) }}">Service Généraux</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown mr-3">
                        {{-- <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBC" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" style="color: black">
                            BC et réservation
                        </a> --}}
                        {{-- TODO: FIXME --}}
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBC" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" style="color: black">
                            Réservation
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownBC">
                            {{-- TODO: UNCOMMENT --}}
                            {{-- <a class="dropdown-item" href="#">BC</a> --}}
                            <a class="dropdown-item" href="{{ route('WMS.reservation-tissu-historique') }}">Réservation
                                Tissu</a>
                            <a class="dropdown-item" href="{{ route('WMS.reservation-wms-historique') }}">Réservation
                                Accessoire</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown mr-3">
                        {{-- <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBC" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" style="color: black">
                            BC et réservation
                        </a> --}}
                        {{-- TODO: FIXME --}}
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBC" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" style="color: black">
                            Qualité
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownBC">
                            {{-- TODO: UNCOMMENT --}}
                            {{-- <a class="dropdown-item" href="#">BC</a> --}}
                            <a class="dropdown-item" href="{{ route('QUALITETISSU.listeEntreeTissuInspecter') }}">Tissu</a>
                            <a class="dropdown-item"
                                href="{{ route('QUALITE.entree-accessoire-qualite') }}">Accessoire</a>
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
