<div class="row">
    <div class="col-xl-8 col-lg-8 col-md-8">

        <nav class="navbar navbar-expand-lg navbar-light"
            style="margin-top: -50px;border-radius: 5px;background-color: white;width: 155%;margin-left: -15.5px;">
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link" href="{{ route('WMS.parite') }}" aria-haspopup="true" aria-expanded="false"
                            style="color: black">
                            Parité
                        </a>
                    </li>
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link" href="{{ route('WMS.rack') }}" aria-haspopup="true" aria-expanded="false"
                            style="color: black">
                            Rack
                        </a>
                    </li>
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link" href="{{ route('WMS.section') }}" aria-haspopup="true" aria-expanded="false"
                            style="color: black">
                            Section
                        </a>
                    </li>
                    {{-- <li class="nav-item dropdown mr-5">
                        <a class="nav-link" href="{{ route('WMS.section') }}" aria-haspopup="true" aria-expanded="false"
                            style="color: black">
                            Tableau de suivis
                        </a>
                    </li> --}}
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            Magasin
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('WMS.magasin-tissu') }}">Tissu</a>
                            <a class="dropdown-item" href="#">Tissu obsolète</a>
                            <a class="dropdown-item" href="#">Accessoire</a>
                            <a class="dropdown-item" href="#">Accessoire obsolète</a>
                            <a class="dropdown-item" href="#">Serigraphie</a>
                            <a class="dropdown-item" href="#">Teinture et lavage</a>
                            <a class="dropdown-item" href="#">Maintenance</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            BC et réservation
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">BC</a>
                            <a class="dropdown-item" href="#">Réservation</a>
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
