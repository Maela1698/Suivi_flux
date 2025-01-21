@include('CRM.header')
@include('CRM.sidebar')
<style>
    .static-field {
        padding: 8px;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 5px;
        color: #313030;
    }

    .static-label {
        font-weight: bold;
        font-size: 14px;
        color: black;
    }
</style>
<div class="content-body">
    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card">
            <div class="card-header py-3">
                <h4 class="text-primary m -0 font-weight-bold">Info du tissu</h4>
            </div>
            <div class="card-body">
                <div class="row g-0">
                    <div class="col-md-2 mt-1">
                        <center>
                            <img src="data:image/png;base64,{{ $stock->image }}" class="img-fluid rounded-start mb-5"
                                alt="Logo" width="200px" height="200px">
                        </center>
                    </div>
                    <div class="col-md-5">
                        <div class="card-body">
                            <p class="texte"><b>Designation : </b>
                                {{ $stock->designation }}</p>
                            <p class="texte"><b>Reference :</b> {{ $stock->reference }}</p>
                            <p class="texte"><b>Modèle :</b>{{ $stock->designation }}</p>
                            <p class="texte"><b>Style :</b>{{ $stock->designation }}</p>
                            <p class="texte"><b>Thème :</b>{{ $stock->designation }}</p>
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
        </div>
    </div>
</div>
@include('CRM.footer')
