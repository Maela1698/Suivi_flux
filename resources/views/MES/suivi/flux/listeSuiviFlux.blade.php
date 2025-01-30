@include('CRM.header')
@include('CRM.sidebar')
@include('STYLE.MES.suiviFlux.styleListeSuiviFlux')

<style>
    .table th {
        color: #000000;
        /* Couleur noire intense */
        font-weight: bold;
        /* Optionnel : Rend le texte plus épais */
    }

    .table td {
        color: #828282;
        /* Couleur noire intense */
        font-weight: bold;
        /* Optionnel : Rend le texte plus épais */
    }

    #suggestionsListTiers {
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

    #suggestionsListStyle {
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
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('MES.headerMES')
        <div class="row">
            <div class="col-3">
                <div class="card" style="height: 150px">
                    <div class="card-header d-block center">
                        <center>
                            <h4 class="card-title">QUANTITE PO </h4>
                        </center>
                    </div>
                    <div class="card-body">
                        <center>
                            <p style="font-size: 17px; color: #000000;">{{ $qte_po }}</p>
                            <span style="color: white">Rejet: {{ number_format($pourcentageRejetCoupe, 0) }}%</span>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card" style="height: 150px">
                    <div class="card-header d-block center">
                        <center>
                            <h4 class="card-title">QUANTITE COUPE </h4>
                        </center>
                    </div>
                    <div class="card-body">
                        <center>
                            <p style="font-size: 17px; color: #000000;">{{ $qte_coupe }}</p>

                            <span style="color: #000000">Rejet: {{ number_format($pourcentageRejetCoupe, 0) }}%</span>
                        </center>
                        <h6>
                            <span class="pull-right">{{ number_format($pourcentageCoupe, 0) }}%</span>
                        </h6>
                        <div class="progress ">
                            <div class="progress-bar  progress-animated"
                                style="width: {{ number_format($pourcentageCoupe, 0) }}%; height:6px;"
                                role="progressbar">

                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-2">
                <div class="card" style="height: 150px; cursor: pointer;"
                    onclick="ouvrirModal('{{ $entree_repassage }}', '{{ $sortie_repassage }}', '{{ $balancerepassage }}')">

                    <div class="card-header d-block center">
                        <center>
                            <h4 class="card-title">REPASSAGE</h4>
                        </center>
                    </div>
                    <div class="card-body">
                        <center>
                            <p style="font-size: 17px; color: #000000;">{{ $sortie_repassage }}</p>
                            <span style="color: white">Rejet: </span>
                        </center>
                        <h6>
                            <span class="pull-right">{{ number_format($pourcentageRepassage, 0) }}%</span>
                        </h6>
                        <div class="progress">
                            <div class="progress-bar progress-animated"
                                style="width: {{ number_format($pourcentageRepassage, 0) }}%; height:6px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-2">
                <div class="card" style="height: 150px" onclick="ouvrirModalBalance('{{ $balancealivrer }}')">
                    <div class="card-header d-block center">
                        <center>
                            <h4 class="card-title">BOXING </h4>
                        </center>
                    </div>
                    <div class="card-body">
                        <center>
                            <p style="font-size: 17px; color: #000000;">{{ $qte_pret_livrer }}</p>

                            <span style="color: #000000">Rejet: {{ number_format($pourcentageRejetChaine, 0) }}%</span>
                        </center>
                        <h6>
                            <span class="pull-right">{{ number_format($pourcentageBoxing, 0) }}%</span>
                        </h6>
                        <div class="progress ">
                            <div class="progress-bar  progress-animated"
                                style="width: {{ number_format($pourcentageBoxing, 0) }}%; height:6px;"
                                role="progressbar">

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-2">
                <div class="card" style="height: 150px" onclick="ouvrirModalBalance('{{ $balancealivrer }}')">
                    <div class="card-header d-block center">
                        <center>
                            <h4 class="card-title">EXPEDIEE </h4>
                        </center>
                    </div>
                    <div class="card-body">
                        <center>
                            <p style="font-size: 17px; color: #000000;">{{ $qte_deja_livrer }}</p>

                            <span style="color: white">Rejet: {{ number_format($pourcentageRejetChaine, 0) }}%</span>
                        </center>
                        <h6>
                            <span class="pull-right">{{ number_format($pourcentageExpediee, 0) }}%</span>
                        </h6>
                        <div class="progress ">
                            <div class="progress-bar  progress-animated"
                                style="width: {{ number_format($pourcentageExpediee, 0) }}%; height:6px;"
                                role="progressbar">

                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-left">
                <h3 class="title"><strong>DELIVERY DATE</strong></h3>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>STYLE</th>
                                <th>OF</th>
                                <th>SIZE</th>
                                <th>COLOR</th>
                                <th>CONFIRMÉ</th>
                                <th>LIVRAISON</th>
                                <th>STADE</th>
                                <th>JOUR RESTANT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($suivi); $i++)
                                <tr>
                                    <td>{{ $suivi[$i]->nom_modele }}</td>
                                    <td>{{ $suivi[$i]->numero_commande }}</td>
                                    <td>{{ $suivi[$i]->unite_taille }}</td>
                                    <td>{{ $suivi[$i]->couleur }}</td>
                                    <td>{{ $suivi[$i]->date_livraison_confirme }}</td>
                                    <td>{{ $suivi[$i]->ex_factory }}</td>
                                    @if( $suivi[$i]->diff_date['diff'] <= 3 && $suivi[$i]->diff_date['etat'] == true )
                                        <td class="progress-td">
                                            <div class="progress">
                                                <div class="progress-bar bg-danger progress-animated" style="width: {{ $suivi[$i]->pourcentage }}%; height:6px;" role="progressbar">
                                                    <span class="sr-only"></span>
                                                </div>
                                            </div>
                                        </td>
                                    @elseif( $suivi[$i]->diff_date['diff'] > 0 && $suivi[$i]->diff_date['etat'] == false )
                                        <td class="progress-td">
                                            <div class="progress">
                                                <div class="progress-bar bg-danger progress-animated" style="width: {{ $suivi[$i]->pourcentage }}%; height:6px;" role="progressbar">
                                                    <span class="sr-only"></span>
                                                </div>
                                            </div>
                                        </td>
                                    @else
                                        <td class="progress-td">
                                            <div class="progress">
                                                <div class="progress-bar bg-success progress-animated" style="width: {{ $suivi[$i]->pourcentage }}%; height:6px;" role="progressbar">
                                                    <span class="sr-only"></span>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                    <td>J {{ $suivi[$i]->diff_date['etat'] ? '-' : '+' }}{{ $suivi[$i]->diff_date['diff'] }}</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-right">
                --
            </div>
        </div>

        <div class="card col-12">
            <div class="justify-content-center align-items-center entete">
                <h3 class="entete mt-3">LISTE SUIVIS FLUX MES</h3>
            </div>

            <form action="{{ route('MES.suiviFlux') }}" method="post" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-3 mr-1">
                        <div class="row texte">
                            <label>Date ex-factory</label>
                        </div>
                        <div class="row">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="startEntree"
                                    value="{{ $startEntree }}">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="endEntree"
                                    value="{{ $endEntree }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-2 mr-1">
                        <div class="row texte">
                            <label>OF</label>
                        </div>
                        <div class="row">
                            <div class="input-group">
                                <input type="text" name="of" class="form-control" value="{{ $of }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-2 mr-1">
                        <div class="row texte">
                            <label>Style</label>
                        </div>
                        <div class="row">
                            <div class="input-group">
                                <input type="text" name="modele" class="form-control"
                                    value="{{ $modele }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 col-lg-2">
                        <div class="row texte">
                            <label>Client</label>
                        </div>
                        <div class="row">
                            <div class="input-group">
                                <input type="text" id="nomTiers" name="nomTiers" class="form-control"
                                    value="{{ $nomTiers }}">
                                <input type="hidden" id="idTiers" name="idTiers" value="{{ $idTiers }}">
                                <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="row texte">
                            <label>Designation</label>
                        </div>
                        <div class="row">
                            <div class="input-group">
                                <input type="text" id="nomStyle" name="nomStyle" class="form-control"
                                    value="{{ $nomStyle }}">
                                <input type="hidden" id="idStyle" name="idStyle" value="{{ $idStyle }}">
                                <ul id="suggestionsListStyle" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>

                    </div>




                </div>
                <div class="row mt-2">
                    <div class="col-9">
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <button class="btn btn-success" style="width: 100px">Filtrer</button>
                    </div>
                </div>

            </form>

            <div class="table-responsive" style="margin-top: -15px;">
                <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>ColorCode</th>
                            <th>Style</th>
                            <th>OF NO</th>
                            <th>Designation</th>
                            <th>Size</th>
                            <th>Qte P.O</th>
                            <th>Qte Coupe</th>
                            <th>Qte Entree chaine</th>
                            <th>Qte transferes(sortie chaine)</th>
                            <th>Balance a transfere</th>
                            <th>Entree repassage</th>
                            <th>Sortie repassage</th>
                            <th>Balance repassage</th>

                            <th>Pret a livrer(BOXING)</th>
                            <th>Qte deja livre(Expediee)</th>
                            <th>Balance a livrer(Expediee)</th>
                            <th>Ex-Factory</th>
                            <th>Commentaire</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody style="cursor: pointer;">

                        @for ($i = 0; $i < count($suivi); $i++)
                            <tr>
                                <td>{{ $suivi[$i]->nomtier }}</td>
                                <td>{{ $suivi[$i]->couleur }}</td>
                                <td>{{ $suivi[$i]->nom_modele }}</td>
                                <td>{{ $suivi[$i]->numero_commande }}</td>
                                <td>{{ $suivi[$i]->nom_style }}</td>
                                <td>{{ $suivi[$i]->unite_taille }}</td>
                                <td>{{ $suivi[$i]->qte_po }}</td>
                                <td>{{ $suivi[$i]->qte_coupe }}</td>
                                <td>{{ $suivi[$i]->qte_entree_chaine }}</td>
                                <td>{{ $suivi[$i]->qte_transfere }}</td>
                                <td>{{ $suivi[$i]->balanceatransferer }}</td>
                                <td>{{ $suivi[$i]->entree_repassage }}</td>
                                <td>{{ $suivi[$i]->sortie_repassage }}</td>
                                <td>{{ $suivi[$i]->balancerepassage }}</td>

                                <td>{{ $suivi[$i]->qte_pret_livrer }}</td>
                                <td>{{ $suivi[$i]->qte_deja_livrer }}</td>
                                <td>{{ $suivi[$i]->balancealivrer }}</td>
                                <td> {{ \Carbon\Carbon::parse($suivi[$i]->ex_factory)->format('d/m/y') }}</td>
                                <td>
                                    <?php
                                    $descriptions = substr($suivi[$i]->commentaire, 0, 20);
                                    $hasMore = strlen($suivi[$i]->commentaire) > 20;
                                    ?>
                                    <button data-toggle="modal" data-target="#commentaire"
                                        data-commentaires="{{ $suivi[$i]->commentaire }}"
                                        style="background-color: transparent; border: none;"> {{ $descriptions }}
                                        @if ($hasMore)
                                            ...
                                        @endif
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-finish mt-1 btn-sm"
                                        style="width: 90px;" data-toggle="modal" data-target="#modifSuiviFlux"
                                        data-qtepo="{{ $suivi[$i]->qte_po }}"
                                        data-qtecoupe="{{ $suivi[$i]->qte_coupe }}"
                                        data-qteentreechaine="{{ $suivi[$i]->qte_entree_chaine }}"
                                        data-qtetransferes="{{ $suivi[$i]->qte_transfere }}"
                                        data-pretalivrer="{{ $suivi[$i]->qte_pret_livrer }}"
                                        data-qtedejalivre="{{ $suivi[$i]->qte_deja_livrer }}"
                                        data-entreerepassage="{{ $suivi[$i]->entree_repassage }}"
                                        data-sortierepassage="{{ $suivi[$i]->sortie_repassage }}"
                                        data-commentaire="{{ $suivi[$i]->commentaire }}"
                                        data-idsuivi="{{ $suivi[$i]->id }}"
                                        data-rejetcoupe="{{ $suivi[$i]->qte_rejet_coupe }}"
                                        data-rejetchaine="{{ $suivi[$i]->qte_rejet_chaine }}"
                                        data-etat="{{ $suivi[$i]->etat }}">
                                        <i class="fas fa-edit"></i> Modifier
                                    </button>

                                </td>
                            </tr>
                            @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="repassageModal" tabindex="-1" aria-labelledby="repassageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="repassageModalLabel">Détails du Repassage</h5>

                    </div>
                    <div class="modal-body texte">
                        <p><strong>Entrée Repassage :</strong> <span id="modalEntreeRepassage"></span></p>
                        <p><strong>Sortie Repassage :</strong> <span id="modalSortieRepassage"></span></p>
                        <p><strong>Balance Repassage :</strong> <span id="modalBalanceRepassage"></span></p>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="balanceLivrer" tabindex="-1" aria-labelledby="repassageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="repassageModalLabel">Détails du Transfert</h5>

                    </div>
                    <div class="modal-body texte">
                        <p><strong>Balance a livrer :</strong> <span id="balancealivrer"></span></p>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="errorModalLabel">⚠️Attention!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if (session('error'))
                                <ul style="color: red;">
                                    @foreach (explode('|', session('error')) as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#modifSuiviFlux').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Bouton qui a déclenché l'ouverture
            var modal = $(this);

            // Récupérer les valeurs des attributs data-*
            var qtePo = button.data('qtepo');
            var qteCoupe = button.data('qtecoupe');
            var qteEntreeChaine = button.data('qteentreechaine');
            var qteTransferes = button.data('qtetransferes');
            var pretALivrer = button.data('pretalivrer');
            var qteDejaLivre = button.data('qtedejalivre');
            var entreeRepassage = button.data('entreerepassage');
            var sortieRepassage = button.data('sortierepassage');
            var commentaire = button.data('commentaire');
            var idsuivi = button.data('idsuivi');
            var rejetcoupe = button.data('rejetcoupe');
            var rejetchaine = button.data('rejetchaine');
            var etat = button.data('etat');
            console.log(etat);
            // Remplir les champs du formulaire
            modal.find('#qtePo1').val(qtePo);
            modal.find('#qteCoupe').val(qteCoupe);
            modal.find('#qteEntreeChaine').val(qteEntreeChaine);
            modal.find('#qteTransferes').val(qteTransferes);
            modal.find('#pretALivrer').val(pretALivrer);
            modal.find('#qteDejaLivre').val(qteDejaLivre);
            modal.find('#entreeRepassage').val(entreeRepassage);
            modal.find('#sortieRepassage').val(sortieRepassage);
            modal.find('#commentaires').val(commentaire);
            modal.find('#rejetCoupe').val(rejetcoupe);
            modal.find('#rejetChaine').val(rejetchaine);
            modal.find('#idSuivi').val(idsuivi);

            const checkboxContainer = document.getElementById('checkboxContainer');

            if (qtePo <= qteCoupe) {
                checkboxContainer.style.display = 'block'; // Show the checkbox
            } else {
                checkboxContainer.style.display = 'none'; // Hide the checkbox
            }

            const inputQteCoupe = document.getElementById('qteCoupe');
            const checkboxCondition = document.getElementById('checkboxCondition');
            if (etat == 1) {
                inputQteCoupe.disabled = true; // Désactive l'input
                checkboxCondition.checked = true;
                checkboxCondition.disabled = true;
            } else {
                inputQteCoupe.disabled = false; // Active l'input
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#commentaire').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Bouton qui a déclenché l'ouverture
            var modal = $(this);

            // Récupérer les valeurs des attributs data-*
            var commentaires = button.data('commentaires');

            modal.find('#commentaireModal').val(commentaires);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomTiers = document.getElementById('nomTiers');
        var idTiers = document.getElementById('idTiers');
        var suggestionsListTiers = document.getElementById('suggestionsListTiers');

        nomTiers.addEventListener('input', function() {
            var query = nomTiers.value;

            if (query.length < 1) {
                suggestionsListTiers.style.display = 'none';
                return;
            }

            var xhr1 = new XMLHttpRequest();
            xhr1.open('GET', '{{ route('recherche-tiers-demande') }}?nomTiers=' + encodeURIComponent(
                query), true);
            xhr1.onload = function() {
                if (xhr1.status === 200) {
                    var tiers = JSON.parse(xhr1.responseText);
                    suggestionsListTiers.innerHTML = '';
                    if (tiers.length > 0) {
                        tiers.forEach(function(tier) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = tier.nomtier;
                            li.addEventListener('click', function() {
                                nomTiers.value = tier.nomtier;
                                idTiers.value = tier.id;
                                suggestionsListTiers.style.display = 'none';
                            });
                            suggestionsListTiers.appendChild(li);
                        });
                        suggestionsListTiers.style.display = 'block';
                    } else {
                        suggestionsListTiers.style.display = 'none';
                    }
                }
            };
            xhr1.send();
        });

        document.addEventListener('click', function(event) {
            if (!nomTiers.contains(event.target) && !suggestionsListTiers.contains(event.target)) {
                suggestionsListTiers.style.display = 'none';
            }
        });
    });
