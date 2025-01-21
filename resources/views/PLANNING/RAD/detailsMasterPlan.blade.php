<style>
    .entete {
        color: #7571f9;
        background-color: white;
    }
    .carte {
        color: white;
        background-color: white;
    }
    .texte {
        color: black;
    }
    .table {
        color: black;
    }
    /* .button-group {
        display: flex;
        justify-content: space-around;
    } */
    .button-group {
    display: flex;
    justify-content: flex-start; /* Align items to the left*/
    gap: 40px; /* Control the horizontal space between badges*/
    margin: 0; /* Remove unnecessary margins */
    }
    .form-group {
        margin: 0; /* Remove margin between form groups */
        padding: 5px; /* Optionally add a small padding */
    }

    .button-group form {
        margin-right: 10px; /* Adjust spacing as needed */
    }
    .form-inline .form-group {
        margin-right: 5px; /* Reduce the margin between form fields */
    }
    .form-inline .form-control {
        padding-left: 5px; /* Adjust padding if needed */
        padding-right: 5px; /* Adjust padding if needed */
    }
    .form-group.mb-2, .form-group.mx-sm-1.mb-2 {
        margin-bottom: 0; /* Remove bottom margin to bring elements closer */
    }
    .form-inline .form-control-plaintext {
        margin-right: 5px; /* Reduce space after "Stade" label */
    }
    .form-inline select, .form-inline button {
        margin-left: 5px; /* Reduce space before select and button */
    }
</style>
<style>
    .button-group {
    display: flex;
    margin: 20px;
    }

    .badge-container {
        margin-bottom: 10px; /* Espacement entre les éléments */
    }
    .badge {
        margin: 0; /* Ensure badges have no extra margin */
        padding: 0.25rem 0.75rem; /* Adjust padding for a tighter look */
        font-size: 1rem; /* Reduce font size if necessary */
    }
    .badge-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 10px; /* Space between each badge container Center the title and badge horizontally */
    }

    .badge-container h4 {
        margin: 0; /* Remove default margin from h4 */
    }

    .badge {
        margin-top: 5px; /* Space between the title and the badge */
    }


    .bdge1 {
        color: rgb(0, 0, 0);
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        font-size: 0.8rem;
    }

    .bdge1.badge.badge-outlined {
        background-color: transparent;
        border: 2px solid black; /* Définit la bordure */
        color: black; /* Couleur du texte */
    }

    .bdge2{
        color:white;
        width: 30px;
         height: 30px;
          display: flex;
          justify-content: center;
          align-items: center;
          border-radius: 50%;
          font-size: 0.8rem;
    }


</style>
<style>
    .card-body2 {
    display: flex;
    flex-direction: column; /* Place the divs vertically */
    justify-content: center; /* Center vertically */
    align-items: center; /* Center horizontally */
}
</style>
@include('CRM.header')
@include('CRM.sidebar')

