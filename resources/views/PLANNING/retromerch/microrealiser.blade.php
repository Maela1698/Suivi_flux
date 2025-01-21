@include('CRM.header')
@include('CRM.sidebar')
<!--**********************************
            Content body start
        ***********************************-->
<style>
    .highlight-border {
        border-top: 5px solid rgb(0, 72, 255);
        /* Ajoutez la couleur et l'épaisseur souhaitées */
    }

    .entete {

        color: #7571f9;
        /* Ajuster la couleur du texte si n�cessaire */
    }

    .card-small {
        height: 110px;
        /* Ajustez cette valeur selon vos besoins */
        padding: 10px;
    }

    .card-small .card-title {
        font-size: 1.3rem;
        /* Taille de la police du titre */
    }

    .card-small h2 {
        font-size: 2rem;
        /* Taille de la police du chiffre */
    }

    .card-small .display-5 {
        font-size: 2.2rem;
        /* Taille de l'ic�ne */
        opacity: 0.5;
        /* Garder l'opacit� comme avant */
    }


    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        max-height: 300px;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 1050;
    }

    .texte {
        color: black;
    }

    .content-body {
        background: linear-gradient(to bottom, #66ccff, #d4a373);
    }
</style>

<style>
    .table th {
        color: #000000;
        /* Couleur noire intense */
        font-weight: bold;
        /* Optionnel : Rend le texte plus épais */
    }

    .table td {
        color: rgb(83, 83, 83);
        /* Couleur noire intense */
        font-weight: bold;
        /* Optionnel : Rend le texte plus épais */
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('PLANNING.headerPlan')
        <div class="col-lg-12">
            <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                <div class="card-header text-center" style="display: flex; justify-content: space-between;">
                    <h3 class="entete">MICRO REALISER</h3>
                </div>
                <div class="card-body" style="margin-top: -15px;">
                    <form action="{{ route('PLANNING.microrealiser') }}">
                        @csrf
                        <div class="row">
                            <div class="col-auto my-1">
                                <label class="mr-sm-2" for="inlineFormInput"
                                    style="color: rgb(82, 82, 82);">Semaine</label>
                                <div class="input-group" id="date-range">
                                    <input type="number" class="form-control" style="width: 70px;" placeholder="S:"
                                        name="startsemaine">
                                    <span class="input-group-addon b-0 text-white"
                                        style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                    <input type="number" class="form-control" style="width: 70px;" placeholder="S:"
                                        name="endsemaine">
                                </div>
                            </div>
                            <div class="col-auto my-1" style="flex-grow: 1;">
                                <label class="mr-sm-2" for="inlineFormInput"
                                    style="color: rgb(82, 82, 82);">Année</label>
                                <input type="number" style="width: 100px;" class="form-control mr-sm-2"
                                    id="inlineFormInput" placeholder="Année" name="annee" value="{{ date('Y') }}">
                            </div>
                            <div class="col-auto my-1">
                                <label class="mr-sm-2" for="inlineFormInput"
                                    style="color: rgb(82, 82, 82);">Deadline</label>
                                <div class="input-group" id="date-range">
                                    <input type="date" class="form-control" name="startdeadline">
                                    <span class="input-group-addon b-0 text-white"
                                        style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                    <input type="date" class="form-control" name="enddeadline">
                                </div>
                            </div>
                            <div class="col-auto my-1">
                                <label class="mr-sm-2" for="inlineFormInput" style="color: rgb(82, 82, 82);">Date de
                                    Réalisation</label>
                                <div class="input-group" id="date-range">
                                    <input type="date" class="form-control" name="startrealisation">
                                    <span class="input-group-addon b-0 text-white"
                                        style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                    <input type="date" class="form-control" name="endrealisation">
                                </div>
                            </div>
                            <div class="col-auto my-1" style="flex-grow: 1;">
                                <label class="mr-sm-2" for="inlineFormInput"
                                    style="color: rgb(82, 82, 82);">Search</label>
                                <input type="text" class="form-control mr-sm-2" id="inlineFormInput"
                                    placeholder="Entrer un preference" name="search">
                            </div>
                            <div class="col-auto my-1" style="flex-grow: 1;">
                                <label class="mr-sm-2" for="inlineFormInput" style="color: transparent;">Search</label>
                                <input type="submit" style="background-color: rgb(51, 208, 51);"
                                    class="form-control mr-sm-2" id="inlineFormInput" value="Filtrer">
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="table-responsive" style="margin-top: -15px;">
                        <table class="table student-data-table m-t-20">
                            <thead>
                                <tr>
                                    <th>Semaine</th>
                                    <th>Saison</th>
                                    <th>Date Réception</th>
                                    <th>Client</th>
                                    <th>Modèle</th>
                                    <th>Thème</th>
                                    <th>Style</th>
                                    <th>Qte à Monter</th>
                                    <th>Etape à Effectuée</th>
                                    <th>Deadline</th>
                                    <th>Date Réalisation</th>
                                    <th>Commentaire</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @php
                                    $previousIdDemandeClient = null;
                                @endphp
                                @foreach ($donne as $d)
                                    <tr style="cursor: pointer;background-color: rgb(144, 238, 144);"
                                        class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }}">
                                        <td>{{ $d->semaine }}</td>
                                        <td>{{ $d->type_saison }}</td>
                                        <td>{{ \Carbon\Carbon::parse($d->demande_date_entree)->format('d/m/Y') }}</td>
                                        <td>{{ $d->nomtier }}</td>
                                        <td>{{ $d->nom_modele }}</td>
                                        <td>{{ $d->theme }}</td>
                                        <td>{{ $d->nom_style }}</td>
                                        @if (!empty($d->total_qte_detailsdc))
                                            <td>{{ $d->total_qte_detailsdc }}</td>
                                        @endif
                                        @if (empty($d->total_qte_detailsdc))
                                            <td>{{ $d->etape_quantite }}</td>
                                        @endif
                                        <td>{{ $d->etape_designation }}/{{ $d->etape_stade }}</td>
                                        <td>{{ \Carbon\Carbon::parse($d->datecalcul)->format('d/m/Y') }}</td>
                                        <td>{{ !empty($d->micro_realisation) ? \Carbon\Carbon::parse($d->micro_realisation)->format('d/m/y') : '' }}
                                        </td>
                                        <td>{{ $d->micro_commentaires }}</td>
                                    </tr>
                                    @php
                                        $previousIdDemandeClient = $d->id_demande_client;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<!--**********************************
            Content body end
        ***********************************-->

@include('CRM.footer')
