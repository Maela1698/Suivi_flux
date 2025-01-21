@include('CRM.header')
@include('CRM.sidebar')
<title>FDC</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .form-control {
        border: 1px solid #b5b5b5;
    }

    label {
        color: #767575;
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div class="row">
            <div class="card col-12">
                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">DEMANDE DE CONSO </h3>

                </div>

                <div class="card-body" style="background-color: rgb(239, 238, 238); border-radius: 10px;">
                    <center>  <h2>{{ $demande[0]->type_saison }}</h2></center>
                    <div class="row mt-3" style="display: flex; align-items: center;">
                        <div class="col-md-2 mt-1">
                            <center>
                                <img src="data:image/png;base64,{{ $demande[0]->photo_commande }}"
                                    class="img-fluid rounded-start mb-5" alt="Logo" width="120px" height="120px">
                            </center>
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <p class="texte"><b>Date entrée :</b>
                                    {{ \Carbon\Carbon::parse($demande[0]->date_entree)->format('d/m/y') }}</p>
                                    <p class="texte"><b>Periode :</b> {{ $demande[0]->periode }}</p>
                                <p class="texte"><b>Client :</b> {{ $demande[0]->nomtier }}</p>
                                <p class="texte"><b>Modèle :</b>{{ $demande[0]->nom_modele }}</p>
                                <p class="texte"><b>Designation :</b>{{ $demande[0]->nom_style }}</p>
                                <p class="texte"><b>Thème :</b>{{ $demande[0]->theme }}</p>
                                <p class="texte"><b>Quantité prévisionnel
                                        :</b>{{ $demande[0]->qte_commande_provisoire }}</p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <p class="texte">
                                    <b>ETD:</b>{{ \Carbon\Carbon::parse($demande[0]->date_livraison)->format('d/m/y') }}
                                </p>
                                <p class="texte"><b>Stade :</b> {{ $demande[0]->type_stade }}</p>
                                <p class="texte"><b>Grille de taille
                                        :</b>{{ $demande[0]->taillemin }}--{{ $demande[0]->taillemax }}</p>
                                <p class="texte"><b>Taille de base :</b>{{ $demande[0]->taille_base }}</p>
                                <p class="texte"><b>Incontern :</b> {{ $demande[0]->type_incontern }}</p>
                                <p class="texte"><b>Phase :</b> {{ $demande[0]->type_phase }}</p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card-body">

                    <div class="sdc" style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="button-group" style="display: flex; gap: 10px;">
                            <form action="{{ route('CRM.fdcApercu') }}" method="GET">
                                <button type="submit" class="btn btn-info">Aperçue</button>
                            </form>
                            <form action=" {{ route('CRM.formAjoutFDC') }} " method="get">
                                @csrf
                                <button type="submit" class="btn btn-success">Ajouter</button>
                            </form>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>


<!--**********************************
        modal start
***********************************-->



@include('CRM.parametre')

<!--**********************************
        javascript start
***********************************-->

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
