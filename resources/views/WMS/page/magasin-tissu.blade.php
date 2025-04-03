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
        width: 20px;
        /* Largeur du cercle */
        height: 20px;
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

    .dropdown-item {
        padding: 10px 20px;
        /* Adjust as needed */
        font-size: 16px;
        /* Modify for better readability */
    }

    label {
        color: black;
        font-size: 12px;
    }
</style>
<div class="content-body">

    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card">
            <section class="py-5">
                <div class="container py-5">
                    <div class="row mb-5">
                        <div class="col-md-8 col-xl-6 text-center mx-auto">
                            <h2 class="fw-bold">MAGASIN TISSU</h2>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 mx-auto" style="max-width: 900px;">
                        <div class="col mb-4">
                            <div>
                                <img class="rounded img-fluid w-100 fit-cover"
                                    src="{{ asset('images/chaineTrame.jpeg') }}" style="height: 250px;">
                                <div class="py-4">
                                    <h4 class="fw-bold">CHAINE ET TRAME</h4>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Voir +
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.tissu-entree-accueil', ['idFamilleTissu' => 1]) }}">Entrée</a>
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.tissu-stock', ['idFamilleTissu' => 1]) }}">Stock</a>
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.tissu-sortie-accueil', ['idFamilleTissu' => 1]) }}">Sortie</a>
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.retour-tissu-historique', ['idFamilleTissu' => 1]) }}">Retour</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div>
                                <img class="rounded img-fluid w-100 fit-cover" src="{{ asset('images/maille.jpeg') }}"
                                    style="height: 250px;">
                                <div class="py-4">
                                    <h4 class="fw-bold">MAILLE</h4>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Voir +
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.tissu-entree-accueil', ['idFamilleTissu' => 2]) }}">Entrée</a>
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.tissu-stock', ['idFamilleTissu' => 2]) }}">Stock</a>
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.tissu-sortie-accueil', ['idFamilleTissu' => 2]) }}">Sortie</a>
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.retour-tissu-historique', ['idFamilleTissu' => 2]) }}">Retour</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div>
                                <img class="rounded img-fluid w-100 fit-cover" src="{{ asset('images/ouate.jpeg') }}"
                                    style="height: 250px;">
                                <div class="py-4">
                                    <h4 class="fw-bold">OUATE</h4>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Voir +
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.tissu-entree-accueil', ['idFamilleTissu' => 3]) }}">Entrée</a>
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.tissu-stock', ['idFamilleTissu' => 3]) }}">Stock</a>
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.tissu-sortie-accueil', ['idFamilleTissu' => 3]) }}">Sortie</a>
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.retour-tissu-historique', ['idFamilleTissu' => 3]) }}">Retour</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- TODO: A FAIRE --}}
                        <div class="col mb-4">
                            <div>
                                <img class="rounded img-fluid w-100 fit-cover"
                                    src="{{ asset('images/consommable.jpeg') }}" style="height: 250px;">
                                <div class="py-4">
                                    <h4 class="fw-bold">CONSOMMABLE</h4>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Voir +
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.page-accueil-entree-wms', ['idtypewms' => 6]) }}">Entrée</a>
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.page-stock-wms', ['idtypewms' => 6]) }}">Stock</a>
                                            <a class="dropdown-item"
                                                href="{{ route('WMS.page-accueil-sortie-wms', ['idtypewms' => 6]) }}">Sortie</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-12">
            <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                <div class="card-header text-center" style="display: flex; justify-content: center;">
                    <h3 class="entete">TABLEAU DE SUIVIS DES TISSUS</h3>
                </div>
                <div class="card-body" style="margin-top: -15px;overflow: auto;">
                    <form action="{{ route('CRM.nouvelleBc') }}" method="get">
                        @csrf
                        <div class="recherche" style="display: flex; align-items: center;">
                            <div class="col-auto my-1">
                                <label class="mr-sm-2" for="inlineFormCustomSelect">Etat BC</label>
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="idetatbc">
                                    <option selected>Choisissez un Etat...</option>
                                    @foreach ($etat as $e)
                                        <option value="{{ $e->id }}">{{ $e->etatbc }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto my-1">
                                <label class="mr-sm-2" for="inlineFormInput">Date Emmission</label>
                                <div class="input-group" id="date-range">
                                    <input type="date" class="form-control" name="startEmmission">
                                    <span class="input-group-addon b-0 text-white"
                                        style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                    <input type="date" class="form-control" name="endEmmission">
                                </div>
                            </div>
                            <div class="col-auto my-1">
                                <label class="mr-sm-2" for="inlineFormInput">Deadline</label>
                                <div class="input-group" id="date-range">
                                    <input type="date" class="form-control" name="startDeadline">
                                    <span class="input-group-addon b-0 text-white"
                                        style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                    <input type="date" class="form-control" name="endDeadline">
                                </div>
                            </div>
                            <div class="col-auto my-1" style="flex-grow: 1;">
                                <label class="mr-sm-2" for="inlineFormInput">Search</label>
                                <input type="text" class="form-control mr-sm-2" id="inlineFormInput"
                                    placeholder="Entrer un preference" name="search">
                            </div>
                            <div class="col-auto my-1" style="flex-grow: 1;">
                                <label class="mr-sm-2" for="inlineFormInput"
                                    style="color: transparent;">Search</label>
                                <input type="submit" style="background-color: rgb(51, 208, 51);"
                                    class="form-control mr-sm-2" id="inlineFormInput" value="Filtrer">
                            </div>
                        </div>
                    </form>
                    <br>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Code</th>
                                <th scope="col">DATE EMISSION</th>
                                <th scope="col">SAISON</th>
                                <th scope="col">CLIENT</th>
                                <th scope="col">BC NUM</th>
                                <th scope="col">FOURNISSEUR</th>
                                <th scope="col">ARTICLES</th>
                                <th scope="col">TAILLE/LAIZE</th>
                                <th scope="col">COULEUR</th>
                                <th scope="col">QUANTITE</th>
                                <th scope="col">PRIX TOTAL</th>
                                <th scope="col">DEADLINE ARRIV</th>
                                <th scope="col">NOUVELLE ENTREE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($donne as $d)
                                <tr style="color: rgb(77, 77, 77)">
                                    <td>
                                        <div class="code">
                                            @if ($d->magasin_quantite == 0)
                                                <div class="circle"
                                                    style="background-color: rgb(255, 255, 255);font-size: 12px;color:black;">
                                                    L</div>
                                            @elseif($d->magasin_quantite != 0 && $d->reste == 0)
                                                <div class="circle"
                                                    style="background-color: rgb(6, 255, 6);font-size: 12px;color:black;">
                                                    L</div>
                                            @elseif($d->magasin_quantite != 0 && $d->reste != 0)
                                                <div class="circle"
                                                    style="background-color: rgb(18, 252, 252);font-size: 12px;color:black;">
                                                    L</div>
                                            @endif

                                            @if (($d->datearrive != 0 && $d->datearrive < $today) || ($d->datearrive == 0 && $d->echeance < $today))
                                                <div class="circle"
                                                    style="background-color: red;color: white;font-size: 12px;">R</div>
                                            @else
                                                <div class="circle"
                                                    style="background: white;color: black;font-size: 12px;">R</div>
                                            @endif
                                            @if ($d->raison == 0)
                                                <div class="circle"
                                                    style="background: white;color: black;font-size: 12px;">Rc</div>
                                            @else
                                                <div class="circle"
                                                    style="background: yellow;color: black;font-size: 12px;">Rc</div>
                                            @endif

                                            @if ($d->deposit == 0)
                                                <div class="circle"
                                                    style="background: rgb(255, 255, 255);color: black;font-size: 12px;">
                                                    P</div>
                                            @elseif($d->payer >= 1)
                                                <div class="circle"
                                                    style="background: rgb(6, 255, 6);color: black;font-size: 12px;">P
                                                </div>
                                            @else
                                                <div class="circle"
                                                    style="background: purple;color: white;font-size: 12px;">P</div>
                                            @endif

                                        </div>
                                    </td>
                                    <td>{{ \App\Models\WMSModel\FormatDate::formatFR($d->date_bc) }}
                                    </td>
                                    {{-- <td>{{ $d->nom_modele }}</td> --}}
                                    {{-- <td>{{ $d->type_bc }}</td> --}}
                                    <td>{{ $d->type_saison }}</td>
                                    <td>{{ $d->client }}</td>
                                    <td>{{ $d->numerobc }}</td>
                                    <td>{{ $d->fournisseur }}</td>
                                    @if ($d->idtypebc == 1)
                                        <td>{{ $d->designation }}/{{ $d->ref_tissus }}/{{ $d->composition_tissus }}
                                        </td>
                                    @endif
                                    @if ($d->idtypebc == 2)
                                        <td>{{ $d->designation }}/{{ $d->ref_accessoire }}</td>
                                    @endif
                                    @if ($d->idtypebc == 1)
                                        <td>{{ $d->laize }}</td>
                                    @endif
                                    @if ($d->idtypebc == 2)
                                        <td></td>
                                    @endif
                                    <td>{{ $d->couleur }}</td>
                                    <td>{{ $d->quantite }}</td>
                                    <td>{{ $d->prix_total }}</td>
                                    @if ($d->deadline == 0)
                                        <td>{{ \App\Models\WMSModel\FormatDate::formatFR($d->echeance) }}</td>
                                    @else
                                        <td>{{ \App\Models\WMSModel\FormatDate::formatFR($d->deadline) }}</td>
                                    @endif
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButtonEntree" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                Nouvelle entrées
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonEntree">

                                                @foreach ($familleTissu as $familleTissus)
                                                    <a class="dropdown-item"
                                                        href="{{ route('WMS.ajout-entree-tissu-par-bc', ['iddonnebc' => $d->id_donne_bc, 'idfamilletissu' => $familleTissus->id]) }}">{{ $familleTissus->famille_tissus }}</a>
                                                @endforeach
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('CRM.footer')
