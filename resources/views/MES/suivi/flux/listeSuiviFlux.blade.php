@include('CRM.header')
@include('CRM.sidebar')
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
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('MES.headerMES')
        <div class="row" style="margin-bottom: -20px;margin-top: -10px;">
            <div class="col-lg-3 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #3a7bd5, #3a6073);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Quantité PO</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">5</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-list"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #4568dc, #b06ab3);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Quantité Coupe</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">4</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-handshake"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #43cea2, #185a9d);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Quantité Entrée chaine</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">3</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-check-circle"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #f3904f, #3b4371);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Quantité Transferés</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">2</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-times-circle"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 0;">
            <div class="col-lg-3 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #ff6e7f, #556770);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Balance à transférer</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">6</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-cogs"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #16a085, #f4d03f);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Prêt à livrer</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">7</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-file-alt"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #82a382, #000c40);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Quantité déjà livré</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">6</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-box"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #667eea, #764ba2);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white"
                                style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Balance à livrer
                            </h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">7</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-industry"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-12">

            <div class="justify-content-center align-items-center entete">
                <h3 class="entete mt-3">LISTE SUIVIS FLUX MES</h3>
            </div>

            {{--  <form action="{{ route('BRODMACHINE.listeBroderieMachine') }}" method="post" autocomplete="off">  --}}
            {{--  @csrf  --}}
            {{--  <div class="row">
                    <div class="col-1">
                        <div class="input-group">
                            <input type="text" id="nomSaison" name="nomSaison" class="form-control"
                                placeholder="Saison" value="">
                            <input type="hidden" id="idSaison" name="idSaison" value="{{ $idSaison }}">
                            <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;">
                            </ul>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="input-group">
                            <input type="text" id="modele" name="modele" class="form-control"
                                placeholder="Modele" value="{{ $modele }}">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="input-group">
                            <input type="text" id="nomTiers" name="nomTiers" class="form-control"
                                placeholder="Nom Client" value="{{ $nomTiers }}">
                            <input type="hidden" id="idTiers" name="idTiers" value="{{ $idTiers }}">
                            <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                            </ul>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="input-group">
                            <input type="text" id="nomStyle" name="nomStyle" class="form-control"
                                placeholder="Style" value="{{ $nomStyle }}">
                            <input type="hidden" id="idStyle" name="idStyle" value="{{ $idStyle }}">
                            <ul id="suggestionsListStyle" class="list-group mt-2" style="display: none;">
                            </ul>
                        </div>
                    </div>

                    <div class="col-2">

                        <select class="form-control" name="etatDemande">
                            @if (!empty($etatDemande))
                                <option value="{{ $etatDemande }}">{{ $etatDemande }}</option>
                            @endif
                            <option value="">Etat</option>

                            @foreach ($etat as $et)
                                <option value="{{ $et->type_etat }}">
                                    {{ $et->type_etat }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-2">
                        <div class="input-group">
                            <input type="text" id="nomStade" name="nomStade" class="form-control"
                                placeholder="Stade" value="{{ $nomStade }}">
                            <input type="hidden" id="idStade" name="idStade" value="{{ $idStade }}">
                            <ul id="suggestionsListStade" class="list-group mt-2" style="display: none;">
                            </ul>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="input-group" id="date-range">
                            <input type="date" class="form-control" name="dateDebut"
                                value="{{ $dateDebut }}">
                            <span class="input-group-addon b-0 text-white"
                                style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                            <input type="date" class="form-control" name="dateFin"
                                value="{{ $dateFin }}">
                        </div>
                    </div>

                </div>  --}}
            {{--  <div class="row mt-2">
                    <div class="col-9">
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <button class="btn btn-success" style="width: 100px">Filtrer</button>
                    </div>
                </div>  --}}

            {{--  </form>  --}}

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
                            <th>Pret a livrer(BOXING)</th>
                            <th>Qte deja livre(Expediee)</th>
                            <th>Balance a livrer(Expediee)</th>
                            <th>Entree repassage</th>
                            <th>Sortie repassage</th>
                            <th>Balance repassage</th>
                            <th>Ex-Factory</th>
                            <th>Commentaire</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody style="cursor: pointer;">

                        <tr>
                            <td>Client 2</td>
                            <td>ColorCode 2</td>
                            <td>Style 2</td>
                            <td>OF NO 2</td>
                            <td>Designation 2</td>
                            <td>Size 2</td>
                            <td>Qte P.O 2</td>
                            <td>Qte Coupe 2</td>
                            <td>Qte Entree chaine 2</td>
                            <td>Qte transferes(sortie chaine) 2</td>
                            <td>Balance a transfere 2</td>
                            <td>Pret a livrer(BOXING) 2</td>
                            <td>Qte deja livre(Expediee) 2</td>
                            <td>Balance a livrer(Expediee) 2</td>
                            <td>Entree repassage 2</td>
                            <td>Sortie repassage 2</td>
                            <td>Balance repassage 2</td>
                            <td>Ex-Factory 2</td>
                            <td>
                                <button data-toggle="modal" data-target="#commentaire"
                                    data-commentaires="Commentaire 2"
                                    style="background-color: transparent; border: none;"> Commentaire 2</button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-finish mt-1 btn-sm"
                                    style="width: 90px;" data-toggle="modal" data-target="#modifSuiviFlux"
                                    data-qtepo="Qte P.O 2" data-qtecoupe="Qte Coupe 2"
                                    data-qteentreechaine="Qte Entree chaine 2"
                                    data-qtetransferes="Qte transferes(sortie chaine) 2"
                                    data-pretalivrer="Pret a livrer(BOXING) 2"
                                    data-qtedejalivre="Qte deja livre(Expediee) 2"
                                    data-entreerepassage="Entree repassage 2"
                                    data-sortierepassage="Sortie repassage 2">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>

        <!-- Modification suiviFlux -->
        <div class="modal fade" id="modifSuiviFlux" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg-custom" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Modification suivi flux</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body texte">
                        <form action="" method="POST" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="idSuivi" id="idSuivi">
                                <label for="qtePo">Qte P.O</label>
                                <input type="text" class="form-control" id="qtePo1" name="qtePo" disabled>
                            </div>
                            <div class="form-group">
                                <label for="qteCoupe">Qte Coupe</label>
                                <input type="text" class="form-control" id="qteCoupe" name="qteCoupe">
                            </div>
                            <div class="form-group">
                                <label for="qteEntreeChaine">Qte Entree chaine</label>
                                <input type="text" class="form-control" id="qteEntreeChaine"
                                    name="qteEntreeChaine">
                            </div>
                            <div class="form-group">
                                <label for="qteTransferes">Qte transferes (sortie chaine)</label>
                                <input type="text" class="form-control" id="qteTransferes" name="qteTransferes">
                            </div>
                            <div class="form-group">
                                <label for="pretALivrer">Pret a livrer (BOXING)</label>
                                <input type="text" class="form-control" id="pretALivrer" name="pretALivrer">
                            </div>
                            <div class="form-group">
                                <label for="qteDejaLivre">Qte deja livree (Expediee)</label>
                                <input type="text" class="form-control" id="qteDejaLivre" name="qteDejaLivre">
                            </div>
                            <div class="form-group">
                                <label for="entreeRepassage">Entree Repassage</label>
                                <input type="text" class="form-control" id="entreeRepassage"
                                    name="entreeRepassage">
                            </div>
                            <div class="form-group">
                                <label for="sortieRepassage">Sortie Repassage</label>
                                <input type="text" class="form-control" id="sortieRepassage"
                                    name="sortieRepassage">
                            </div>

                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>


        <!-- Commentaire -->
        <div class="modal fade" id="commentaire" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg-custom" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Commentaire</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body texte">
                       <input type="text" class="form-control" id="commentaireModal" disabled>
                    </div>
                </div>
            </div>
        </div>

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
            console.log(qtePo);
            // Remplir les champs du formulaire
            modal.find('#qtePo1').val(qtePo);
            modal.find('#qteCoupe').val(qteCoupe);
            modal.find('#qteEntreeChaine').val(qteEntreeChaine);
            modal.find('#qteTransferes').val(qteTransferes);
            modal.find('#pretALivrer').val(pretALivrer);
            modal.find('#qteDejaLivre').val(qteDejaLivre);
            modal.find('#entreeRepassage').val(entreeRepassage);
            modal.find('#sortieRepassage').val(sortieRepassage);
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

@include('CRM.footer')
