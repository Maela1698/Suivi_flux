@include('CRM.header')
@include('CRM.sidebar')
<style>
    .section-title {
        font-weight: bold;
        text-align: center;
        margin-bottom: 15px;
        color: #0C275E;
    }

    .details-section {
        display: flex;
        flex-wrap: wrap;
        /* Permet aux éléments de se répartir sur plusieurs lignes */
        margin-bottom: 20px;
        justify-content: space-between;
        margin-left: 0;
        margin-right: 0;
        width: 100%;
    }

    .details-box {
        margin: 10px;
        width: 18%;
        /* Ajuste la largeur des boxes à 18% pour avoir 5 éléments par ligne */
        background-color: #f7f7f7;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
        box-sizing: border-box;
        /* Inclut le padding dans la largeur de l'élément */
    }

    .details-box label {
        font-weight: bold;
    }

    .details-box p {
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }

    .nav-tabs {
        margin-bottom: 20px;
    }

    .table th,
    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table {
        margin-bottom: 40px;
    }

    .content-section {
        display: none;
        /* Cacher toutes les sections par défaut */
    }

    .content-section.active {
        display: block;
        /* Afficher uniquement la section active */
    }

    p {
        color: rgb(93, 93, 93);
    }

    b {
        color: rgb(169, 169, 169);
    }

    .inline-flex-container {
        display: inline-flex;
        align-items: center;
    }

    .td-input {
        border: none;
        background-color: transparent;
        min-width: 50px;
        /* Taille minimale définie à 50px */
        margin: 0 2px;
        text-align: left;
        padding: 0;
        font-size: 14px;
        white-space: nowrap;
    }

    /* Supprimer les bordures lorsque l'input est en focus */
    .td-input:focus {
        outline: none;
    }
