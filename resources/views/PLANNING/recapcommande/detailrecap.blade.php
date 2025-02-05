@include('CRM.header')
@include('CRM.sidebar')
<style>
    .button-group {
        margin-top: -10px;
        margin-right: 20px;
        display: flex;
        justify-content: flex-end;
        /* Aligne les éléments à droite */
        gap: 10px;
        /* Espace entre les boutons */
    }

    h2 {
        font-size: 22px;
        margin: 20px 0;
        text-align: center;
        color: #333;
    }

    .containerss {
        display: flex;
        flex-wrap: wrap;
        /* Permet aux éléments de passer à la ligne suivante si nécessaire */
        gap: 10px;
        /* Espace entre les sections */
        padding: 0 20px;
        justify-content: space-between;
        /* Aligne les éléments horizontalement */
    }

    .section1 {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 30px;
        width: calc(25% - 10px);
        /* Ajuste la largeur pour quatre sections par ligne */
        background-color: #fff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        /* Inclut le padding et la bordure dans la largeur totale */
    }

    /* Dégradés spécifiques pour chaque section */
    .section1:nth-of-type(1) {
        background: linear-gradient(135deg, #e3f2fd, #f1ffd1);
        /* Dégradé léger bleu */
    }

    .section1:nth-of-type(2) {
        background: linear-gradient(135deg, #e8f5e9, #b2f5ef);
        /* Dégradé léger vert */
    }

    .section1:nth-of-type(3) {
        background: linear-gradient(135deg, #e3f2fd, #f1ffd1);
        /* Dégradé léger bleu clair */
    }

    .section1:nth-of-type(4) {
        background: linear-gradient(135deg, #e8f5e9, #b2f5ef);
        /* Dégradé léger rose */
    }

    .section1 h3 {
        font-size: 16px;
        margin: 0 0 10px;
        color: #242424;
    }

    .header-section1 {
        display: flex;
        margin: 20px;
        gap: 10px;
    }

    .input-box {
        width: 80px;
        padding: 4px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-align: left;
        font-size: 12px;
    }

    .input-box.red {
        background-color: #f44336;
        color: #fff;
    }

    .input-box.green {
        background-color: #97da4a;
    }

    .input-box.blue {
        background-color: #5ee1f3;
    }

    .input-box.gray {
        background-color: #f5f5f5;
    }

    .field-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .field-row label {
        flex: 1;
        text-align: left;
        font-size: 12px;
    }

    .field-row input {
        flex: 1;
        text-align: right;
        font-size: 12px;
    }

    .button {
        padding: 8px 16px;
        margin: 10px;
        background-color: #e0e0e0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
    }

    .button:hover {
        background-color: #dcdcdc;
    }

    .button.primary {
        background-color: #90caf9;
        color: #fff;
    }

    .checkbox {
        margin-left: 10px;
    }

    label {
        color: #444444;
    }
</style>
<style>

    .header-container {
        display: flex;
        align-items: center;
        margin-bottom: 20px; /* Aligne le texte et l'input verticalement */
    }

    .header-container h2 {
        margin: 0; /* Supprime la marge par défaut du h2 */
        margin-left: 10px; /* Ajoute un espace entre le h2 et l'input */
    }

    .section-title {
        font-weight: bold;
        text-align: center;
        margin-bottom: 15px;
    }

    .details-section {
        width: 120%;
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        margin-left: -115px;
    }

    .details-box {
        margin: 10px;
        width: 50%;
        background-color: #f7f7f7;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
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
        color: rgb(163, 163, 163);
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
   <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                @include('PLANNING.headerPlan')
                <div class="row">
                    <div class="card" style="border-radius: 10px;width: 105%;">
                        <h2>DETAILS RECAP COMMANDE</h2>
                        <div class="row mt-3" style="display: flex; align-items: center;margin-left:100px;">
                            <div class="col-md-2 mt-1">
                                <center>
                                    <img src="data:image/png;base64,{{ $cin[0]->photo_commande }}"
                                        class="img-fluid rounded-start mb-5" style="margin-left: -50px;" alt="Logo"
                                        width="120px" height="120px">
                                </center>
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <p class="texte"><b>Date entrée :</b>
                                    {{ \Carbon\Carbon::parse($cin[0]->date_entree)->format('d/m/y') }}</p>
                                    <p class="texte"><b>Client :</b> {{ $cin[0]->nomtier }}</p>
                                    <p class="texte"><b>Modèle :</b>{{ $cin[0]->nom_modele }}</p>
                                    <p class="texte"><b>Style :</b>{{ $cin[0]->nom_style }}</p>
                                    <p class="texte"><b>Thème :</b>{{ $cin[0]->theme }}</p>
                                    <p class="texte"><b>Quantité prévisionnel:</b>{{ $cin[0]->qte_commande_provisoire }}</p>
                                    <p class="texte"><b>SMV Prod:</b>{{ $cin[0]->smv_prod }}</p>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <p class="texte">
                                        <b>ETD:</b>{{ \Carbon\Carbon::parse($cin[0]->date_livraison)->format('d/m/y') }}
                                    </p>
                                    <p class="texte"><b>Stade :</b> {{ $cin[0]->type_stade }}</p>
                                    <p class="texte"><b>Grille de taille:</b>{{ $cin[0]->taillemin }}--{{ $cin[0]->taillemax }}</p>
                                    <p class="texte"><b>Taille de base :</b>{{ $cin[0]->taille_base }}</p>
                                    <p class="texte"><b>Incontern :</b> {{ $cin[0]->type_incontern }}</p>
                                    <p class="texte"><b>Phase :</b> {{ $cin[0]->type_phase }}</p>
                                    <p class="texte"><b>SMV Finition:</b>{{ $cin[0]->smv_finition }}</p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <ul class="nav nav-tabs" style="border-top: solid 3px lightgray;border-bottom: solid 3px lightgray">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" onclick="showSection('produit')">Commande</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="showSection('reviser')">Disponibilite</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="showSection('merch')">Valeur Ajoutée</a>
                            </li>
                        </ul>

                        <div id="produit" class="content-section active">
                            <div class="header-container">
                                <h2>Commande</h2>
                            </div>

                            <form action="{{ route('PLANNING.modifierRecapCommande') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="bcclientexistant" value="{{ $recap->bcclient }}">
                                <div class="input-group mb-1" style="width: 370px;margin-left:15px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="width: 151px;margin-bottom: 18px;">Date de Reception :</span>
                                    </div>
                                        <input type="date" class="form-control custom-input" style="margin-bottom: 18px;" name="datereception" value="{{ $recap->receptionbc }}">
                                </div>
                                <table class="table table" style="width: 27%;margin-left:15px;background-color:lightgrey;color:black;border-radius:10px;border:none">
                                    <thead>
                                        <tr>
                                            <th>ETD Revisé</th>
                                            <th>ETD Proposé</th>
                                            @if(!empty($recap->bcclient))
                                            <th>Bc Client : <a href="#"
                                                onclick="openPdfInNewTab('{{ $recap->bcclient }}', event)" style="color: blue">
                                            Bc Actuel
                                            </a>
                                            </th>
                                            @else
                                            <th>Bc Client : Aucune Bc Client</th>
                                            @endif
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @if(!empty($recap->etdpropose))
                                                <td><input type="date" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" name="etdpropose" value="{{ $recap->etdpropose }}"></td>
                                                @else
                                                <td><input type="date" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" name="etdrevise" value="{{ $recap->etdrevise }}"></td>
                                            @endif
                                            <td><input type="date" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" name="etdpropose" value="{{ $recap->etdpropose }}"></td>
                                            <td>
                                                <div class="custom-file" style=" border: 1px solid #b5b5b5;width: 200px;justify-content:flex-start;">
                                                    <input type="file" class="custom-file-input" id="champ5_1" style="width: 100px;" name="bcclient">
                                                    <label class="custom-file-label" style="text-align: left;">Bc Client</label>
                                                </div>
                                            </td>
                                            <input type="hidden" name="iddemande" value="{{ $recap->iddemandeclient }}">
                                            <input type="hidden" name="id" value="{{ $recap->id }}">
                                            <td><button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>



                            <form action="{{ route('PLANNING.modifierDestinationRecapCommande') }}" method="post">
                                @csrf
                                <table id="inputFieldsContainer" class="table table" style="width: 40%;margin-left:15px;margin-top:-20px;background-color:lightgrey;color:black;border-radius:10px;border:none">
                                    <thead>
                                        <tr>
                                            <th>Num Cmd</th>
                                            <th>ETD Initial</th>
                                            <th>Quantite</th>
                                            <th>Destination</th>
                                            <th>Livraison Exacte</th>
                                            <th>Inspection</th>
                                            <th style="border: none;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($destrecap as $index => $ds) <!-- Ajoutez l'index pour le suivi -->
                                            <tr>
                                                <td><input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" name="champ1[]" value="{{ $ds->numerocommande }}"></td>
                                                <td><input type="date" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" name="champ2[]" value="{{ $ds->etdinitial }}"></td>
                                                <td><input type="number" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" name="champ3[]" value="{{ $ds->qteof }}"></td>
                                                <td>
                                                    <div class="d-flex flex-column mr-2">
                                                        <select class="form-control" name="champ4[]" id="champ4_{{ $index }}" style="height: 32px;width:180px;">
                                                            <option value="{{ $ds->deststd_id }}">{{ $ds->deststd_designation }}</option>
                                                            <option value="">Déstination...</option>
                                                            @foreach($destination as $d)
                                                                <option value="{{ $d->id }}">{{ $d->designation }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>
                                                <td><input type="date" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" name="champ5[]" value="{{ $ds->datelivraisonexacte }}"></td>
                                                <td><input type="date" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" name="champ6[]" value="{{ $ds->dateinspection }}"></td>
                                                <td>
                                                    @if ($index === 0) <!-- Condition pour le premier élément -->
                                                        <button id="addFieldBtn" class="btn btn-primary"><i class="fas fa-plus"></i></button>
                                                    @else
                                                        <button type="button"  onclick="affichemodal('{{ $recap->iddemandeclient }}', '{{ $recap->id }}', '{{ $ds->destination_id }}')" class="btn btn-danger ml-2 ">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="6"></td> <!-- Cela laisse les 5 premières colonnes vides -->
                                            <td>
                                                <input type="hidden" name="iddemande" value="{{ $recap->iddemandeclient }}">
                                                <input type="hidden" name="id" value="{{ $recap->id }}">
                                                <button type="submit" class="btn btn-success">valider</button> <!-- Bouton dans la dernière colonne -->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>

                            <!-- Modal -->
                            <div class="modal fade" id="confirmDeleteModal" tabindex="-1"  aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="deleteForm" method="POST" action="{{ route('PLANNING.deleteLigneDest') }}">
                                            @csrf
                                            <div class="modal-body">
                                                Êtes-vous sûr de vouloir supprimer cet élément ?
                                                <input type="hidden" name="iddemande" id="modaliddemande">
                                                <input type="hidden" name="id" id="modalidrecap">
                                                <input type="hidden" name="idDes" id="modalid">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div id="reviser" class="content-section">
                            <div class="header-container">
                            <h2>Disponibilite</h2>
                            </div>
                            <table class="table table" style="width: 40%;margin-left:15px;background-color:lightgrey;color:black;border-radius:10px;border:none">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tissus</th>
                                        <th>Accessoire</th>
                                        <th>OK Prod</th>

                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <th style="text-align: left;">Besoin: </th>
                                            <td><input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="{{ !empty($mat) ? \Carbon\Carbon::parse($mat)->format('d/m/y') : '' }}"></td>
                                            <td><input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="{{ !empty($mat) ? \Carbon\Carbon::parse($mat)->format('d/m/y') : '' }}"></td>
                                            <td><input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="{{ !empty($prod) ? \Carbon\Carbon::parse($prod)->format('d/m/y') : '' }}"></td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: left;">Prévision: </th>
                                            <td><input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="{{ !empty($cin[0]->combined_final_deadline) ? \Carbon\Carbon::parse($cin[0]->combined_final_deadline)->format('d/m/y') : '' }}"></td>
                                            <td><input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="{{ !empty($cin[0]->combined_final_deadline_accy) ? \Carbon\Carbon::parse( $cin[0]->combined_final_deadline_accy)->format('d/m/y') : '' }}"></td>
                                            <td><input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="{{ !empty($cin[0]->micro_datecalcul) ? \Carbon\Carbon::parse( $cin[0]->micro_datecalcul)->format('d/m/y') : '' }}"></td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: left;">Réel: </th>
                                            <td><input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="{{ !empty($cin[0]->max_datearrivereelle) ? \Carbon\Carbon::parse($cin[0]->max_datearrivereelle)->format('d/m/y') : '' }}"></td>
                                            <td><input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="{{ !empty($cin[0]->accy_max_datearrivereelle) ? \Carbon\Carbon::parse( $cin[0]->accy_max_datearrivereelle)->format('d/m/y') : '' }}"></td>
                                            <td><input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="{{ !empty($cin[0]->micro_realisation) ? \Carbon\Carbon::parse($cin[0]->micro_realisation)->format('d/m/y') : '' }}"></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="merch" class="content-section">
                            <div class="header-container">
                            <h2>Valeur ajoutée</h2>
                            </div>

                            <table class="table table" style="width: 40%;margin-left:15px;background-color:lightgrey;color:black;border-radius:10px;border:none">
                                <thead>
                                    <tr>
                                        @foreach($lavage as $la)
                                            <th>{{ $la->type_lavage }}</th>
                                        @endforeach
                                        @foreach($va as $v)
                                            <th>{{ $v->type_valeur_ajoutee }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            @foreach($lavage as $index => $l)
                                                <td>
                                                    <input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="lavage">
                                                </td>
                                            @endforeach
                                            @foreach($va as $v)
                                            <td>
                                                @if(count($smv)>0)
                                                    @if($v->type_valeur_ajoutee=="Broderie main")
                                                        <input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="{{ $smv[0]->smv_brod_main }}">
                                                    @endif
                                                    @if($v->type_valeur_ajoutee=="Broderie machine")
                                                        <input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="{{ $smv[0]->nombre_points }}">
                                                    @endif
                                                    @if($v->type_valeur_ajoutee=="Serigraphie")
                                                        <input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="{{ $smv[0]->prix_print }}">
                                                    @endif
                                                    @if($v->type_valeur_ajoutee=="Smock")
                                                    <input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="smock">
                                                    @endif
                                                        @else
                                                        @if($v->type_valeur_ajoutee=="Broderie main")
                                                           <input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="0">
                                                        @endif
                                                        @if($v->type_valeur_ajoutee=="Broderie machine")
                                                           <input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="0">
                                                        @endif
                                                        @if($v->type_valeur_ajoutee=="Serigraphie")
                                                           <input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="0">
                                                        @endif
                                                        @if($v->type_valeur_ajoutee=="Smock")
                                                          <input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" readonly value="0">
                                                        @endif
                                                @endif
                                            </td>
                                        @endforeach

                                        </tr>
                                </tbody>
                            </table>

                        </div>
                        <br>
                <br>
            </div>
        </div>

    </div>
</div>

<script>
    function showSection(sectionId) {
        // Cacher toutes les sections
        document.querySelectorAll('.content-section').forEach(function(section) {
            section.classList.remove('active');
        });

        // Afficher la section sélectionnée
        document.getElementById(sectionId).classList.add('active');
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var inputGroupCount = document.querySelectorAll('#inputFieldsContainer .input-group').length + 1;
        var fileInput = document.getElementById('champ5_1');
        var fileLabel = fileInput.nextElementSibling;

        fileInput.addEventListener('change', function() {
            var fileName = this.files[0] ? this.files[0].name : 'Choose file';
            fileLabel.textContent = fileName;
        });
    });
</script>


<script>
    document.getElementById('addFieldBtn').addEventListener('click', function(e) {
        // Empêcher le comportement par défaut
        e.preventDefault();

        // Créer une nouvelle ligne de tableau
        var newRow = document.createElement('tr');

        // Ajouter les cellules avec les champs correspondants
        newRow.innerHTML = `
            <td><input type="text" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" name="champ1[]"></td>
            <td><input type="date" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" name="champ2[]"></td>
            <td><input type="number" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" name="champ3[]"></td>
            <td>
                  <div class="d-flex flex-column mr-2">
                     <select class="form-control" name="champ4[]" id="champ4_1" style="height: 32px;width:180px;">
                        <option value="">Déstination...</option>
                            @foreach($destination as $d)
                                <option value="{{ $d->id }}">{{ $d->designation }}</option>
                            @endforeach
                    </select>
                </div>
            </td>
            <td><input type="date" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" name="champ5[]"></td>
            <td><input type="date" style="border: none;height: 30px;width: 150px;border-radius:5px;text-align:center;" name="champ6[]"></td>
            <td><button type="button" class="btn btn-danger ml-2 removeFieldBtn"><i class="fas fa-trash-alt"></i></button></td>
        `;

        // Ajouter la nouvelle ligne avant la ligne de validation
        var inputRows = document.querySelectorAll('#inputFieldsContainer tr');
        var validationRow = inputRows[inputRows.length - 1]; // Dernière ligne (ligne de validation)

        // Insérer la nouvelle ligne juste avant la ligne de validation
        validationRow.parentNode.insertBefore(newRow, validationRow);

        // Gérer la suppression de la ligne ajoutée
        var removeButton = newRow.querySelector('.removeFieldBtn');
        removeButton.addEventListener('click', function() {
            newRow.remove(); // Supprimer la ligne
        });
    });
    </script>

<!-- JavaScript -->
<script>
    function affichemodal(iddemande, idrecap, id) {
        // Injecter les données récupérées dans le modal
        $('#modaliddemande').val(iddemande);
        $('#modalidrecap').val(idrecap);
        $('#modalid').val(id);

        // Afficher le modal
        $('#confirmDeleteModal').modal('show');
    };

    $('#deleteForm').on('submit', function(event) {
        // Prevent the default form submission
        event.preventDefault();

        // Optionally, perform any additional confirmation logic here

        // Close the modal after the user confirms the deletion
        $('#confirmDeleteModal').modal('hide');

        // Submit the form after closing the modal
        this.submit(); // This will submit the form programmatically
    });
</script>

@include('CRM.footer')
