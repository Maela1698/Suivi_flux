@include('CRM.header')
@include('CRM.sidebar')
<style>
    .code {
        display: flex;
        gap: 4px;
        /* Espace entre les cercles */
    }

    .circle {
        border: solid thin black;
        width: 30px;
        /* Largeur du cercle */
        height: 30px;
        /* Couleur de fond du cercle */
        color: white;
        /* Couleur du texte */
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        /* Rend le div rond */
        font-size: 24px;
        /* Taille du texte */
    }

    label {
        color: black;
        font-size: 12px;
    }

    #suggestionsListSaison {
        max-height: 200px;
        overflow-y: auto;
        color: white;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: black;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }

    #suggestionsListTiers {
        max-height: 200px;
        overflow-y: auto;
        color: white;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: black;
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
        color: white;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: black;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }
</style>
<!--**********************************
            Content body start
         ***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('PLANNING.headerPlan')
        <div class="col-lg-12">
            <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                <div class="card-header text-center" style="display: flex; justify-content: start;">
                    <h3 class="entete">LISTE DEMANDE FOR PPMEETING</h3>
                </div>
                <div class="card-body" style="margin-top: -15px;overflow: auto;">
                    <form action="{{ route('LRP.listeDemandeForPpmeeting') }}" method="get" autocomplete="off">
                        @csrf
                        <div class="recherche" style="display: flex; flex-wrap: wrap; align-items: center;">

                            <div class="col-auto my-1" style="flex-grow: 1; min-width: 200px;">
                                <label class="mr-sm-2" for="inlineFormInput">Client</label>
                                <input type="text" id="nomTiers" name="nomTiers" value="{{ $nomTiers }}" class="form-control" oninput="syncHiddenField('nomTiers', 'idTiers')">
                                    <input type="hidden" id="idTiers" name="idTiers" value="{{ $idTiers }}">
                                    <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                                    </ul>
                            </div>
                            <div class="col-auto my-1" style="flex-grow: 1; min-width: 200px;">
                                <label class="mr-sm-2" for="inlineFormInput">Modele</label>
                                <input type="text" class="form-control mr-sm-2" id="inlineFormInput" name="modele" value="{{ $modele }}">
                            </div>
                            <div class="col-auto my-1" style="flex-grow: 1; min-width: 200px;">
                                <label class="mr-sm-2" for="inlineFormInput" style="color: transparent;">Search</label>
                                <input type="submit" style="background-color: rgb(51, 208, 51);width:80px;"
                                    class="form-control mr-sm-2" id="inlineFormInput" value="Filtrer">
                            </div>
                        </div>
                    </form>
                    <br>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Couleur</th>
                                <th>Date PPM</th>
                                <th>Chaine</th>
                                <th>Client</th>
                                <th>Modèle</th>
                                <th>Qté</th>
                                <th>VA</th>
                                <th>Date entree chaine</th>
                                <th>Date entree coupe</th>
                                <th>Date entree finition</th>
                                <th>Date ex usine</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($liste as $d)
                                <tr style="color: rgb(77, 77, 77);cursor: pointer;" data-demande="{{ $d->id }}"
                                    data-datemeeting="{{ $d->dateppm }}" data-designation="{{ $d->designation }}"
                                    data-entreechaine="{{ $d->date_entree_chaine }}"
                                    data-entreecoupe="{{ $d->date_entree_coupe }}"
                                    data-entreefinition="{{ $d->date_entree_finition }}"
                                    data-heuredebut="{{ $d->heure_debut }}"
                                    data-effectifprevu="{{ $d->effectif_prevu }}"
                                    data-effectifreel="{{ $d->effectif_reel }}"
                                    data-etat="{{ $d->etat_detailmeeting }}"
                                    data-commentaire="{{ $d->commentaire }}" data-idchaine="{{ $d->id_chaine }}"
                                    onclick="ouvrirModalPPMeeting(this)">
                                    <td>
                                        <div class="code">
                                            @if ($d->tissus)
                                                <div class="circle"
                                                    style="background-color: green;font-size: 12px;color:white;">T</div>
                                            @else
                                                <div class="circle"
                                                    style="background-color: white;font-size: 12px;color:black;">T</div>
                                            @endif
                                            @if ($d->accy)
                                                <div class="circle"
                                                    style="background-color: green;font-size: 12px;color:white;">A</div>
                                            @else
                                                <div class="circle"
                                                    style="background-color: white;font-size: 12px;color:black;">A</div>
                                            @endif
                                            @if ($d->okprod)
                                                <div class="circle"
                                                    style="background-color: green;font-size: 12px;color:white;">Ok
                                                </div>
                                            @else
                                                <div class="circle"
                                                    style="background-color: white;font-size: 12px;color:black;">Ok
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if ($d->dateppm)
                                            {{ \Carbon\Carbon::parse($d->dateppm)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>{{ $d->designation }}/{{ $d->id }}</td>
                                    <td>{{ $d->nomtier }}</td>
                                    <td>{{ $d->nom_modele }}</td>
                                    <td>{{ $d->qte_commande_provisoire }}</td>
                                    <td>{{ $d->types_valeur_ajout }}</td>
                                    <td>
                                        @if ($d->date_entree_chaine)
                                            {{ \Carbon\Carbon::parse($d->date_entree_chaine)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->date_entree_coupe)
                                            {{ \Carbon\Carbon::parse($d->date_entree_coupe)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->date_entree_finition)
                                            {{ \Carbon\Carbon::parse($d->date_entree_finition)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->ex_factory)
                                            {{ \Carbon\Carbon::parse($d->ex_factory)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Ajout ppmeeting -->
        <div class="modal fade" id="ppmeeting" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="width: 360px" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Ajout PPMeeting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body texte">
                        <form action="{{ route('LRP.ajoutPPMeeting') }}" method="POST" autocomplete="off">
                            @csrf
                            <input type="hidden" name="demandePasse" id="demandePasse">
                            <input type="hidden" name="daty" id="daty">
                            <input type="hidden" name="modele"  value="{{ $modele }}">
                            <input type="hidden" name="nomTiers"  value="{{ $nomTiers }}">
                            <input type="hidden" name="idTiers"  value="{{ $idTiers }}">
                            <div id="checkboxContainer" class="mr-3" style="margin-top: 10px;">
                                <label for="checkboxCondition">Fini</label>
                                <input type="checkbox" id="checkboxCondition" value="true" name="fini">
                            </div>

                            <div class="form-group">
                                <label>Date ppmeeting</label>
                                <input type="date" class="form-control" id="datys" name="dateppmeeting" required>
                            </div>

                            <div class="form-group">
                                <label>Heure ppmeeting</label>
                                <input type="time" class="form-control" id="heuredebuts" name="heureppmeeting" required>
                            </div>

                            <div class="form-group">
                                <label>Effectifs prévus</label>
                                <input type="number" class="form-control" id="effectifprevus" name="effectifPrevu" required>
                            </div>

                            <div class="form-group">
                                <label>Effectifs réels</label>
                                <input type="number" class="form-control" id="effectifreels" name="effectifReel" required>
                            </div>

                            <div class="form-group">
                                <label>Chaine</label>
                                <select class="form-control"  name="chaineMeeting" >
                                   @for ($c=0 ;$c  < count($chaine);$c ++)
                                       <option value="{{ $chaine[$c]->id_chaine }}">{{ $chaine[$c]->designation }}</option>
                                   @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Date entrée chaîne</label>
                                <input type="date" class="form-control" id="entreechaines" name="dateChaine" required>
                            </div>

                            <div class="form-group">
                                <label>Date entrée coupe</label>
                                <input type="date" class="form-control" id="entreecoupes" name="dateCoupe" required>
                            </div>

                            <div class="form-group">
                                <label>Date entrée finition</label>
                                <input type="date" class="form-control" id="entreefinitions" name="dateFinition" required>
                            </div>

                            <div class="form-group">
                                <label>Commentaire</label>
                                <input type="text" class="form-control" id="commentaires" name="commentaire" required>
                            </div>

                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                            </div>
                        </form>
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
                                    <li>{{ session('error') }}</li>
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


<!--**********************************
            Content body end
        ***********************************-->

@include('CRM.footer')



<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomSaison = document.getElementById('nomSaison');
        var idSaison = document.getElementById('idSaison');
        var suggestionsList = document.getElementById('suggestionsListSaison');

        nomSaison.addEventListener('input', function() {
            var query = nomSaison.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('recherche-saison') }}?nomSaison=' + encodeURIComponent(query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function(saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.type_saison;
                            li.addEventListener('click', function() {
                                nomSaison.value = saison.type_saison;
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomStyle = document.getElementById('nomStyle');
        var idStyle = document.getElementById('idStyle');
        var suggestionsList = document.getElementById('suggestionsListStyle');

        nomStyle.addEventListener('input', function() {
            var query = nomStyle.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('recherche-style') }}?nomStyle=' + encodeURIComponent(query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var styles = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (styles.length > 0) {
                        styles.forEach(function(style) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = style.nom_style;
                            li.addEventListener('click', function() {
                                nomStyle.value = style.nom_style;
                                idStyle.value = style.id;
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
            if (!nomStyle.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>
<script>
    function syncHiddenField(textInputId, hiddenInputId) {
        const textInput = document.getElementById(textInputId);
        const hiddenInput = document.getElementById(hiddenInputId);

        if (textInput.value.trim() === '') {
            hiddenInput.value = ''; // Clear the hidden field if the text input is empty
        }
    }
</script>

<script>
    function ouvrirModalPPMeeting(button) {
        var iddemande = button.getAttribute('data-demande');
        var datemeeting = button.getAttribute('data-datemeeting');
        var entreechaine = button.getAttribute('data-entreechaine');
        var entreecoupe = button.getAttribute('data-entreecoupe');
        var entreefinition = button.getAttribute('data-entreefinition');
        var heuredebut = button.getAttribute('data-heuredebut');
        var effectifprevu = button.getAttribute('data-effectifprevu');
        var effectifreel = button.getAttribute('data-effectifreel');
        var commentaire = button.getAttribute('data-commentaire');
        var idchaine = button.getAttribute('data-idchaine');
        var designation = button.getAttribute('data-designation');
        var etat = button.getAttribute('data-etat');

        // Remplir les champs du formulaire
        document.getElementById('daty').value = datemeeting;
        document.getElementById('datys').value = datemeeting;
        document.getElementById('demandePasse').value = iddemande;
        document.getElementById('entreechaines').value = entreechaine;
        document.getElementById('entreecoupes').value = entreecoupe;
        document.getElementById('entreefinitions').value = entreefinition;
        document.getElementById('heuredebuts').value = heuredebut;
        document.getElementById('effectifprevus').value = effectifprevu;
        document.getElementById('effectifreels').value = effectifreel;
        document.getElementById('commentaires').value = commentaire;

        const checkboxCondition = document.getElementById('checkboxCondition');
        if(etat==false){
            checkboxCondition.checked= false;
        }else{
            checkboxCondition.checked= true;
        }
        // Ouvrir la modal
        var modal = new bootstrap.Modal(document.getElementById('ppmeeting'));
        modal.show();
    }

</script>

<script>
    // Afficher automatiquement le modal si une erreur est présente
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error'))
            $('#errorModal').modal('show');
        @endif
    });
</script>
