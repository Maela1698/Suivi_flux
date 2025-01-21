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
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            Serigraphie
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('SERIGRAPHIE.listeSerigraphie') }}">Liste</a>
                            {{--  <a class="dropdown-item" href="{{ route('DEV.suiviConso') }}">Ajout</a>
                            <a class="dropdown-item" href="{{ route('DEV.suiviPlaceur') }}">Pri</a>  --}}
                            <a class="dropdown-item" href="{{ route('SERIGRAPHIE.planningSerigraphie') }}">Planing Serigraphie</a>
                            <a class="dropdown-item" href="{{ route('SERIGRAPHIE.tacheFiniSerigraphie') }}">Tâche Fini</a>
                            {{--  <a class="dropdown-item" href="{{ route('DEV.suiviConso') }}">Planning Prod</a>  --}}
                            <a class="dropdown-item" href="{{ route('SERIGRAPHIE.listeSuiviFlux') }}">Suivi flux</a>
                            <a class="dropdown-item" href="{{ route('SERIGRAPHIE.listeRapportJournalier') }}">Rapport journalier</a>
                            <a class="dropdown-item" href="{{ route('SERIGRAPHIE.listeInspectionSerigraphie') }}">Inspection</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            LBT
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('LBT.listeLBT') }}">Liste</a>
                            <a class="dropdown-item" href="{{ route('LBT.listePlanningLBT') }}">Planning</a>
                            <a class="dropdown-item" href="{{ route('LBT.listePlanningFiniLBT') }}">Tâche Fini</a>
                            <a class="dropdown-item" href="{{ route('LBT.listeSuiviLBT') }}">Suivi flux</a>
                            <a class="dropdown-item" href="{{ route('LBT.listeRapportJournalierLBT') }}">Rapport journalier</a>
                            <a class="dropdown-item" href="{{ route('LBT.listeInspectionLBT') }}">Inspection</a>

                        </div>
                    </li>
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            Broderie Machine
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('BRODMACHINE.listeBroderieMachine') }}">Liste</a>
                            <a class="dropdown-item" href="{{ route('BRODMACHINE.planningBrodMachine') }}">Planning</a>
                            <a class="dropdown-item" href="{{ route('BRODMACHINE.tacheFiniBrodMachine') }}">Tâche Fini</a>
                            <a class="dropdown-item" href="{{ route('BRODMACHINE.listeSuiviFlux') }}">Suivi flux</a>
                            <a class="dropdown-item" href="{{ route('BRODMACHINE.listeInspectionBroderieMachine') }}">Inspection</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            Broderie Main
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('BRODMAIN.listeBroderieMain') }}">Liste</a>
                            <a class="dropdown-item" href="{{ route('BRODMAIN.planningBrodMain') }}">Planning</a>
                            <a class="dropdown-item" href="{{ route('BRODMAIN.planningFiniBrodMain') }}">Tâche Fini</a>
                            <a class="dropdown-item" href="{{ route('BRODMAIN.listeSuiviFluxBrodMain') }}">Suivi flux</a>
                            <a class="dropdown-item" href="{{ route('BRODMAIN.listeRapportJournalierBrodMain') }}">Rapport journalier</a>
                            <a class="dropdown-item" href="{{ route('BRODMAIN.listeInspectionBroderieMain') }}">Inspection</a>
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
