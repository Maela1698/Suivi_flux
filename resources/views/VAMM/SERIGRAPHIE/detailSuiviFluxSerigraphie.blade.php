@include('CRM.header')
@include('CRM.sidebar')
<title>ListeSuiviFlux</title>

<!--**********************************
        Content body start
***********************************-->
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
        @include('VAMM.headerVAMM')


        <div class="row">
            <div class="card col-12">

                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">DETAIL SUIVI SERIGRAPHIE</h3>
                </div>

                <div class="card-body table-responsive mt-4" style="margin-top: -15px;">
                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead>
                            <tr>
                                <th>Date Opération</th>
                                <th>Theme</th>
                                <th>Modèle</th>
                                <th>Stade</th>
                                <th>Client</th>
                                <th>Saison</th>
                                <th>Style</th>
                                <th>Type flux</th>
                                <th>Quantité</th>
                                <th>Recoupe</th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            @for ($i = 0; $i < count($suivi); $i++)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($suivi[$i]->date_operation)->format('d/m/y H:i') }}
                                    </td>
                                    <td>{{ $suivi[$i]->theme }}</td>
                                    <td>{{ $suivi[$i]->nom_modele }}</td>
                                    <td>{{ $suivi[$i]->type_stade }}</td>
                                    <td>{{ $suivi[$i]->nomtier }}</td>
                                    <td>{{ $suivi[$i]->type_saison }}</td>
                                    <td>{{ $suivi[$i]->nom_style }}</td>
                                    <td>
                                        @if ($suivi[$i]->type_flux == 1)
                                            Reception
                                        @else
                                            Livraison
                                        @endif
                                    </td>
                                    <td>{{ $suivi[$i]->qte }}</td>
                                    <td>{{ $suivi[$i]->recoupe }}</td>

                                </tr>
                            @endfor
                        </tbody>
                    </table>
                    <form action="{{ route('SERIGRAPHIE.insertDetailFluxSerigraphie') }}" method="post">
                        @csrf
                        <div class="row mt-3">
                            <div class="table-responsive mt-5">
                                <table class="table texte">
                                    <thead>
                                        <th>Taille</th>
                                        <th>Qte</th>
                                        <th>Recoupe</th>
                                    </thead>
                                    <tbody>
                                        @for ($u = 0; $u < count($detailSuivi); $u++)
                                            <tr>
                                                <td><input type="text" name="unite[]" class="form-control"
                                                        value="{{ $detailSuivi[$u]->unite_taille }}" readonly></td>
                                                <td>
                                                    <input type="number" name="qte[]"
                                                        value="{{ $detailSuivi[$u]->qte }}" class="form-control"
                                                        required>
                                                </td>
                                                <td>
                                                    <input type="number" name="recoupe[]"
                                                        value="{{ $detailSuivi[$u]->recoupe }}" class="form-control"
                                                        required>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                            @if (\Carbon\Carbon::parse($suivi[0]->date_operation)->isToday())
                                <div class="form-group row mt-3">

                                    <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                        <a href="{{ route('SERIGRAPHIE.listeSuiviFlux') }}"
                                            class="btn btn-secondary mr-3">Retour</a>
                                        <input type="hidden" name="id" value="{{ $suivi[0]->id }}">
                                        <input type="hidden" name="iddemandeSer" value="{{ $suivi[0]->id_demande_client }}">
                                        <button type="submit" class="btn btn-warning">Modifier</button>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('SERIGRAPHIE.listeSuiviFlux') }}"
                                    class="btn btn-secondary mr-3">Retour</a>
                                <p class="texte" style="font-size: 17px"><b>Vous ne pouvez plus modifier cette flux</b>
                                </p>
                            @endif

                        </div>
                    </form>
                </div>


            </div>
        </div>

    </div>
</div>


<!--**********************************
        modal start
***********************************-->




<!--**********************************
        javascript start
***********************************-->

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
