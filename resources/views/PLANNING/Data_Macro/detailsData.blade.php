<style>
    .entete {
        color: #7571f9; /* Ajuster la couleur du texte si n�cessaire */
        background-color: white;
    }
    .carte {
        color: white; /* Ajuster la couleur du texte si n�cessaire */
        background-color: white;
    }
    .texte {
        color: black;
    }
    .table {
        color: black;
    }
    .qte{
        height: 50px;
        width: 100px;
    }
    .checkbox-container {
        display: flex;
        flex-wrap: wrap;
    }
    .checkbox-item {
        flex: 0 0 19%; /* R�partir en quatre colonnes */
        margin: 1%; /* Espacement entre les checkboxes */
        box-sizing: border-box; /* Inclure les marges dans la taille totale */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        display: flex;
        align-items: center;
        color: black;
    }
    .checkbox-item input[type="checkbox"] {
        margin-right: 10px; /* Espacement entre le checkbox et le texte */
    }
    .checkbox-item label {
        margin: 0; /* R�initialiser les marges du label */
    }
    .checkbox-item:hover {
        background-color: #e6f7ff;
        border-color: #007bff;
    }
    .requete{
        height:  100px;
    }

</style>
<style>
    .custom-tooltip .tooltip-inner {
        background-color: #f8d7da; /* Couleur de fond */
        color: #721c24; /* Couleur du texte */
        font-size: 16px; /* Taille du texte */
        padding: 10px; /* Espacement */
    }
    .custom-tooltip .arrow::before {
        border-top-color: #f8d7da; /* Couleur de la fl�che */
    }
</style>

@include('CRM.header')
@include('CRM.sidebar')

<!--**********************************
        Content body start
***********************************-->

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')

        <div class="col-md-11">
            <div class="card col-12 carte" style="margin-left: 50px;">
                <div class="card-header d-flex justify-content-between align-items-center entete">
                    <h3 class="entete">DETAILS : DEMANDE CLIENT</h3>
                </div>
                <div class="card-body">
                    <div class="card mb-2">
                        <div class="row g-0">
                            <div class="col-md-2 mt-2">
                                <center>
                                    <img src=" asset('storage/photos_commandes/' . photo_commande)" class="img-fluid rounded-start mb-5" alt="Logo" width="200px" height="200px">
                                </center>
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    {{-- <p>{{$deets[0]->numerocommande}}</p> --}}
                                    <p class="texte"><b>SMV Prod :</b>  {{$deets[0]->smv_prod}}</p>
                                    <p class="texte"><b>SMV Print :</b>  {{$deets[0]->prix_print}}</p>
                                    <p class="texte"><b>Date entrée :</b>{{$deets[0]->podate}}</p>
                                    <p class="texte"><b>ETD (Estimated Time Departure) :</b>{{$deets[0]->etdrevise}}  </p>
                                    <p class="texte"><b>Nom du client :</b>{{$deets[0]->nom_client}} </p>
                                    <p class="texte"><b>Saison :</b>{{$deets[0]->type_saison}}   </p>
                                    <p class="texte"><b>Incontern :</b>{{$deets[0]->type_incontern}}</p>
                                    <p class="texte"><b>Phase :</b>{{$deets[0]->type_phase}}</p>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <p class="texte"><b>Stade :</b>{{$deets[0]->type_stade}}  </p>
                                    <p class="texte"><b>Nom du modèle :</b>{{$deets[0]->nom_modele}}  </p>
                                    <p class="texte"><b>Thème :</b>{{$deets[0]->theme}}  </p>
                                    <p class="texte"><b>Style :</b> {{$deets[0]->type_phase}} nom_style</p>
                                    <p class="texte"><b>Quantité prévisionnelle :</b>{{$deets[0]->type_phase}}  qte_commande_provisoire</p>
                                    <p class="texte"><b>Grille de taille :</b>{{$deets[0]->taillemin}}--{{$deets[0]->taillemax}}</p>
                                    <p class="texte"><b>Taille de base :</b>{{$deets[0]->taille_base}}  </p>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>

                    {{-- <div class="form-group row">
                        <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                            <form action="{{ route('CRM.listeDemande') }}" method="GET">
                                <button type="submit" class="btn btn-success mr-3">Voir liste</button>
                            </form>

                            <form action='{{ route('CRM.updateDemande') }}' method='POST'>
                                @csrf
                                <button type="submit" class="btn btn-warning mr-3">Modifier</button>
                            </form>
                            <form id="validateForm" action="{{ route('CRM.valideDemande') }}" method="get">
                                <input type="hidden" value="{{ $demande[0]->id }}" name="idDemande">
                                <button type="submit" class="btn btn-info mr-3">Validé</button>
                            </form>
                            <form id="cancelForm" action="{{ route('CRM.annuleDemande') }}" method="get">
                                <input type="hidden" value="{{ $demande[0]->id }}" name="idDemande">
                                <button type="submit" class="btn btn-warning mr-3">Annulé</button>
                            </form>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"  style="height: 35px;">
                                Supprimer
                            </button>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

<!--**********************************
        modal start
***********************************-->

<!--**********************************
        modal end
***********************************-->
{{-- @include('CRM.parametre') --}}


<!--**********************************
        javascript start
***********************************-->



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
            <form action="{{ route('LRP.dataprod',['numerocommande' => $deets[0]->numerocommande,'iddemandeclient'=>$deets[0]->demande_client_id]) }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Data Prod">
                    <i class="fas fa-box-open"></i>Prod
                </button>
            </form>

            <!-- Bouton SDC -->
            <form action="{{ route('LRP.dataprint',['numerocommande' => $deets[0]->numerocommande,'iddemandeclient'=>$deets[0]->demande_client_id]) }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Data Print">
                    <i class="fas fa-tasks"></i> Print
                </button>
            </form>

             <!-- Bouton FDC -->
             <form action="{{route('LRP.databm',['numerocommande' => $deets[0]->numerocommande,'iddemandeclient'=>$deets[0]->demande_client_id]) }}" method="get">
                <input type='hidden' name='idDemandeClient' value="<%= listeDemande.get(0).getId()%>">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Data Brod Machine">
                    <i class="fas fa-hand-paper"></i> BM
                </button>
            </form>

            <!-- Bouton mon_prod -->
            <form action="{{ route('LRP.databmc',['numerocommande' => $deets[0]->numerocommande,'iddemandeclient'=>$deets[0]->demande_client_id]) }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Data Brod Main">
                    <i class="fas fa-cog"></i>BMC
                </button>
            </form>

            <!-- Bouton PRI -->
            <form action="{{ route('LRP.datalbt',['numerocommande' => $deets[0]->numerocommande,'iddemandeclient'=>$deets[0]->demande_client_id]) }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Data LBT">
                    <i class="fas fa-hands-wash"></i>LBT
                </button>
            </form>
        </div>
    </div>
</div>


<script>
    document.getElementById('settings-icon').addEventListener('mouseover', function() {
    document.getElementById('settings-menu').style.display = 'block';
    });

    document.getElementById('settings-menu').addEventListener('mouseleave', function() {
        document.getElementById('settings-menu').style.display = 'none';
    });
</script>


<!--**********************************
        javascript start
***********************************-->

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')