<div class="content-body">
    <div class="container-fluid mt-3">
        @include('CRM.headerCrm')
        <div class="row" style="margin-bottom: -20px;margin-top: -10px; display:flex; flex-wrap:nowrap; justify-content: space-around">
            <div class="">
                <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 80px; background: linear-gradient(to right, #43cea2, #185a9d);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h6 class="card-title text-white" style="margin-bottom: 5px; font-size: 1.2rem;">MP</h6>
                            <div class="d-inline-block">
                                <h6 class="text-white" style="font-size: 1.5rem;">J- {{$ki[0]->ki_mp}} jours</h6>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: 2rem;"><i class="fa fa-list" style="color: white;"></i></span>
                    </div>
                </div>
            </div>

            <div class="">
                <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 80px; background: linear-gradient(to right, #43cea2, #185a9d);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h6 class="card-title text-white" style="margin-bottom: 5px; font-size: 1.2rem;">E</h6>
                            <div class="d-inline-block">
                                <h6 class="text-white" style="font-size: 1.5rem;">J- {{$ki[0]->ki_e}} jours</h6>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: 2rem;"><i class="fa fa-list" style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 80px; background: linear-gradient(to right, #43cea2, #185a9d);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h6 class="card-title text-white" style="margin-bottom: 5px; font-size: 1.2rem;">P</h6>
                            <div class="d-inline-block">
                                <h6 class="text-white" style="font-size: 1.5rem;">J- {{$ki[0]->ki_pr}} jours</h6>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: 2rem;"><i class="fa fa-list" style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 80px; background: linear-gradient(to right, #43cea2, #185a9d);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h6 class="card-title text-white" style="margin-bottom: 5px; font-size: 1.2rem;">JOUR PROD</h6>
                            <div class="d-inline-block">
                                <h6 class="text-white" style="font-size: 1.5rem;">J- {{$ki[0]->nbrjprod}} jours</h6>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: 2rem;"><i class="fa fa-clock" style="color: white;"></i></span>
                    </div>
                </div>
            </div>

                        @if($joursrestants[0]->jour_restants <= 0)
                <div class="">
                    <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 80px; background: linear-gradient(to right, #43cea2, #185a9d);">
                        <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                            <div>
                                <h6 class="card-title text-white" style="margin-bottom: 5px; font-size: 1.2rem;">RETARD PROD</h6>
                                <div class="d-inline-block">
                                    <h6 class="text-white" style="font-size: 1.5rem;">{{$joursrestants[0]->jour_restants}} jours</h6>
                                </div>
                            </div>
                            <span class="display-5" style="font-size: 2rem;"><i class="fas fa-hourglass-half" style="color: white;"></i></span>
                        </div>
                    </div>
                </div>
            @endif

            @if($joursrestants[0]->jour_restants > 0)
                <div class="">
                    <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 80px; background: linear-gradient(to right, #ff4e50, #ef3e22);
                    box-shadow: inset 0 0 10px rgba(60, 37, 37, 0.7), 0 0 15px rgba(251, 153, 153, 0.7), 0 0 30px rgba(255, 226, 226, 0.5);">
                        <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                            <div>
                                <h6 class="card-title text-white" style="margin-bottom: 5px; font-size: 1.2rem;">RETARD PROD</h6>
                                <div class="d-inline-block">
                                    <h6 class="text-white" style="font-size: 1.5rem;">{{$joursrestants[0]->jour_restants}} jours</h6>
                                </div>
                            </div>
                            <span class="display-5" style="font-size: 2rem;"><i class="fas fa-hourglass-half" style="color: white;"></i></span>
                        </div>
                    </div>
                </div>
            @endif


            {{-- box-shadow: 0 0 15px rgba(246, 242, 242, 0.7), 0 0 30px rgba(238, 236, 236, 0.5);"> --}}






        </div>
        <div class="card col-12 carte">
            <div class="card-header d-flex justify-content-center align-items-center entete">
                <h3 class="entete">DETAIL MASTER PLAN</h3>
            </div>

            <div class="card-body">
                <div class="row mt-3" style="display: flex; align-items: center;">
                        <div class="col-2">
                            {{-- <img src="{{ asset('storage/photos_commandes/'.$details[0]->photo_commande) }}" class="img-fluid rounded-start mb-5" alt="Logo" width="200px" height="200px"> --}}

                            <img src="data:image/png;base64,{{ $details[0]->photo_commande }}"
                            class="img-fluid rounded-start mb-5" alt="Logo" width="200px" height="200px">
                        </div>
                        <div class="col-5">

                        @if(isset($details[0]->id_recap_commande))
                            @if(isset($details[0]->podatecheked) && $details[0]->podatecheked == 10)
                                <p class="texte" style="font-size: 85%; color:#185a9d;">
                                    {{ \Carbon\Carbon::parse($details[0]->podate)->format('Y-m-d') }}
                                    {{ $details[0]->podate }}
                                </p>
                            {{-- <p class="texte"><b>PO Date :</b> {{ $details[0]->podate }}</p> --}}

                            @endif
                            @if(isset($details[0]->podatecheked) && $details[0]->podatecheked == 20)
                                <p class="texte"" style="font-size: 85%; color:yellow;">
                                    {{ \Carbon\Carbon::parse($details[0]->podate)->format('Y-m-d') }}
                                    {{ $details[0]->podate }}
                                </p>
                            {{-- <p class="texte"><b>PO Date :</b> {{ $details[0]->podate }}</p> --}}

                            @endif
                        @endif
                        @if(isset($details[0]->id_destination))
                            @if(isset($details[0]->etdcheked) && $details[0]->etdcheked == 10)
                                <p class="texte" style="font-size: 85%; color:green;">
                                    {{-- {{ \Carbon\Carbon::parse($details[0]->etdfinal)->format('Y-m-d') }} --}}
                                    {{ $details[0]->etdinitial }}
                                </p>
                            @endif
                            @if(isset($details[0]->etdcheked) && $details[0]->etdcheked == 20)
                                <p class="texte" style="font-size: 85%; color:purple;">
                                    {{-- {{ \Carbon\Carbon::parse($details[0]->etdfinal)->format('Y-m-d') }} --}}
                                    {{ $details[0]->etdinitial }}
                                </p>
                            @endif
                        @endif
                            <p class="texte"><b>PO Date :</b> {{ $details[0]->podate }}</p>
                            <p class="texte"><b>ETD (Estimated Time Departure) :</b>  {{ $details[0]->etdfinal }}</p>
                            <p class="texte"><b>Client :</b>  {{ $details[0]->nom_client }}</p>
                            <p class="texte"><b>Saison :</b>  {{ $details[0]->type_saison }}</p>
                            <p class="texte"><b>Modele :</b> {{ $details[0]->nom_modele }}</p>
                            <p class="texte"><b>Style :</b>  {{ $details[0]->nom_style }}</p>
                        </div>
                        <div class="col-5">
                            <p class="texte"><b>Numero Commande :</b> {{ $details[0]->numerocommande }}</p>
                            <p class="texte"><b>Quantité :</b>{{ $details[0]->qte_commande_provisoire }}</p>
                            <p class="texte"><b>Statut de la commande :</b>{{ $details[0]->statutcommande }}</p>
                            <p class="texte"><b>Statut Spécifique :</b>{{ $details[0]->designation_stade_specifique }}</p>
                        </div>
                </div>
                    <br>
                    <br>

                <h3>Progression jusqu'à Lead Time Reel :(= {{$progression[0]->leadtimereel}} jours )</h3>
                <div class="progress" style="height: 35px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated progress-bar-striped bg-info"
                    role="progressbar" style="width: {{$progression[0]->pourcentage_passe}}%"
                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                    <h5>{{$progression[0]->nbr_jour_passe}} jours passés</h5>
                    </div>
                </div>

                  <br>
                  <div class="card-body2">
                    <div class="button-group">
                        @foreach ($masterPlans as $plan)
                            @php
                                $idRecapCommande = $plan->id_recap_commande;
                                $retardTissu = isset($retardValues[$idRecapCommande]) ? $retardValues[$idRecapCommande]['retardTissu'] : null;
                                $retardAccessoire = isset($retardValues[$idRecapCommande]) ? $retardValues[$idRecapCommande]['retardAccessoire'] : null;
                            @endphp
                            @if($retardTissu === 30)
                                <div class="form-group form-check">
                                    <h5><label class="form-check-label" for="exampleCheck1" style="color: #343a40">BC TISSU</label></h5>
                                    <span class="badge badge-info" style="font-size: 120%">Pas encore</span>
                                </div>
                            @endif
                            @if($retardTissu === 10)
                            <div class="form-group form-check">
                            <h5><label class="form-check-label" for="exampleCheck1" style="color: #343a40">BC TISSU</label></h5>
                                <span class="badge badge-success" style="font-size: 120%">Passé</span>
                            </div>
                            @endif
                            @if($retardTissu === 20)
                            <div class="form-group form-check">
                                <h5><label class="form-check-label" for="exampleCheck1" style="color: #343a40">BC TISSU</label></h5>
                                <span class="badge badge-danger" style="font-size: 120%">Non Passé</span>
                            </div>
                            @endif
                            @if($retardAccessoire === 30)
                            <div class="form-group form-check">
                                <h5><label class="form-check-label" for="exampleCheck1" style="color: #343a40">BC ACCESSOIRE</label></h5>
                                <span class="badge badge-info" style="font-size: 120%">Pas encore</span>
                            </div>
                            @endif
                            @if($retardAccessoire === 10)
                            <div class="form-group form-check">
                                <h5><label class="form-check-label" for="exampleCheck1" style="color: #343a40">BC ACCESSOIRE</label></h5>
                                <span class="badge badge-success" style="font-size: 120%">Passé</span>
                            </div>
                            @endif
                            @if($retardAccessoire === 20)
                            <div class="form-group form-check">
                                <h5><label class="form-check-label" for="exampleCheck1" style="color: #343a40">BC ACCESSOIRE</label></h5>
                                <span class="badge badge-danger" style="font-size: 120%">Non Passé</span>
                            </div>
                            @endif
                        @endforeach
                        </div>

                        <div class="button-group">
                            <div class="badge-container">
                                <h4>MP</h4>
                                <span class="badge bg-info" style="font-size: 112%">{{\Carbon\Carbon::parse($datediff[0]->date_ki_mp)->format('Y-m-d') }}</span>
                            </div>
                            <div class="badge-container">
                                <h4>PPS</h4>
                                <span class="badge bg-success" style="font-size: 112%">{{ \Carbon\Carbon::parse($datediff[0]->date_ki_e)->format('Y-m-d') }}</span>
                            </div>
                            <div class="badge-container">
                                <h4>In Line</h4>
                                <span class="badge bg-warning" style="font-size: 112%">{{ \Carbon\Carbon::parse($datediff[0]->date_ki_pr)->format('Y-m-d') }}</span>
                            </div>
                            <div class="badge-container">
                                <h4>Export</h4>
                                <span class="badge bg-secondary" style="font-size: 112%">{{ \Carbon\Carbon::parse($progression[0]->jour_export)->format('Y-m-d') }}</span>
                            </div>
                        </div>
                  </div>

                    <br>

                    </div>
                    <div class="button-group">
                        <a href='{{route('LRP.listeMasterPlan')}}'>
                            <button type="button" class="btn btn-info btn-sm">Retour</button>
                        </a>
                    </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>

<style>
    .fixed-top-right {
    position: fixed;
    top: 0;
    right: 0;
    margin-top: 160px; /* Optionnel, pour donner un petit espace par rapport au bord */
    margin-right: 25px;
    z-index: 1000; /* Assure que le div reste au-dessus des autres éléments */
    }
    .settings-icon {
    font-size: 1.5rem; /* Taille de l'icône */
    cursor: pointer; /* Curseur pointeur au survol */
    color: #495057; /* Couleur de l'icône */
    transition: transform 0.5s ease-in-out; /* Transition pour la rotation */
    }

    .settings-icon:hover {
        transform: rotate(180deg); /* Rotation au survol */
    }

    .custom-card {
        background-color: #343a40; /* Couleur de fond foncée */
        border-radius: 8px; /* Bordure arrondie */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ombre pour un effet de relief */
        display: none; /* Caché par défaut */
        margin-top: 10px; /* Espacement entre l'icône et le menu */
    }

    .custom-card .btn {
        width: 100%; /* Assure que les boutons prennent toute la largeur */
        text-align: left; /* Aligne le texte et l'icône à gauche */
        color: #fff; /* Couleur du texte blanche */
        background-color: #495057; /* Couleur de fond des boutons */
        border: none; /* Supprime la bordure */
        transition: background-color 0.3s; /* Transition douce pour le changement de couleur */
    }

    .custom-card .btn:hover {
        background-color: #6c757d; /* Changement de couleur au survol */
    }

    .custom-card i {
        margin-right: 8px; /* Espace entre l'icône et le texte */
    }
</style>
<div class="col-md-1 fixed-top-right">
    <div class="d-flex flex-column align-items-end">
        <!-- Icône Paramètres -->
        <div class="settings-icon" id="settings-icon">
            <i class="fas fa-cog"></i>
        </div>

        <!-- Carte avec les boutons -->
        <div class="card p-2 custom-card" id="settings-menu">
            <!-- Bouton Matière Première -->
            <form action="{{ route('CRM.listeMatierePremiere') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Matière Première">
                    <i class="fas fa-box-open"></i> M.P
                </button>
            </form>

            <!-- Bouton SDC -->
            <form action="{{ route('CRM.sdc') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="SDC">
                    <i class="fas fa-tasks"></i> SDC
                </button>
            </form>

            <!-- Bouton FDC -->
            <form action="listeFDC" method="post">
                <input type='hidden' name='idDemandeClient' value="<%= listeDemande.get(0).getId()%>">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="FDC">
                    <i class="fas fa-check-double"></i> FDC
                </button>
            </form>

            <!-- Bouton SMV -->
            <form action="{{ route('CRM.smv') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="SMV">
                    <i class="fas fa-stopwatch"></i> SMV
                </button>
            </form>

            <!-- Bouton PRI -->
            <form action="{{ route('CRM.pri') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="PRI">
                    <i class="fas fa-money-bill-wave"></i> PRI
                </button>
            </form>

            <!-- Bouton Envoie Échantillon -->
            <form action="{{ route('CRM.echantillon') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Envoie Échantillon">
                    <i class="fas fa-shipping-fast"></i> E.E
                </button>
            </form>

            <!-- Bouton Bon de Commande -->
            <form action="{{ route('CRM.bc') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Bon de Commande">
                    <i class="fas fa-file-alt"></i> B.C
                </button>
            </form>
        </div>
    </div>
</div>
@include('CRM.footer')