</style>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    .content-body {
        padding: 20px;
    }

    .card {
        border-radius: 10px;
        margin-left: auto;
        margin-right: auto;
        width: 90%;
        background-color: #ffffff;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .form-container {
        padding: 20px;
    }

    .form-header h2 {
        text-align: center;
        color: #333333;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    label {
        font-weight: bold;
        margin-bottom: 8px;
        font-size: 14px;
        color: #555555;
    }

    input[type="text"],
    input[type="date"],
    select,
    textarea {
        border: 1px solid #cccccc;
        border-radius: 5px;
        padding: 10px;
        font-size: 14px;
        color: #555555;
        width: 100%;
        box-sizing: border-box;
    }

    textarea {
        resize: none;
    }

    input:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .form-footer {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        color: white;
        cursor: pointer;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    @media screen and (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="content-body">
    @include('WMS.headerWMS')
    <br>
    <br>
    <div class="card mb-2" style="margin-top: -50px;width:100%">
        <div style="display: flex;justify-content:space-between">
            <div style="margin-left: 10px;">

                <h4 class="section-title"><u>QUALITE TISSU</u></h4>
            </div>
        </div>
        <br>
        <div class="row" style="color: black">
            <div class="col-6">
                <b>Date entrée:</b> {{ $entree[0]->dateentree }}
                <br>
                <b>Date facturation:</b> {{ $entree[0]->datefacturation }}
                <br>
                <b>Numero BC:</b> {{ $entree[0]->numerobc }}
                <br>
                <b>Numero BL:</b> {{ $entree[0]->numerobl }}
                <br>
                <b>Numero Facture:</b> {{ $entree[0]->numerofacture }}
                <br>
                <b>Fournisseur:</b> {{ $entree[0]->fournisseur }}
                <br>
                <b>Client:</b> {{ $entree[0]->client }}
                <br>
                <b>Modele:</b> {{ $entree[0]->modele }}
                <br>
                <b>Saison:</b> {{ $entree[0]->saison }}
                <br>
                <b>Designation tissu:</b> {{ $entree[0]->des_tissu }}
                <br>
                <b>Reference tissu:</b> {{ $entree[0]->reftissu }}
                <br>
                <b>Composition:</b> {{ $entree[0]->composition }}
                <br>
                <b>Categorie:</b> {{ $entree[0]->categorie }}
                <br>
                <b>Classe:</b> {{ $entree[0]->classe }}
                <br>
                <b>Utilisation:</b> {{ $entree[0]->utilisation }}
                <br>
                <b>Famille tissu:</b> {{ $entree[0]->famille_tissus }}

            </div>
            <div class="col-6">
                <b>Couleur:</b> {{ $entree[0]->couleur }}
                <br>
                <b>Unite mesure:</b> {{ $entree[0]->unite_mesure }}
                <br>
                <b>Laize:</b> {{ $entree[0]->laize }}
                <br>
                <b>Grammage:</b> {{ $entree[0]->grammage }}
                <br>
                <b>Valeur:</b> {{ $entree[0]->valeur }}
                <br>
                <b>Qte commande:</b> {{ $entree[0]->qtecommande }}
                <br>
                <b>Qte recu:</b> {{ $entree[0]->qterecu }}
                <br>
                <b>Reste a recevoir:</b> {{ $entree[0]->resterecevoir }}
                <br>
                <b>Taux ecart:</b> {{ $entree[0]->tauxecart }}
                <br>
                <b>Nb rouleau:</b> {{ $entree[0]->nbrouleau }}
                <br>
                <b>Nb lot:</b> {{ $entree[0]->nblot }}
                <br>
                <b>Prix unitaire:</b> {{ $entree[0]->prixunitaire }}
                <br>
                <b>Fret:</b> {{ $entree[0]->fret }}
                <br>
                <b>Unite monetaire:</b> {{ $entree[0]->unite_monetaire }}
                <br>
                <b>Prix en euro:</b> {{ $entree[0]->prixeuro }}
                <br>
                <b>Commentaire:</b> {{ $entree[0]->commentaire }}
                <br>
                <b>Colonne:</b> {{ $entree[0]->colonne }}

            </div>
        </div>

    </div>


    <div class="card" style="width: 100%;">
        <form action="{{ route('QUALITETISSU.ajoutInspectionQualite') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="idEntreeTissu" value="{{ $idEntreeTissu }}">
            <button type="submit" class="btn btn-secondary" style="width: 150px; height: 50px;">Enregistrer</button>
            <div class="card-body">

                <div class="custom-tab-1">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#fabric">Fabric inspection</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#conformite">Test conformite</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#elongation">Test elongation</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#shadetest">Shade test</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#disgorging">Disgorging</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="fabric" role="tabpanel">
                            <div class="pt-4">
                                <h4>This is home title</h4>
                                <p>Far far away, behind the word mountains, far from the countries Vokalia and
                                    Consonantia,
                                    there live the blind texts. Separated they live in Bookmarksgrove.
                                </p>
                                <p>Far far away, behind the word mountains, far from the countries Vokalia and
                                    Consonantia,
                                    there live the blind texts. Separated they live in Bookmarksgrove.
                                </p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="conformite">
                            <div class="pt-4">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Date conformite</label>
                                            <input type="date" class="form-control" name="dateconformite"
                                                value="{{ $conformite[0]->date_conformite ?? now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Image LAP</label>
                                            <input type="file" class="form-control" name="imagelaps" accept="image/*"
                                                capture="camera" value="{{ $conformite[0]->photo_conformite }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <select class="form-control" name="passedConformite">
                                                @if (!empty($conformite[0]->passed))
                                                    <option value="{{ $conformite[0]->passed }}">
                                                        {{ $conformite[0]->passed }}</option>
                                                    <option value="">Passed</option>
                                                @else
                                                    <option value="">Passed</option>
                                                @endif
                                                <option value="Oui">Oui</option>
                                                <option value="Non">Non</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="elongation">
                            <div class="pt-4">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Date elongation</label>
                                            <input type="date" class="form-control" name="dateElongation"
                                                value="{{ $elongation[0]->date_elongation ?? now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Date preparation</label>
                                            <input type="date" class="form-control" name="datePreparation"
                                                value="{{ $elongation[0]->date_preparation }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Date evaluation</label>
                                            <input type="date" class="form-control" name="dateEvaluation"
                                                value="{{ $elongation[0]->date_evaluation }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <select class="form-control" name="inspecteur">

                                                @if (!empty($elongation[0]->id_employe))
                                                    <option value="{{ $elongation[0]->id_employe }}">
                                                        {{ $elongation[0]->nom }} {{ $elongation[0]->prenom }}
                                                    </option>
                                                    <option value="">Inspecteur</option>
                                                @else
                                                    <option value="">Inspecteur</option>
                                                @endif
                                                @for ($i = 0; $i < count($employe); $i++)
                                                    <option value="{{ $employe[$i]->id }}">
                                                        {{ $employe[$i]->nom }}
                                                        {{ $employe[$i]->prenom }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <select class="form-control" name="lavage">
                                                @if (!empty($elongation[0]->id_type_lavage))
                                                    <option value="{{ $elongation[0]->id_type_lavage }}">
                                                        {{ $elongation[0]->type_lavage }}</option>
                                                    <option value="">Type lavage</option>
                                                @else
                                                    <option value="">Type lavage</option>
                                                @endif
                                                @for ($l = 0; $l < count($lavage); $l++)
                                                    <option value="{{ $lavage[$l]->id }}">
                                                        {{ $lavage[$l]->type_lavage }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <select class="form-control" name="tempsRelaxation">
                                                @if (!empty($elongation[0]->temps_relaxation))
                                                    <option value="{{ $elongation[0]->temps_relaxation }}">
                                                        {{ $elongation[0]->temps_relaxation }}</option>
                                                    <option value="">Temps relaxation</option>
                                                @else
                                                    <option value="">Temps relaxation</option>
                                                @endif
                                                <option value="24h">24h</option>
                                                <option value="48h">48h</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <select class="form-control" name="passedElongation">
                                                @if (!empty($elongation[0]->passed))
                                                    <option value="{{ $elongation[0]->passed }}">
                                                        {{ $elongation[0]->passed }}</option>
                                                    <option value="">Passed</option>
                                                @else
                                                    <option value="">Passed</option>
                                                @endif
                                                <option value="Oui">Oui</option>
                                                <option value="Non">Non</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Observation</label>
                                            <input type="text" class="form-control" name="observationElongation"
                                                value="{{ $elongation[0]->observation }}">
                                        </div>
                                    </div>
                                </div>

                                <table class="table my-0" style="color: black" id="dataTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>REFERENCE</th>
                                            <th>QTE</th>
                                            <th>LOT</th>
                                            <th>Elongation % Longueur</th>
                                            <th>Elongation % Laize</th>
                                            <th>Retrait % Longueur</th>
                                            <th>Retrait % Laize</th>
                                            <th>Retrait Ecart ANG</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($q = 0; $q < count($elongationRouleau); $q++)
                                            <tr>
                                                <td>{{ $elongationRouleau[$q]->reference }}</td>
                                                <td>{{ $elongationRouleau[$q]->metrage }}</td>
                                                <td>{{ $elongationRouleau[$q]->lot }}</td>
                                                <input type="hidden" name="idqualiterouleautissuElongation[]"
                                                    value="{{ $elongationRouleau[$q]->id }}">
                                                <td><input type="text" name="elongationLongueur[]"
                                                        class="form-control"
                                                        value="{{ $elongationRouleau[$q]->elongation_long ?? 0 }}">
                                                </td>
                                                <td><input type="text"name="elongationLaize[]" class="form-control"
                                                        value="{{ $elongationRouleau[$q]->elongation_laize ?? 0 }}">
                                                </td>
                                                <td><input type="text"name="longueurretrait[]" class="form-control"
                                                        value="{{ $elongationRouleau[$q]->retrait_long ?? 0 }}">
                                                </td>
                                                <td><input type="text"name="laizeretrait[]" class="form-control"
                                                        value="{{ $elongationRouleau[$q]->retrait_laize ?? 0 }}">
                                                </td>
                                                <td><input type="text"name="ecartAngulaire[]" class="form-control"
                                                        value="{{ $elongationRouleau[$q]->retrait_angulaire ?? 0 }}">
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="shadetest">
                            <div class="pt-4">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Date shade test</label>
                                            <input type="date" class="form-control" name="dateShadeTest"
                                                value="{{ $shade[0]->date_shade ?? now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Date execution</label>
                                            <input type="date" class="form-control" name="dateExecution"
                                                value="{{ $shade[0]->date_execution }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <select class="form-control" name="endroit">
                                                @if (!empty($shade[0]->endroit))
                                                    <option value="{{ $shade[0]->endroit }}">
                                                        {{ $shade[0]->endroit }}
                                                    </option>
                                                    <option value="">Endroit</option>
                                                @else
                                                    <option value="">Endroit</option>
                                                @endif

                                                <option value="Interieur">Interieur</option>
                                                <option value="Exterieur">Exterieur</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <select class="form-control" name="passedShade">
                                                @if (!empty($shade[0]->passed))
                                                    <option value="{{ $shade[0]->passed }}">
                                                        {{ $shade[0]->passed }}
                                                    </option>
                                                    <option value="">Passed</option>
                                                @else
                                                    <option value="">Passed</option>
                                                @endif
                                                <option value="Oui">Oui</option>
                                                <option value="Non">Non</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <select class="form-control" name="nuanceShade">
                                                @if (!empty($shade[0]->nuance))
                                                    <option value="{{ $shade[0]->nuance }}">
                                                        {{ $shade[0]->nuance }}
                                                    </option>
                                                    <option value="">Nuance</option>
                                                @else
                                                    <option value="">Nuance</option>
                                                @endif
                                                <option value="Avec">Avec</option>
                                                <option value="Sans">Sans</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Observation</label>
                                            <input type="text" class="form-control" name="observationShade"
                                                value="{{ $shade[0]->observation }}">
                                        </div>
                                    </div>
                                </div>

                                <table class="table my-0" id="dataTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Image</th>
                                            <th>ROULEAU N</th>
                                            <th>LOT</th>
                                            <th>LAIZE</th>
                                            <th>METRAGE REEL</th>
                                            <th>REFERENCE</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($t = 0; $t < count($shadeRouleau); $t++)
                                            <tr style="color: black">
                                                <td> <input type="file" class="form-control" name="imageShade[]"
                                                        accept="image/*" capture="camera"
                                                        value="{{ $shadeRouleau[$t]->photo_shade }}">
                                                </td>
                                                </td>
                                                <td> <input type="hidden" name="idqualiterouleautissuShade[]"
                                                        value="{{ $shadeRouleau[$t]->id }}">{{ $shadeRouleau[$t]->reference }}
                                                </td>
                                                <td>{{ $shadeRouleau[$t]->lot }}</td>
                                                <td>{{ $shadeRouleau[$t]->laize }}</td>
                                                <td>{{ $shadeRouleau[$t]->metrage }}</td>
                                                <td>{{ $shadeRouleau[$t]->reference }}</td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="disgorging">
                            <div class="pt-4">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Date disgorging</label>
                                            <input type="date" class="form-control" name="dateDisgoring"
                                                value="{{ $disgorging[0]->date_disgorging ?? now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Date preparation</label>
                                            <input type="date" class="form-control"
                                                name="datePreparationDisgoring"
                                                value="{{ $disgorging[0]->date_preparation }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Date evaluation</label>
                                            <input type="date" class="form-control" name="dateEvaluationDisgoring"
                                                value="{{ $disgorging[0]->date_evaluation }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <select class="form-control" name="passedDisgoring">
                                                @if (!empty($disgorging[0]->passed))
                                                    <option value="{{ $disgorging[0]->passed }}">
                                                        {{ $disgorging[0]->passed }}</option>
                                                    <option value="">Passed</option>
                                                @else
                                                    <option value="">Passed</option>
                                                @endif
                                                <option value="Oui">Oui</option>
                                                <option value="Non">Non</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <table class="table my-0" style="color: black" id="dataTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>LOT</th>
                                            <th>PHOTO</th>
                                            <th>TYPE DE FROTTEMENT</th>
                                            <th>ECHELLE DE GRIS</th>
                                            <th>DUREE</th>
                                            <th>VALIDATION TEST</th>
                                            <th>REMARQUES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($l = 0; $l < count($disgorgingLot); $l++)
                                            <tr>
                                                <td><input type="hidden" name="lot[]"
                                                        value="{{ $disgorgingLot[$l]->lot }}">{{ $disgorgingLot[$l]->lot }}
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control"
                                                        name="imageDisgorging[]" accept="image/*" capture="camera"
                                                        value="{{ $disgorgingLot[$l]->image_disgorging }}"
                                                        value="">
                                                </td>
                                                <td>
                                                    <select class="form-control" name="typefrottement[]">
                                                        <option value="{{ $disgorgingLot[$l]->type_frottement }}">
                                                            {{ $disgorgingLot[$l]->type_frottement }}</option>
                                                        <option value="">Selectionner</option>
                                                        <option value="FROTTEMENT A SEC">
                                                            FROTTEMENT A SEC</option>
                                                        <option value="FROTTEMENT MOUILLE">
                                                            FROTTEMENT MOUILLE</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" class="form-control" name="echellegris[]"
                                                        value="{{ $disgorgingLot[$l]->echelle_gris }}">
                                                </td>
                                                <td><input type="text" class="form-control" name="duree[]"
                                                        value="{{ $disgorgingLot[$l]->duree }}"></td>
                                                <td>
                                                    <select class="form-control" name="validationtest[]">
                                                        <option value="{{ $disgorgingLot[$l]->validation_test }}">
                                                            {{ $disgorgingLot[$l]->validation_test }}</option>
                                                        <option value="">Selectionner</option>
                                                        <option value=" Avec disgorging">
                                                            Avec disgorging</option>
                                                        <option value=" Sans disgorging">
                                                            Sans disgorging</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" class="form-control" name="remarque[]"
                                                        value="{{ $disgorgingLot[$l]->remarque }}">
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </form>
    </div>
</div>

@include('CRM.footer')
