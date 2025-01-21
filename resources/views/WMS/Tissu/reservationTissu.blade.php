@include('CRM.header')
@include('CRM.sidebar')
<style>
    .text-success {
        color: green;
    }

    .text-primary {
        color: blue;
    }

    .text-danger {
        color: red;
    }
</style>
<div class="content-body">

    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card">

            <div class="card-header py-3">
                <h4 class="text-primary m -0 font-weight-bold">Liste Réservation </h4>
            </div>
            <div class="card-body">
                {{-- TODO: A completer l'action --}}
                <form class="mb-4" action="#" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idcategorietissu">
                                    <optgroup label="Catégorie du tissu">
                                        <option value="">Selection du catégorie du tissu</option>
                                        @foreach ($categorie as $categories)
                                            <option value="{{ $categories->id }}">{{ $categories->categorie }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idclassematierepremiere">
                                    <optgroup label="Classe du tissu">
                                        <option value="">Sélection de la classe</option>
                                        @foreach ($classeMatiere as $classeMatieres)
                                            <option value="{{ $classeMatieres->id }}">{{ $classeMatieres->classe }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idutilisationwms">
                                    <optgroup label="Utilisation">
                                        <option value="">Sélection de l'utilisation</option>
                                        @foreach ($utilisation as $utilisations)
                                            <option value="{{ $utilisations->id }}">{{ $utilisations->utilisation }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idclient">
                                    <optgroup label="Client">
                                        <option value="">Sélection du client</option>
                                        @foreach ($client as $clients)
                                            <option value="{{ $clients->id }}">{{ $clients->nomtier }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idfournisseur">
                                    <optgroup label="Fournisseur">
                                        <option value="">Sélection du fournisseur</option>
                                        @foreach ($fournisseur as $fournisseurs)
                                            <option value="{{ $fournisseurs->id }}">{{ $fournisseurs->nomtier }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="debut">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="fin">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="text" class="form-control" name="recherche" placeholder="Recherche">
                            </div>
                        </div>

                        <div class="col-1">
                            <button class="btn btn-success">Filtrer</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive table mt-2" id="dataTable" role="grid"
                    aria-describedby="dataTable_info">
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('erreur') }}</div>
                    @endif
                    @if ($errors->has('error'))
                        <div class="alert alert-danger">
                            {{ $errors->first('error') }}
                        </div>
                    @endif
                    <table class="table my-0" id="dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Désignation</th>
                                <th>Réference</th>
                                <th>Couleur</th>
                                <th>Composition</th>
                                <th>Catégorie</th>
                                <th>Date de réservation</th>
                                <th>Quantité réserver</th>
                                <th>Etat</th>
                                <th>Commentaire</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="color: black">
                            @foreach ($historyReservation as $historyReservations)
                                <tr>
                                    <th>{{ $historyReservations->designation }}</th>
                                    <th>{{ $historyReservations->reference }}</th>
                                    <th>{{ $historyReservations->couleur }}</th>
                                    <th>{{ $historyReservations->composition }}</th>
                                    <th>{{ $historyReservations->categorie }}</th>
                                    <th>{{ \App\Models\WMSModel\FormatDate::formatFR($historyReservations->datereservation) }}
                                    </th>
                                    <th>{{ $historyReservations->qtereserve }}</th>
                                    <th
                                        class="
                                    @if ($historyReservations->validation == 0 && $historyReservations->etat_reservation == 0) text-success
                                    @elseif ($historyReservations->validation == 1 && $historyReservations->etat_reservation == 1)text-danger
                                    @else text-primary @endif
                                    ">
                                        @if ($historyReservations->validation == 0 && $historyReservations->etat_reservation == 0)
                                            Valider
                                        @elseif ($historyReservations->validation == 1 && $historyReservations->etat_reservation == 1)
                                            Refuser
                                        @else
                                            En attente
                                        @endif
                                    </th>
                                    @if ($historyReservations->qtereserve > 0)
                                        @if ($historyReservations->validation == 1 && $historyReservations->etat_reservation == 0)
                                            <td>
                                                <a class="btn btn-success"
                                                    href="{{ route('WMS.validation-reservation-tissu', ['idreservation' => $historyReservations->idreservation]) }}"
                                                    style="border-radius: 50%; padding: 10px;" title="Accepter">
                                                    <i class="fa fa-check"
                                                        style="border-radius: 50%; padding: 6px; width: 20px; height: 20px; font-size: 12px; background-color: white; color: green; display: inline-flex; align-items: center; justify-content: center;"></i>
                                                </a>
                                                <a class="btn btn-danger" data-toggle="modal"
                                                    data-target="#refus-modal-{{ $historyReservations->idreservation }}"
                                                    style="border-radius: 50%; padding: 10px;" title="Refuser">
                                                    <i class="fa fa-close"
                                                        style="border-radius: 50%; padding: 6px; width: 20px; height: 20px; font-size: 12px; background-color: white; color: red; display: inline-flex; align-items: center; justify-content: center;"></i>
                                                </a>

                                            </td>
                                        @elseif ($historyReservations->validation == 0 && $historyReservations->etat_reservation == 0)
                                            <td>
                                                <a class="btn btn-danger" data-toggle="modal"
                                                    data-target="#suppression-modal-{{ $historyReservations->idreservation }}"
                                                    title="Annuler la réservation">
                                                    Annuler
                                                </a>
                                                <a class="btn" type="button" data-toggle="modal"
                                                    data-target="#livraison-modal-{{ $historyReservations->idreservation }}"
                                                    style="background-color: greenyellow" title="Rendre obsolete">
                                                    Livrer
                                                </a>
                                            </td>
                                        @endif
                                    @endif
                                </tr>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    *Livraison Sortie modal
                                --}}
                                <div class="modal" id="livraison-modal-{{ $historyReservations->idreservation }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Sortie</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info" style="color: black">Sortie de
                                                    stock</p>
                                                <form id="modification-form"
                                                    action="{{ route('WMS.sortie-reservation-tissu') }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    {{-- TODO: Remplir la value --}}
                                                    <input type="hidden" class="form-control" name="idfamilletissus"
                                                        value="{{ $historyReservations->idfamilletissus }}">
                                                    <input type="hidden" class="form-control" name="obsolete"
                                                        value="{{ $historyReservations->obsolete }}">
                                                    <input type="hidden" class="form-control" name="typeSortie"
                                                        value="0">
                                                    <input type="hidden" name="idstocktissu"
                                                        value="{{ $historyReservations->id }}">
                                                    <input type="hidden" name="idreservation"
                                                        value="{{ $historyReservations->idreservation }}">
                                                    <div class="mb-3"><label class="form-label">Date de
                                                            sortie</label>
                                                        <input class="form-control" type="date" name="datesortie"
                                                            value="{{ date('Y-m-d') }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Num BCI</label>
                                                        <input class="form-control" type="text" name="numbci">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Destinataire</label>
                                                        <input class="form-control" type="text"
                                                            name="destinataire">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Receveur</label>
                                                        <input class="form-control" type="text" name="receveur">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Quantité à
                                                            sortir</label>
                                                        <input class="form-control" type="text" name="qtesortie">
                                                    </div>

                                                    <div class="mb-3"><label class="form-label">Commentaire</label>
                                                        <textarea class="form-control requete" name="commentaire" rows="4" cols="50"></textarea>
                                                    </div>
                                            </div>
                                            <div style="text-align: center">
                                                <div class="modal-footer" style="text-align: center">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal">Annuler</button>
                                                    <button class="btn btn-primary" type="submit">Livrer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Annulation
                                --}}
                                <div class="modal" id="suppression-modal-{{ $historyReservations->idreservation }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Annulation</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="GET"
                                                    action="{{ route('WMS.annulation-reservation-tissu', ['idreservation' => $historyReservations->idreservation]) }}">
                                                    @csrf
                                                    <p class="alert alert-danger" style="color: black">
                                                        Voulez-vous
                                                        vraiment
                                                        annuler cette reservation ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">Annuler</button>
                                                <button class="btn btn-danger" type="submit">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Refus
                                --}}
                                <div class="modal" id="refus-modal-{{ $historyReservations->idreservation }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Refus</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="GET"
                                                    action="{{ route('WMS.refus-reservation-tissu', ['idreservation' => $historyReservations->idreservation]) }}">
                                                    @csrf
                                                    <p class="alert alert-danger" style="color: black">
                                                        Voulez-vous
                                                        vraiment
                                                        Refuser cette reservation ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">Annuler</button>
                                                <button class="btn btn-danger" type="submit">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@include('CRM.footer')
