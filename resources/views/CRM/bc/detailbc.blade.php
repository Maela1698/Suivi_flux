<style>
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
@include('CRM.header')
@include('CRM.sidebar')

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerBc')
        <div class="col-lg-12">
            <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                <div class="container mt-4">
                    <h2 class="section-title">Details TSCF</h2>
                    <form action="{{ route('CRM.retourListeTscf') }}" method="get">
                        @csrf
                        <input type="hidden" name="coupe" value="{{ $produit[0]->idtypebc }}">
                    <button type="submit" class="btn btn-secondary" style="float: right;margin-top: -50;margin-right: -90px;">Retour</button>
                    </form>
                    <div class="details-section">
                        <div class="details-box">
                            @php
                            $value = collect($attn)->pluck('nominterlocateur')->implode('/');
                            @endphp
                            @if(count($merch)>0)
                                <label style="color: black;">MERCH</label>
                                <p>Date Ex-Usine Fournisseur: {{ $merch[0]->dateex }} </p>
                                <p>Deadline Arrivee Usine: {{ $merch[0]->deadline }}</p>
                                <p>ATTN: {{ $value }}</p>
                                <p>Mode de Transport: {{ $merch[0]->transport }}</p>
                                <p>Date Emission Facture: {{ $merch[0]->dateemmission }}</p>
                                <p>Numero Facturation: {{ $merch[0]->numerofacture }}</p>
                                <p>Montant Facture: {{ $merch[0]->montant }}</p>
                                <p>Details Facture: {{ $merch[0]->detailfacture }}</p>
                                <p>Commentaire: {{ $merch[0]->commentaire }}</p>
                                @else
                                <label style="color: black;">MERCH</label>
                                <p>Date Ex-Usine Fournisseur:</p>
                                <p>Deadline Arrivee Usine:</p>p

                                <p>ATTN: {{ $value }}</p>
                                <p>Mode de Transport:</p>
                                <p>Date Emission Facture:</p>
                                <p>Numero Facturation:</p>
                                <p>Montant Facture:</p>
                                <p>Details Facture:</p>
                                <p>Commentaire:</p>
                            @endif
                        </div>
                        <div class="details-box">
                            @if(count($transite)>0)
                                <label style="color: black;">TRANSIT</label>
                                <p>Transit: {{ $transite[0]->transit }}</p>
                                <p>Transit Time: {{ $transite[0]->transittime }}</p>
                                <p>Date de Depart: {{ $transite[0]->datedepart }}</p>
                                <p>Date d'Arrivee Import Prevue: {{ $transite[0]->datearrive }}</p>
                                <p>AWB/BL: {{ $transite[0]->awb }}</p>
                                @else
                                <label style="color: black;">TRANSIT</label>
                                <p>Transit:</p>
                                <p>Transit Time:</p>
                                <p>Date de Depart:</p>
                                <p>Date d'Arrivee Import Prevue:</p>
                                <p>AWB/BL:</p>
                            @endif
                        </div>
                        <div class="details-box">
                            @if(count($magasin)>0)
                                <label style="color: black;">MAGASIN</label>
                                <p>Date d'Arrivee Reelle Usine: {{ $magasin[0]->datearrivereelle }}</p>
                                <p>BL N°: {{ $magasin[0]->bl }}</p>
                                <p>Quantite Livree: {{ $magasin[0]->quantite }}</p>
                                <p>RAL: {{ $magasin[0]->reste }}</p>
                                <p>% Livree: {{ number_format(($magasin[0]->quantite/$produit[0]->quantite)*100, 2, ',', ' ') }}%</p>
                                <p>N° Facture: {{ $magasin[0]->numero }}</p>
                                @else
                                <label style="color: black;">MAGASIN</label>
                                <p>Date d'Arrivee Reelle Usine:</p>
                                <p>BL N°:</p>
                                <p>Quantite Livree:</p>
                                <p>RAL:</p>
                                <p>% Livree: 0%</p>
                                <p>N° Facture:</p>
                            @endif
                        </div>
                        <div class="details-box">
                            @if(count($compta)>0)
                                <label style="color: black;">COMPTA</label>
                                <p>SWIFT (Date): {{ $compta[0]->swift }}</p>
                                <p>Deposit: {{ $compta[0]->deposit }}</p>
                                <p>Prix BC: {{ $compta[0]->pri }}</p>
                                <p>% Payer: {{ number_format($compta[0]->payer*100, 2, ',', ' ') }}%</p>
                                @else
                                <label style="color: black;">COMPTA</label>
                                <p>SWIFT (Date):</p>
                                <p>Deposit:</p>
                                <p>Prix BC: Euro</p>
                                <p>% Payer:</p>
                            @endif
                        </div>
                        <div class="details-box">
                            @if(count($reclamation)>0)
                                <label style="color: black;">RECLAMATION</label>
                                <p>Date Envoie Reclamation: {{ $reclamation[0]->dateenvoie }}</p>
                                <p>Date Relance: {{ $reclamation[0]->daterelance }}</p>
                                <p>Raison de Reclamation: {{ $reclamation[0]->raison }}</p>
                                <p>Metrage Concerne: {{ $reclamation[0]->quantite }}</p>
                                <p>Defaut/Remarque: {{ $reclamation[0]->remarque }}</p>
                                <p>Retour Fournisseur: {{ $reclamation[0]->retour }}</p>
                                <p>Recompensation: {{ $reclamation[0]->recompensation }}</p>
                                <p>Note de Credit: {{ $reclamation[0]->note }}</p>
                                @else
                                <label style="color: black;">RECLAMATION</label>
                                <p>Date Envoie Reclamation:</p>
                                <p>Date Relance:</p>
                                <p>Raison de Reclamation:</p>
                                <p>Metrage Concerne:</p>
                                <p>Defaut/Remarque:</p>
                                <p>Retour Fournisseur:</p>
                                <p>Recompensation:</p>
                                <p>Note de Credit:</p>
                            @endif

                        </div>
                    </div>

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" onclick="showSection('produit')">Produit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showSection('reviser')">Reviser</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showSection('merch')">Merch</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showSection('transit')">Transit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showSection('magasin')">Magasin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showSection('reclamation')">Reclamation</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showSection('compta')">Compta</a>
                        </li>
                    </ul>

                    <!-- Sections de contenu -->
                    <div id="produit" class="content-section active">
                        <h3>Produit</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Designation</th>
                                    <th>Modele</th>
                                    <th>Couleur</th>
                                    @if ($produit[0]->idtypebc == 1)
                                        <th>Taille Laize</th>
                                    @endif
                                    @if ($produit[0]->idtypebc == 2)
                                        <th>Utilisation</th>
                                    @endif
                                    <th>Quantite</th>
                                    <th>Unite</th>
                                    <th>Prix Unite</th>
                                    <th>Devise</th>
                                    <th>Prix Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produit as $p)
                                    <tr>
                                        @if ($p->idtypebc == 1)
                                            <td>{{ $p->designation }}/{{ $p->ref_tissus }}/{{ $p->composition_tissus }}
                                            </td>
                                        @endif
                                        @if ($p->idtypebc == 2)
                                            <td>{{ $p->designation }}/{{ $p->ref_accessoire }}</td>
                                        @endif
                                        <td>{{ $p->nom_modele }}</td>
                                        <td>{{ $p->couleur }}</td>
                                        @if ($p->idtypebc == 1)
                                            <td>{{ $p->laize }}</td>
                                        @endif
                                        @if ($p->idtypebc == 2)
                                            <td>{{ $p->utilisation }}</td>
                                        @endif
                                        <td>{{ $p->quantite }}</td>
                                        <td>{{ $p->unite }}</td>
                                        <td>{{ $p->prix_unitaire }}</td>
                                        <td>{{ $p->devise }}</td>
                                        <td>{{ $p->prix_total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div id="reviser" class="content-section">
                        <h3>Reviser</h3>
                        <table class="table table-bordered" style="margin-left: -100px;">
                            <thead>
                                <tr>
                                    <th>Designation</th>
                                    <th>Modele</th>
                                    <th>Couleur</th>
                                    @if ($produit[0]->idtypebc == 1)
                                        <th>Taille Laize</th>
                                    @endif
                                    @if ($produit[0]->idtypebc == 2)
                                        <th>Utilisation</th>
                                    @endif
                                    <th>Quantite</th>
                                    <th>Unite</th>
                                    <th>Prix Unite</th>
                                    <th>Devise</th>
                                    <th>Prix Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produit as $p)
                                    <form action="{{ route('CRM.revisiterBc') }}" method="post">
                                        @csrf
                                        <tr>
                                            @if ($p->idtypebc == 1)
                                                <td>
                                                    <div class="inline-flex-container">
                                                        <input type="text" name="designation" style="width:50px;"
                                                            value="{{ $p->designation }}" class="td-input">
                                                        /
                                                        <input type="text" name="ref_tissus" style="width:50px;"
                                                            value="{{ $p->ref_tissus }}" class="td-input" readonly>
                                                        /
                                                        <input type="text" name="composition_tissus"
                                                            value="{{ $p->composition_tissus }}" class="td-input" readonly>
                                                    </div>
                                                </td>
                                            @endif
                                            @if ($p->idtypebc == 2)
                                                <td>
                                                    <div class="inline-flex-container">
                                                        <input type="text" name="designation" style="width:50px;"
                                                            value="{{ $p->designation }}" class="td-input">
                                                        /
                                                        <input type="text" name="ref_accessoire" style="width:50px;"
                                                            value="{{ $p->ref_accessoire }}" class="td-input" readonly>
                                                    </div>
                                                </td>
                                            @endif
                                            <td>{{ $p->nom_modele }}</td>
                                            <td><input type="text" name="couleur" style="width: 70px;" value="{{ $p->couleur }}"
                                                    class="td-input"></td>
                                            @if ($p->idtypebc == 1)
                                                <td><input type="text" name="laize" style="width: 50px;" value="{{ $p->laize }}"
                                                        class="td-input"></td>
                                            @endif
                                            @if ($p->idtypebc == 2)
                                                <td><input type="text" style="width: 90px;" name="utilisation"
                                                        value="{{ $p->utilisation }}" class="td-input"></td>
                                            @endif
                                            <td><input type="text" name="quantite" style="width: 30px;" value="{{ $p->quantite }}"
                                                    class="td-input"></td>
                                            <td><input type="text" name="unite" style="width: 30px;" value="{{ $p->unite }}"
                                                    class="td-input"></td>
                                            <td><input type="text"  style="width: 80px;" name="prix_unitaire"
                                                    value="{{ $p->prix_unitaire }}" class="td-input"></td>
                                            <td><input type="text" name="devise" style="width: 70px;" value="{{ $p->devise }}"
                                                    class="td-input"></td>
                                            <td>{{ $p->prix_total }}</td>
                                            <input type="hidden" name="idbc" value="{{ $p->id_donne_bc }}">
                                            <input type="hidden" name="idtier" value="{{ $p->id_tiers }}">
                                            <input type="hidden" name="numero" value="{{ $p->numerobc }}">
                                            <input type="hidden" name="idtypebc" value="{{ $p->idtypebc }}">
                                            <input type="hidden" name="prixunitaire" value="{{ $prix_unitaire }}">
                                            <td><button type="submit" class="btn btn-warning">Modifier</button></td>
                                        </tr>
                                    </form>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div id="merch" class="content-section">
                        <h3>Merch</h3>
                        <form action="{{ route('CRM.merch') }}" method="post">
                            @csrf
                            @if(count($merch)>0)
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="date1">Date Ex-Usine Fournisseur</label>
                                    <input type="date" class="form-control" id="date1" name="dateex" value="{{ $merch[0]->dateex }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="date2">Deadline Arrivee Usine</label>
                                    <input type="date" class="form-control" id="date2" name="echeance" value="{{ $merch[0]->deadline }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="modeTransport">Mode de Transport</label>
                                    <input type="text" class="form-control" id="modeTransport" value="{{ $merch[0]->transport }}"
                                        name="modeTransport">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="dateFacture">Date Emmission Facture</label>
                                    <input type="date" class="form-control" id="dateFacture" name="dateFacture" value="{{ $merch[0]->dateemmission }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="numeroFacture">Numéro de Facture</label>
                                    <input type="text" class="form-control" id="numeroFacture" value="{{ $merch[0]->numerofacture }}"
                                        name="numeroFacture">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="montantFacture">Montant de la Facture</label>
                                    <input type="text" class="form-control" id="montantFacture" value="{{ $merch[0]->montant }}"
                                        name="montantFacture">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="detailsFacture">Détails de la Facture</label>
                                    <textarea class="form-control" id="detailsFacture" name="detailsFacture" rows="3">{{ $merch[0]->detailfacture }}</textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="commentaireFacturation">Commentaire</label>
                                    <textarea class="form-control" id="commentaireFacturation" name="commentaireFacturation" rows="3">{{ $merch[0]->commentaire }}</textarea>
                                </div>
                            </div>
                            @else
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="date1">Date Ex-Usine Fournisseur</label>
                                    <input type="date" class="form-control" id="date1" name="dateex">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="date2">Deadline Arrivee Usine</label>
                                    <input type="date" class="form-control" id="date2" name="echeance" value="{{ $produit[0]->echeance }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="modeTransport">Mode de Transport</label>
                                    <input type="text" class="form-control" id="modeTransport"
                                        name="modeTransport">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="dateFacture">Date Emmission Facture</label>
                                    <input type="date" class="form-control" id="dateFacture" name="dateFacture">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="numeroFacture">Numéro de Facture</label>
                                    <input type="text" class="form-control" id="numeroFacture"
                                        name="numeroFacture">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="montantFacture">Montant de la Facture</label>
                                    <input type="text" class="form-control" id="montantFacture"
                                        name="montantFacture">
                                </div>
                            </div>

                            <div class="form-row">


                                <div class="form-group col-md-6">
                                    <label for="detailsFacture">Détails de la Facture</label>
                                    <textarea class="form-control" id="detailsFacture" name="detailsFacture" rows="3"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="commentaireFacturation">Commentaire</label>
                                    <textarea class="form-control" id="commentaireFacturation" name="commentaireFacturation" rows="3"></textarea>
                                </div>
                            </div>
                            @endif
                            <input type="hidden" name="idbc" value="{{ $p->id_donne_bc }}">
                            <input type="hidden" name="idtypebc" value="{{ $p->idtypebc }}">
                            <input type="hidden" name="idtier" value="{{ $p->id_tiers }}">
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </form>
                    </div>

                    <div id="transit" class="content-section">
                        <h3>Transit</h3>
                        <form action="{{ route('CRM.transit') }}" method="post">
                            @csrf
                            @if(count($transite)>0)
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="trans">Transit</label>
                                    <input type="text" class="form-control" id="trans" name="Transit" value="{{ $transite[0]->transit }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="transTime">Transit Time</label>
                                    <input type="text" class="form-control" id="transTime" name="TransitTime" value="{{ $transite[0]->transittime }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="dateDepart">Date de Depart</label>
                                    <input type="date" class="form-control" id="dateDepart" name="dateDepart" value="{{ $transite[0]->datedepart }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dateArrive">Date d'Arrive Import Prevu</label>
                                    <input type="date" class="form-control" id="dateArrive" name="dateArrive" value="{{ $transite[0]->datearrive }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="awb">AWB/BL</label>
                                    <input type="text" class="form-control" id="awb" name="awb" value="{{ $transite[0]->awb }}">
                                </div>
                            </div>
                            @else
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="trans">Transit</label>
                                    <input type="text" class="form-control" id="trans" name="Transit">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="transTime">Transit Time</label>
                                    <input type="text" class="form-control" id="transTime" name="TransitTime">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="dateDepart">Date de Depart</label>
                                    <input type="date" class="form-control" id="dateDepart" name="dateDepart">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dateArrive">Date d'Arrive Import Prevu</label>
                                    <input type="date" class="form-control" id="dateArrive" name="dateArrive">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="awb">AWB/BL</label>
                                    <input type="text" class="form-control" id="awb" name="awb">
                                </div>
                            </div>
                            @endif

                            <input type="hidden" name="idbc" value="{{ $p->id_donne_bc }}">
                            <input type="hidden" name="idtypebc" value="{{ $p->idtypebc }}">
                            <input type="hidden" name="idtier" value="{{ $p->id_tiers }}">
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </form>

                    </div>

                    <div id="magasin" class="content-section">
                        <h3>Magasin</h3>
                        <form action="{{ route('CRM.magasin') }}" method="post">
                            @csrf
                            @if(count($magasin)>0)
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="dateArrive">Date D'arrive Reelle Usine</label>
                                    <input type="date" class="form-control" id="dateArrive" name="Transit" value="{{ $magasin[0]->datearrivereelle }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="bl">BL N°</label>
                                    <input type="text" class="form-control" id="bl" name="bl" value="{{ $magasin[0]->bl }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="quantite">Quantite livree</label>
                                    <input type="text" class="form-control" id="quantite" name="quantite" value="{{ $magasin[0]->quantite }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="reste">Reste a livree</label>
                                    <input type="text" class="form-control" id="reste" name="reste" value="{{ $magasin[0]->reste }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="facture">N° Facture</label>
                                    <input type="text" class="form-control" id="facture" name="facture" value="{{ $magasin[0]->numero }}">
                                </div>
                            </div>
                            @else
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="dateArrive">Date D'arrive Reelle Usine</label>
                                    <input type="date" class="form-control" id="dateArrive" name="Transit">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="bl">BL N°</label>
                                    <input type="text" class="form-control" id="bl" name="bl">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="quantite">Quantite livree</label>
                                    <input type="text" class="form-control" id="quantite" name="quantite">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="reste">Reste a livree</label>
                                    <input type="text" class="form-control" id="reste" name="reste">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="facture">N° Facture</label>
                                    <input type="text" class="form-control" id="facture" name="facture">
                                </div>
                            </div>
                            @endif

                            <input type="hidden" name="idbc" value="{{ $p->id_donne_bc }}">
                            <input type="hidden" name="idtypebc" value="{{ $p->idtypebc }}">
                            <input type="hidden" name="idtier" value="{{ $p->id_tiers }}">
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </form>
                    </div>

                    <div id="reclamation" class="content-section">
                        <h3>Reclamation</h3>
                        <form action="{{ route('CRM.reclamation') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @if(count($reclamation)>0)
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="date1">Date Envoie Reclamation</label>
                                    <input type="date" class="form-control" id="date1" name="date1" value="{{ $reclamation[0]->dateenvoie }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="date2">Date Relance</label>
                                    <input type="date" class="form-control" id="date2" name="date2" value="{{ $reclamation[0]->daterelance }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="modeTransport">Raison de Reclamation</label>
                                    <input type="text" class="form-control" id="modeTransport" name="raison" value="{{ $reclamation[0]->raison }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="dateFacture">Quantite Concernée</label>
                                    <input type="text" class="form-control" id="dateFacture" name="dateFacture" value="{{ $reclamation[0]->quantite }}" oninput="validateInput(this)">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="numeroFacture">Defaut/Remarque</label>
                                    <input type="text" class="form-control" id="numeroFacture" value="{{ $reclamation[0]->remarque }}"
                                        name="numeroFacture">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="montantFacture">Retour Fournisseur</label>
                                    <input type="text" class="form-control" id="montantFacture" value="{{ $reclamation[0]->retour }}"
                                        name="montantFacture">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="detailsFacture">Recompensation</label>
                                    <input type="text" class="form-control" id="detailsFacture" value="{{ $reclamation[0]->recompensation }}"
                                        name="detailsFacture" oninput="validateInput(this)" />
                                </div>
                                <div class="form-group col-md-4" style="margin-top: -6px;">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label" >Unité </label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control"  name="unite" required>
                                                <option value="{{ $reclamation[0]->unite }}">{{ $reclamation[0]->unite }}</option>
                                                <option value="Unite">Unite</option>
                                                <option value="Prix">Prix</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="commentaireFacturation">Note de Crédit</label>
                                    <input type="text" class="form-control" id="commentaireFacturation" value="{{ $reclamation[0]->note }}"
                                        name="commentaireFacturation" rows="3">
                                </div>
                            </div>
                            <div class="form-row" style="margin-top: -5px;margin-left:2px;">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Rapport d'inspection</label>
                                    </div>
                                    <div class="custom-file" style=" border: 1px solid #b5b5b5;">
                                        <input type="file" class="custom-file-input" id="fileInput" name="logo" value="{{ $reclamation[0]->rapport }}">
                                        <label class="custom-file-label">Choisissez un fichier</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            @else
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="date1">Date Envoie Reclamation</label>
                                    <input type="date" class="form-control" id="date1" name="date1">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="date2">Date Relance</label>
                                    <input type="date" class="form-control" id="date2" name="date2">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="modeTransport">Raison de Reclamation</label>
                                    <input type="text" class="form-control" id="modeTransport" name="raison">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="dateFacture">Quantite Concernée</label>
                                    <input type="text" class="form-control" id="dateFacture" name="dateFacture" oninput="validateInput(this)">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="numeroFacture">Defaut/Remarque</label>
                                    <input type="text" class="form-control" id="numeroFacture"
                                        name="numeroFacture">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="montantFacture">Retour Fournisseur</label>
                                    <input type="text" class="form-control" id="montantFacture"
                                        name="montantFacture">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="detailsFacture">Recompensation</label>
                                    <input type="text" class="form-control" id="detailsFacture"
                                        name="detailsFacture" oninput="validateInput(this)" />
                                </div>
                                <div class="form-group col-md-4" style="margin-top: -6px;">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label" >Unité </label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control"  name="unite" required>
                                                <option value="Unite">Unite</option>
                                                <option value="Prix">Prix</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="commentaireFacturation">Note de Crédit</label>
                                    <input type="text" class="form-control" id="commentaireFacturation"
                                        name="commentaireFacturation" rows="3">
                                </div>
                            </div>
                            <div class="form-row" style="margin-top: -5px;margin-left:2px;">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Rapport d'inspection</label>
                                    </div>
                                    <div class="custom-file" style=" border: 1px solid #b5b5b5;">
                                        <input type="file" class="custom-file-input" id="fileInput" name="logo">
                                        <label class="custom-file-label">Choisissez un fichier</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            @endif

                            <input type="hidden" name="idbc" value="{{ $p->id_donne_bc }}">
                            <input type="hidden" name="idtypebc" value="{{ $p->idtypebc }}">
                            <input type="hidden" name="prixunitaire" value="{{ $prix_unitaire }}">
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                            <a href="{{ route('CRM.detailreclamation', ['iddonnebc' => $p->id_donne_bc]) }}" class="btn btn-info" style="margin-left: 10px;">Détails</a>
                        </form>
                    </div>

                    <div id="compta" class="content-section">
                        <h3>Compta</h3>
                        <form action="{{ route('CRM.comptabilite') }}" method="post">
                            @csrf
                            @if(count($compta)>0)
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="dateArrive">Swift (Date)</label>
                                    <input type="date" class="form-control" id="dateArrive" name="Transit" value="{{ $compta[0]->swift }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="bl">Deposit (Formule(30%))</label>
                                    <input type="text" class="form-control" id="bl" name="bl" value="{{ $compta[0]->deposit }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="quantite">Pri BC</label>
                                    <input type="text" class="form-control" id="quantite" name="quantite" value="{{ $compta[0]->pri }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="facture">% Payer</label>
                                    <input type="text" class="form-control" id="facture" name="facture" value="{{ $compta[0]->payer*100 }}%" readonly>
                                </div>
                            </div>
                            @else
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="dateArrive">Swift (Date)</label>
                                    <input type="date" class="form-control" id="dateArrive" name="Transit">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="bl">Deposit (Formule(30%))</label>
                                    <input type="text" class="form-control" id="bl" name="bl">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="quantite">Pri BC</label>
                                    <input type="text" class="form-control" id="quantite" name="quantite" value="{{ $produit[0]->prix_total }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="facture">% Payer</label>
                                    <input type="text" class="form-control" id="facture" name="facture" readonly>
                                </div>
                            </div>
                            @endif

                            <input type="hidden" name="idbc" value="{{ $p->id_donne_bc }}">
                            <input type="hidden" name="idtypebc" value="{{ $p->idtypebc }}">
                            <input type="hidden" name="idtier" value="{{ $p->id_tiers }}">
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </form>
                    </div>
                </div>
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
    document.querySelectorAll('.auto-width').forEach(function(input) {
        // Fonction pour ajuster la largeur de l'input en fonction du texte
        function resizeInput() {
            input.style.width = '50px'; // Taille de base
            input.style.width = (input.scrollWidth + 2) + 'px'; // Ajuste en fonction du contenu
        }

        // Redimensionne l'input au chargement initial et à chaque changement
        resizeInput();
        input.addEventListener('input', resizeInput);
    });
</script>

<script>
    function validateInput(input) {
        // Autoriser uniquement les chiffres et un point décimal
        input.value = input.value.replace(/[^0-9.]/g, '');

        // Assurer qu'il n'y a qu'un seul point décimal
        if ((input.value.match(/\./g) || []).length > 1) {
            input.value = input.value.substring(0, input.value.lastIndexOf('.'));
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var fileInput = document.getElementById('fileInput');
    var fileLabel = fileInput.nextElementSibling;

    fileInput.addEventListener('change', function () {
        var fileName = this.files[0] ? this.files[0].name : 'Choose file';
        fileLabel.textContent = fileName;
        });
    });
</script>
@include('CRM.footer')
