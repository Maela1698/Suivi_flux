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

    .button-group {
        display: flex;
        justify-content: space-around;
    }

    .button-group form {
        margin-right: 10px;
    }

    .form-inline .form-group {
        margin-right: 5px;
    }

    .form-inline .form-control {
        padding-left: 5px;
        padding-right: 5px;
    }

    .form-group.mb-2,
    .form-group.mx-sm-1.mb-2 {
        margin-bottom: 0;
    }

    .form-inline .form-control-plaintext {
        margin-right: 5px;
    }

    .form-inline select,
    .form-inline button {
        margin-left: 5px;
    }

    .delete-btn {
        position: absolute;
        right: 20px;
        top: 10px;
    }

    #suggestionsListClient {
        max-height: 200px;
        overflow-y: auto;
        color: #767575;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }

    .suggestions-list {
        max-height: 200px;
        overflow-y: auto;
        color: #767575;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }
</style>

@include('CRM.header')
@include('CRM.sidebar')

<div class="content-body">
    <div class="container-fluid mt-3">
        @include('CRM.headerBc')
        <div class="card col-12 carte">
            <div class="card-header d-flex justify-content-center align-items-center entete">
                @if ($idbc == 1)
                    <h3 class="entete">BC TISSUS</h3>
                @endif
                @if ($idbc == 2)
                    <h3 class="entete">BC ACCESSOIRE</h3>
                @endif
                @if ($idbc == 3)
                    <h3 class="entete">BC COUPE TYPE</h3>
                @endif


            </div>

            <div class="card-body">
                <div class="row mt-3"
                    style="display: flex; align-items: center; justify-content: space-between; border-bottom: solid 3px lightgrey;">
                    <div class="col-5" style="margin-left: 100px;">
                        <img src="../images/NEW LOGO.png" class="img-fluid rounded-start mb-5" alt="Logo" width="200"
                            height="200px">
                    </div>
                    <div class="col-5" style="margin-top: -60px; margin-left:30px;">
                        <p class="texte mb-0"><b>Société Anonyme avec conseil d'administration</b></p>
                        <p class="texte mb-0"><b>au capital de 148 400 000 Ariary</b></p>
                        <p class="texte mb-0"><b>LOT 03810D Ambohitrangano Sabotsy Namehana</b></p>
                        <p class="texte mb-0"><b>Antananarivo 103</b></p>
                        <p class="texte mb-0"><b>NIF: 2000100388</b></p>
                        <p class="texte mb-0"><b>STAT: 14105 11 1995 0 00077</b></p>
                        <p class="texte mb-0"><b>Décret d'agrément n°95-410 du 30 Mai 1995</b></p>
                        <p class="texte mb-0"><b>TEL 22 451 54 / 22 534 84</b></p>
                        <p class="texte mb-0"><b>FAX / 24 741 05</b></p>
                    </div>
                </div>

                <br>
                <form id="bcTissusForm" action="{{ route('CRM.insertBc') }}" method="post">
                    @csrf
                    <input type="hidden" name="idbc" value="{{ $idbc }}">
                    <div class="test" style="display: block;">
                        <div class="input-group mb-1" style="width: 370px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="width: 151px;">Date :</span>
                            </div>
                            <input type="date" class="form-control custom-input" name="dateBc">
                        </div>

                        <div class="input-group mb-1" style="width: 370px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="width: 151px;">N° BC :</span>
                            </div>
                            <input type="text" class="form-control" name="numero"
                                value="{{ $numero }}_{{ $typebcbyid[0]->type_bc }}/LOI/{{ date('Y') }}"
                                readonly>
                        </div>

                        <div class="input-group mb-1" style="width: 370px;">
                            <div class="input-group-prepend">
                                <label class="input-group-text" style="width: 151px;">Fournisseur</label>
                            </div>
                            <select class="custom-select" name="fournisseur">
                                <option selected>Choisir un fournisseur...</option>
                                @foreach ($fournisseur as $f)
                                    <option value="{{ $f->id }}">{{ $f->nomtier }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group mb-1" style="width: 370px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Échéance Livraison :</span>
                            </div>
                            <input type="date" class="form-control" name="echeance">
                        </div>

                        <!-- Div principal pour le client -->
                        <div class="col-5" style="float: right; margin-top: -155px; position: relative;">
                            <div id="client-section">
                                <div class="input-group mb-1" style="width: 370px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width: 151px;">Modele :</span>
                                    </div>
                                    <input type="text" id="nomClient" class="form-control" required>
                                    <input type="hidden" id="idClient" class="form-control" name="nomClient0">
                                    <ul id="suggestionsListClient" class="list-group mt-2" style="display: none;"></ul>
                                </div>
                            </div>
                            <button type="button" id="add-client" class="btn btn-primary"
                                style="position: absolute; right: 86px; top: 3;display:none">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>


                        <input type="hidden" id="totalClients" name="totalClients" value="0">
                        <!-- Conteneur pour les nouveaux divs -->
                        <div id="additional-clients" style="clear: both;"></div>

                        <button type="button" class="btn btn-primary" id="saveButton">Save</button>
                    </div>
                </form>

                <div class="tests" style="display: none;margin-top: -10px;">
                    @if (!empty($allbc))
                        @foreach ($allbc as $ab)
                            <div class="input-group mb-1" style="width: 370px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 151px;">Date :</span>
                                </div>
                                <input type="date" class="form-control custom-input" value="{{ $ab->date_bc }}"
                                    readonly>
                            </div>

                            <div class="input-group mb-1" style="width: 370px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 151px;">N° BC :</span>
                                </div>
                                <input type="text" class="form-control" name="numero"
                                    value="{{ $ab->numero_bc }}" readonly>
                            </div>

                            <div class="input-group mb-1" style="width: 370px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 151px;">Fournisseur :</span>
                                </div>
                                <input type="text" class="form-control custom-input" value="{{ $ab->nomtier }}"
                                    readonly>
                            </div>

                            <div class="input-group mb-1" style="width: 370px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Échéance Livraison :</span>
                                </div>
                                <input type="date" class="form-control" value="{{ $ab->echeance }}" readonly>
                            </div>

                            <div class="input-group mb-1" style="width: 370px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 151px;">Pays :</span>
                                </div>
                                <input type="text" class="form-control custom-input" value="{{ $ab->pays }}"
                                    readonly>
                            </div>

                            <div class="input-group mb-1" style="width: 370px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 151px;">Local/import :</span>
                                </div>
                                @if ($ab->pays == 'Madagascar')
                                    <input type="text" class="form-control custom-input" value="Local" readonly>
                                @endif
                                @if ($ab->pays != 'Madagascar')
                                    <input type="text" class="form-control custom-input" value="Import" readonly>
                                @endif
                            </div>
                        @endforeach
                        <div class="input-group mb-1" style="width: 370px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="width: 151px;">ATTN :</span>
                            </div>
                            @php
                                $value = collect($attn)->pluck('nominterlocateur')->implode('/');
                            @endphp
                            <input type="text" id="nomClient" class="form-control" value="{{ $value }}"
                                readonly>
                        </div>
                    @endif

                    <!-- Div principal pour le client -->
                    <div class="col-5" style="float: right; margin-top: -275px; position: relative;">

                        <div id="client-section">
                            <div class="input-group mb-1" style="width: 370px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 151px;">Client :</span>
                                </div>
                                @if(!empty($demande) && isset($demande[0][0]->nomtier))
                                    <input type="text" id="nomClient" class="form-control" value="{{ $demande[0][0]->nomtier }}" readonly>
                                @endif

                            </div>

                            <div class="input-group mb-1" style="width: 370px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 151px;">Saison</span>
                                </div>

                                @if(!empty($demande) && isset($demande[0][0]->type_saison))
                                    <input type="text" id="nomClient" class="form-control" value="{{ $demande[0][0]->type_saison }}" readonly>
                                @endif

                            </div>

                        </div>

                    </div>
                    <table class="table table" style="background-color: lightgrey;">
                        <thead>
                            <tr>
                                <th scope="col" style="color: black;">REF</th>
                                <th scope="col" style="color: black;">DESIGNATION</th>
                                @if ($idbc == 1 || $idbc == 3)
                                    <th scope="col" style="color: black;">LAIZE</th>
                                @endif
                                @if ($idbc == 2)
                                    <th scope="col" style="color: black;">UTILISATION</th>
                                @endif
                                <th scope="col" style="color: black;">MODELE</th>
                                <th scope="col" style="color: black;">COULEUR</th>
                                <th scope="col" style="color: black;">QUANTITE</th>
                                <th scope="col" style="color: black;">UNITE</th>
                                <th scope="col" style="color: black;">PU</th>
                                <th scope="col" style="color: black;">DEVISE</th>
                                <th scope="col" style="color: black;">PRIX TOTAL</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">

                            @if (session('detaildonne'))
                                @foreach (session('detaildonne') as $dtd)
                                    @php
                                        $mods = [];

                                        // Parcourir chaque sous-tableau pour récupérer les valeurs de 'type_saison'
                                        foreach ($demande as $subArray) {
                                            foreach ($subArray as $item) {
                                                // Ajouter la valeur de 'type_saison' si elle existe
                                                if (isset($item['nom_modele'])) {
                                                    $mods[] = $item['nom_modele'];
                                                }
                                            }
                                        }

                                        // Concaténer les valeurs avec un délimiteur '/'
                                        $mod = implode('/', $mods);
                                    @endphp
                                    <form action="{{ route('CRM.deleteBc') }}" method="post">
                                        @csrf
                                        <tr style="background-color: lightblue" data-id="{{ $dtd->id }}">
                                            <th scope="row" style="color: black;"></th>
                                            <td>
                                                <input type='text' name="designation"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $dtd->designation }}" readonly>
                                            </td>
                                            <td>
                                                @if ($idbc == 1 || $idbc == 3)
                                                    <input type='text' name="laize_utile"
                                                        style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                        value="{{ $dtd->laize }}" readonly>
                                                @endif
                                                @if ($idbc == 2)
                                                    <input type='text' name="utilisation"
                                                        style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                        value="{{ $dtd->utilisation }}" readonly>
                                                @endif

                                            </td>

                                            <td>
                                                <input type='text'
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $mod }}" readonly>
                                            </td>
                                            <td>
                                                <input type='text' name="couleur"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $dtd->couleur }}" readonly>
                                            </td>
                                            <td>
                                                <input type='text' name="quantite"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $dtd->quantite }}" readonly>
                                            </td>
                                            <td>
                                                <input type='text' name="unite_mesure"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $dtd->unite }}" readonly>
                                            </td>
                                            <td>
                                                <input type='number' name="pri"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $dtd->prix_unitaire }}" readonly>
                                            </td>
                                            <td>
                                                <input type='text' name="unite"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $dtd->devise }}" readonly>
                                            </td>
                                            <td><input type='text' name="unite"
                                                style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                value="{{ $dtd->prix_unitaire * $dtd->quantite }}" readonly></td>
                                            <td>
                                                <input type="hidden" name="idbc" value="{{ $idbc }}">
                                                <input type="hidden" name="iddonnebc" value="{{ $dtd->id }}">
                                                <button type="submit" onclick="deleteRow(this)"
                                                    class="btn btn-danger">Supprimer</button>
                                            </td>
                                        </tr>
                                    </form>
                                @endforeach
                            @endif
                            @if (session('tissus') && $idbc == 1)
                                @foreach (session('tissus') as $tissu)
                                    @php
                                        $mods = [];

                                        // Parcourir chaque sous-tableau pour récupérer les valeurs de 'type_saison'
                                        foreach ($demande as $subArray) {
                                            foreach ($subArray as $item) {
                                                // Ajouter la valeur de 'type_saison' si elle existe
                                                if (isset($item['nom_modele'])) {
                                                    $mods[] = $item['nom_modele'];
                                                }
                                            }
                                        }

                                        // Concaténer les valeurs avec un délimiteur '/'
                                        $mod = implode('/', $mods);
                                    @endphp
                                    <form action="{{ route('CRM.ajoutBcTissus') }}" method="post">
                                        @csrf
                                        <tr>
                                            <th scope="row" style="color: black;"></th>
                                            <td>
                                                <input type='text' name="designation{{ $tissu->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $tissu->designation }}">
                                            </td>
                                            <td>
                                                <input type='text' name="laize_utile{{ $tissu->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $tissu->laize_utile }}">
                                            </td>

                                            <td>
                                                <input type='text'
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $mod }}" readonly>
                                            </td>

                                            <td>
                                                <input type='text' name="couleur{{ $tissu->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $tissu->couleur }}">
                                            </td>
                                            <td>
                                                <input type='text' name="quantite{{ $tissu->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $tissu->quantite }}">
                                            </td>
                                            <td>
                                                <input type='text' name="unite_mesure{{ $tissu->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $tissu->unite_mesure }}" readonly>
                                            </td>
                                            <td>
                                                <input type='number' name="pri{{ $tissu->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="0">
                                            </td>
                                            <td>
                                                <input type='text' name="unite{{ $tissu->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $tissu->unite }}" readonly>
                                            </td>
                                            <td></td>
                                            <td>
                                                <input type="hidden" name="idtissus" value="{{ $tissu->id }}">
                                                <input type="hidden" id="idbc" name="idbc"
                                                    value="{{ $idbc }}">
                                                <input type="hidden" name="numero_bc"
                                                    value="{{ $numero - 1 }}_{{ $typebcbyid[0]->type_bc }}/LOI/{{ date('Y') }}">
                                                <button onclick="saveRow(this)" type="submit"
                                                    class="btn btn-success">Enregistrer</button>
                                            </td>
                                        </tr>
                                    </form>
                                @endforeach
                            @endif

                            @if (session('accessoire') && $idbc == 2)
                                @foreach (session('accessoire') as $acc)
                                    @php
                                        $mods = [];

                                        // Parcourir chaque sous-tableau pour récupérer les valeurs de 'type_saison'
                                        foreach ($demande as $subArray) {
                                            foreach ($subArray as $item) {
                                                // Ajouter la valeur de 'type_saison' si elle existe
                                                if (isset($item['nom_modele'])) {
                                                    $mods[] = $item['nom_modele'];
                                                }
                                            }
                                        }

                                        // Concaténer les valeurs avec un délimiteur '/'
                                        $mod = implode('/', $mods);
                                    @endphp
                                    <form action="{{ route('CRM.ajoutBcTissus') }}" method="post">
                                        @csrf
                                        <tr>
                                            <th scope="row" style="color: black;"></th>
                                            <td><input type='text' name="designation{{ $acc->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px;border: none;"
                                                    value="{{ $acc->designation }}"></td>
                                            <td><input type='text' name="utilisation{{ $acc->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px;border: none;"
                                                    value="{{ $acc->utilisation }}"></td>

                                            <td><input type='text'
                                                    style="width: 100%; box-sizing: border-box; padding: 4px;border: none;"
                                                    value="{{ $mod }}" readonly></td>

                                            <td><input type='text' name="couleur{{ $acc->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px;border: none;"
                                                    value="{{ $acc->couleur }}"></td>
                                            <td><input type='text'
                                                    style="width: 100%; box-sizing: border-box; padding: 4px;border: none;"
                                                    name="quantite{{ $acc->id }}" value="{{ $acc->quantite }}">
                                            </td>
                                            <td><input type='text' name="unite_mesure{{ $acc->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px;border: none;"
                                                    value="{{ $acc->unite_mesure }}"></td>
                                            <td><input type='number'
                                                    style="width: 100%; box-sizing: border-box; padding: 4px;border: none;"
                                                    name="pri{{ $acc->id }}" value="0"></td>
                                            <td><input type='text' name="unite{{ $acc->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px;border: none;"
                                                    value="{{ $acc->unite }}"></td>
                                            <td></td>
                                            <td>
                                                <input type="hidden" name="idaccessoire"
                                                    value="{{ $acc->id }}">
                                                <input type="hidden" id="idbc" name="idbc"
                                                    value="{{ $idbc }}">
                                                <input type="hidden" name="numero_bc"
                                                    value="{{ $numero - 1 }}_{{ $typebcbyid[0]->type_bc }}/LOI/{{ date('Y') }}">
                                                <button onclick="saveRow(this)" type="submit"
                                                    class="btn btn-success">Enregistrer</button>
                                            </td>
                                        </tr>
                                    </form>
                                @endforeach
                            @endif

                            @if (session('tissus') && $idbc == 3)
                                @foreach (session('tissus') as $tissu)
                                    <form action="{{ route('CRM.ajoutBcTissus') }}" method="post">
                                        @csrf
                                        <tr>
                                            <th scope="row" style="color: black;"></th>
                                            <td>
                                                <input type='text' name="designation{{ $tissu->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $tissu->designation }}">
                                            </td>
                                            <td>
                                                <input type='text' name="laize_utile{{ $tissu->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $tissu->laize_utile }}">
                                            </td>
                                            @if (session('mod'))
                                                @foreach (session('mod') as $mods)
                                                    <td>
                                                        <input type='text'
                                                            style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                            value="{{ $mods->nom_modele }}" readonly>
                                                    </td>
                                                @endforeach
                                            @else
                                                <td>
                                                    <input type='text'
                                                        style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                        value="" readonly>
                                                </td>
                                            @endif
                                            <td>
                                                <input type='text' name="couleur{{ $tissu->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $tissu->couleur }}">
                                            </td>
                                            <td>
                                                <input type='text' name="quantite{{ $tissu->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="5">
                                            </td>
                                            <td>
                                                <input type='text' name="unite_mesure{{ $tissu->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $tissu->unite_mesure }}" readonly>
                                            </td>
                                            <td>
                                                <input type='number' name="pri{{ $tissu->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="5">
                                            </td>
                                            <td>
                                                <input type='text' name="unite{{ $tissu->id }}"
                                                    style="width: 100%; box-sizing: border-box; padding: 4px; border: none;"
                                                    value="{{ $tissu->unite }}" readonly>
                                            </td>
                                            <td></td>
                                            <td>
                                                <input type="hidden" name="idtissus" value="{{ $tissu->id }}">
                                                <input type="hidden" id="idbc" name="idbc"
                                                    value="{{ $idbc }}">
                                                <input type="hidden" name="numero_bc"
                                                    value="{{ $numero - 1 }}_{{ $typebcbyid[0]->type_bc }}/LOI/{{ date('Y') }}">
                                                <button onclick="saveRow(this)" type="submit"
                                                    class="btn btn-success">Enregistrer</button>
                                            </td>
                                        </tr>
                                    </form>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
                <br>
                <br>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
    aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color: black;">
                Êtes-vous sûr de vouloir supprimer ce client ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de confirmation -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
    aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color: black;">
                Êtes-vous sûr de vouloir enregistrer ces modifications ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmSave">Confirmer</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
    aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir valider les données ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="confirmAndSubmit()">Valider</button>
            </div>
        </div>
    </div>