</script>


{{--  style  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomSaison = document.getElementById('nomStyle');
        var idSaison = document.getElementById('idStyle');
        var suggestionsList = document.getElementById('suggestionsListStyle');

        nomSaison.addEventListener('input', function() {
            var query = nomSaison.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('recherche-style') }}?nomStyle=' + encodeURIComponent(query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function(saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.nom_style;
                            li.addEventListener('click', function() {
                                nomSaison.value = saison.nom_style;
                                idSaison.value = saison.id;
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
            if (!nomSaison.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

<script>
    // Afficher automatiquement le modal si une erreur est présente
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error'))
            $('#errorModal').modal('show');
        @endif
    });
</script>

<!-- Script JavaScript -->
<script>
    function ouvrirModal(entree, sortie, balance) {
        document.getElementById('modalEntreeRepassage').textContent = entree;
        document.getElementById('modalSortieRepassage').textContent = sortie;
        document.getElementById('modalBalanceRepassage').textContent = balance;

        // Ouvrir la modal
        var modal = new bootstrap.Modal(document.getElementById('repassageModal'));
        modal.show();
    }
</script>

<!-- Script JavaScript -->
<script>
    function ouvrirModalBalance(balance) {
        document.getElementById('balancealivrer').textContent = balance;

        // Ouvrir la modal
        var modal = new bootstrap.Modal(document.getElementById('balanceLivrer'));
        modal.show();
    }
</script>


@include('CRM.footer')
