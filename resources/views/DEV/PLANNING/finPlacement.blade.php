@include('CRM.header')
@include('CRM.sidebar')
<title>FinPlacement</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .card {
        color: black;
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('DEV.headerDEV')
        <div class="row">
            <div class="card col-12">
                <div class="mb-5">
                    <div class="justify-content-center align-items-center entete">
                        <h3 class="entete mt-3">FIN PLACEMENT </h3>

                    </div>
                    <form action="{{ route('DEV.acheverPlacement') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="row  mt-3">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Type placement </label>
                                    </div>
                                    <div class="col-12">
                                        <select class="form-control" name="idTypePlacement" required>
                                            @foreach ($typePlacement as $type)
                                                <option value="{{ $type->id }}">{{ $type->typeplacement }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="table-responsive" style="margin-top: -15px;">
                                <table class="table student-data-table m-t-20 mt-3" style="color: black">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Tissus</th>
                                            <th>Conso</th>
                                            <th>Efficience</th>
                                            <th>Nombre marker</th>
                                            <th>Laize utile</th>
                                            <th>Taux recoupe</th>
                                            <th>Commentaire</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i=0; $i<count($tissus); $i++)
                                            <tr>
                                                <td> <input type="checkbox" name="placement[]" value="{{ $i }}"></td>
                                                <td><input type="hidden" class="form-control" name="tissu{{ $i }}" value="{{ $tissus[$i]->id }}">{{ $tissus[$i]->type_tissus }}</td>
                                                <td><input type="text" class="form-control" value="0" name="conso{{ $i }}"></td>
                                                <td><input type="text" class="form-control" value="0" name="efficience{{ $i }}"></td>
                                                <td><input type="text" class="form-control"  value="0" name="nbMarker{{ $i }}"></td>
                                                <td><input type="text" class="form-control" value="0" name="laize{{ $i }}"></td>
                                                <td><input type="text" class="form-control" value="0" name="tauxRecoupe{{ $i }}"></td>
                                                <td><input type="text" class="form-control" name="commentaire{{ $i }}"></td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row no-gutters">
                            <div class="col-14">
                                <label class="col-form-label texte">Choix etape suivante</label>
                            </div>
                            <div class="col-4">
                                <select class="form-control" name="etapeDEV" required>
                                    @for ($et = 0; $et < count($etapeDev); $et++)
                                        <option value="{{ $etapeDev[$et]->id }}">{{ $etapeDev[$et]->etape }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>



                        <input type="hidden" name="idSuiviConso" value="{{ $idSuiviConso }}">
                        <input type="hidden" name="idSuiviPlaceur" value="{{ $idSuiviPlaceur }}">
                        <input type="hidden" name="nombreLigne" value="{{ count($tissus) }}">
                        <input type="hidden" name="idDCSDCEtapeDev" value="{{ $idDCSDCEtapeDev }}">
                        <input type="hidden" name="idDCSDCEtapeDevRecent" value="{{ $idDCSDCEtapeDevRecent }}">
                        <input type="hidden" name="idDemande" value="{{ $idDemande }}">
                        <div class="form-group row mt-4">
                            <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                <a href="{{ route('DEV.planningDEV') }}" class="btn btn-info mr-3">Retour</a>
                                <button type="submit" class="btn btn-success">Achever</button>

                            </div>
                    </form>
                </div>
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