</div>



<script>
    let clientId = 0;
    let inputToDelete = null;

    function getNextAvailableId() {
        // Trouver le plus grand ID existant parmi les éléments
        const existingIds = Array.from(document.querySelectorAll('.input-group-container'))
            .map(el => parseInt(el.id.replace('inputGroup', '')))
            .filter(id => !isNaN(id));
        const maxId = existingIds.length > 0 ? Math.max(...existingIds) : 0;
        return maxId + 1; // Le prochain ID disponible
    }

    function reindexClientIds() {
        // Sélectionner tous les éléments input-group-container
        const inputGroups = document.querySelectorAll('.input-group-container');
        inputGroups.forEach((group, index) => {
            // Mettre à jour les IDs et les labels
            const clientId = index + 1;
            const span = group.querySelector('.input-group-text');
            const input = group.querySelector('input.client-input');
            const hiddenInput = group.querySelector('input.client-hidden-input');
            const suggestionsList = group.querySelector('ul.suggestions-list');
            if (span) {
                span.textContent = `Modele${clientId} :`;
            }
            if (input) {
                input.id = `nomClient${clientId}`;
            }
            if (hiddenInput) {
                hiddenInput.id = `idClient${clientId}`;
                hiddenInput.name = `nomClient${clientId}`; // Mise à jour du name
            }
            if (suggestionsList) {
                suggestionsList.id = `suggestionsListClient${clientId}`;
            }

            // Réajuster le container avec le nouvel ID
            group.id = `inputGroup${clientId}`;
        });
        // Mettre à jour clientId pour le prochain ajout
        clientId = getNextAvailableId() - 1;
    }

    document.getElementById('add-client').addEventListener('click', function() {
        // Calculer le prochain ID disponible
        clientId = getNextAvailableId();

        // Créer un nouveau div similaire au div du client
        const newDiv = document.createElement('div');
        newDiv.className = 'col-5';
        newDiv.style.cssText = 'position: relative;margin-left: -15px;';
        newDiv.id = 'clientDiv' + clientId;

        const newInputGroup = `
            <div class="input-group-container" id="inputGroup${clientId}">
                <div class="input-group mb-1" style="width: 370px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="width: 151px;">Modele :</span>
                    </div>
                    <input type="text" class="form-control client-input" required>
                    <input type="hidden" class="form-control client-hidden-input" name="nomClient${clientId}">
                    <ul class="list-group mt-2 suggestions-list" style="display: none;"></ul>
                </div>
                <button type="button" class="btn btn-danger delete-btn" onclick="confirmDelete(${clientId})" style="position: absolute; right: -250px; top: 3;"><i class="fas fa-trash"></i></button>
            </div>
        `;

        newDiv.innerHTML = newInputGroup;

        // Ajouter le nouveau div juste après le dernier div du client
        document.getElementById('client-section').appendChild(newDiv);
        document.getElementById('totalClients').value = clientId + 1;
        // Ajouter l'écouteur d'événements pour l'autocomplétion
        attachAutocompleteListeners();
    });

    function confirmDelete(id) {
        inputToDelete = document.getElementById('clientDiv' + id);
        $('#confirmDeleteModal').modal('show');
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (inputToDelete) {
            inputToDelete.remove();
            reindexClientIds();
            $('#confirmDeleteModal').modal('hide');
        }
    });

    function attachAutocompleteListeners() {
        document.querySelectorAll('.client-input').forEach(input => {
            input.addEventListener('input', function() {
                var query = this.value;
                var suggestionsList = this.nextElementSibling.nextElementSibling;

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route('recherche-client-demande-bc') }}?nomClient=' +
                    encodeURIComponent(query), true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var clients = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';
                        if (clients.length > 0) {
                            clients.forEach(function(client) {
                                var li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = client.nom_modele;
                                li.addEventListener('click', function() {
                                    input.value = client.nom_modele;
                                    input.nextElementSibling.value = client.id;
                                    suggestionsList.style.display = 'none';
                                });
                                suggestionsList.appendChild(li);
                            });
                            suggestionsList.style.display = 'block';
                        } else {
                            suggestionsList.style.display = 'none';
                        }
                    }
                };
                xhr.send();
            });
        });

        document.addEventListener('click', function(event) {
            if (!event.target.classList.contains('client-input')) {
                document.querySelectorAll('.suggestions-list').forEach(list => {
                    if (!list.contains(event.target)) {
                        list.style.display = 'none';
                    }
                });
            }
        });
    }
    // Attacher les écouteurs d'événements d'autocomplétion lors du chargement initial
    attachAutocompleteListeners();
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomClient = document.getElementById('nomClient');
        var idClient = document.getElementById('idClient');
        var suggestionsList = document.getElementById('suggestionsListClient');

        nomClient.addEventListener('input', function() {
            var query = nomClient.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('recherche-client-demande-bc') }}?nomClient=' +
                encodeURIComponent(query), true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var clients = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (clients.length > 0) {
                        clients.forEach(function(client) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = client.nom_modele;
                            li.addEventListener('click', function() {
                                nomClient.value = client.nom_modele;
                                idClient.value = client.id;
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(li);
                        });
                        suggestionsList.style.display = 'block';
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                }
            };
            xhr.send();
        });

        document.addEventListener('click', function(event) {
            if (!nomClient.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

<script>
    // Vérifier l'état du localStorage au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('formConfirmed') === 'true') {
            document.querySelector('.test').style.display = 'none';
            document.querySelector('.tests').style.display = 'block';
        }
    });

    // Ouvrir le modal de confirmation lors du clic sur le bouton Save
    document.getElementById('saveButton').addEventListener('click', function() {
        $('#confirmationModal').modal('show');
    });

    // Gestion de la confirmation dans le modal
    document.getElementById('confirmSave').addEventListener('click', function() {
        // Masquer le div avec la classe 'test'
        document.querySelector('.test').style.display = 'none';

        // Afficher le div avec la classe 'tests'
        document.querySelector('.tests').style.display = 'block';

        // Sauvegarder l'état dans localStorage
        localStorage.setItem('formConfirmed', 'true');

        // Fermer le modal
        $('#confirmationModal').modal('hide');

        // Soumettre le formulaire si nécessaire
        document.getElementById('bcTissusForm').submit();
    });
</script>
<script>
    function deleteRow(button) {
        // Trouver le formulaire contenant le bouton
        const form = button.closest('form');

        // Trouver la ligne du tableau
        const row = button.closest('tr');
        const rowId = row.getAttribute('data-id');

        // Enregistrer l'identifiant de la ligne dans le localStorage
        let removedRows = JSON.parse(localStorage.getItem('removedRows')) || [];
        removedRows.push(rowId);
        localStorage.setItem('removedRows', JSON.stringify(removedRows));

        // Soumettre le formulaire
        form.submit();
    }

    document.addEventListener('DOMContentLoaded', () => {
        const removedRows = JSON.parse(localStorage.getItem('removedRows')) || [];
        removedRows.forEach(rowId => {
            const row = document.querySelector(`tr[data-id="${rowId}"]`);
            if (row) {
                row.style.display = 'none'; // Cacher les lignes marquées comme supprimées
            }
        });
    });
</script>


@include('CRM.footer')
