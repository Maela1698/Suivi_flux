@include('CRM.header')
@include('CRM.sidebar')
<title>AjoutBureauEtude</title>

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
                        <h3 class="entete mt-3">AJOUT BUREAU D'ETUDE </h3>

                    </div>
                    <form action="{{ route('DEV.ajoutBureauEtude') }}" method="POST">
                        @csrf
                    <div class="row  mt-3">
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label">Date debut </label>
                                </div>
                                <div class="col-12">
                                    <input type="datetime-local" name="dateDebut" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label">Type patronage </label>
                                </div>
                                <div class="col-12">
                                    <select class="form-control" name="idtypepatronage" required>
                                        @foreach ($typePatronage as $type)
                                            <option value="{{ $type->id }}">{{ $type->typepatron }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label">Patronier </label>
                                </div>
                                <div class="col-12">
                                    <select class="form-control" name="idlisteemploye" required>
                                        @foreach ($patronier as $p)
                                            <option value="{{ $p->id }}">{{ $p->nom }} {{ $p->prenom }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-4">
                            <h3>SPECIFICITE MONTAGE</h3>
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col-2">
                            <label class="col-form-label">Valeur couture </label>
                        </div>
                        <div class="col-3">
                            <input type="text" name="valeurCouture" class="form-control">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-2">
                            <label class="col-form-label">Points par cm </label>
                        </div>
                        <div class="col-3">
                            <input type="text" name="pointcm" class="form-control">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-2">
                            <label class="col-form-label">Montage devant </label>
                        </div>
                        <div class="col-3">
                            <input type="datetime" name="montagedevant" class="form-control">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-2">
                            <label class="col-form-label">Montage envers </label>
                        </div>
                        <div class="col-3">
                            <input type="datetime" name="montageenvers" class="form-control">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-2">
                            <label class="col-form-label">Maille(mtg col, relaxation) </label>
                        </div>
                        <div class="col-3">
                            <input type="text" name="maille" class="form-control">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-2">
                            <label class="col-form-label">Glissement couture</label>
                        </div>
                        <div class="col-3">
                            <input type="text" name="glissementcouture" class="form-control">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-2">
                            <label class="col-form-label">Autres </label>
                        </div>
                        <div class="col-3">
                            <input type="text" name="autres" class="form-control">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label">PRE RUN DEMANDE </label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="preRunDemande" value="1">
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label">DEMANDE DE LABDIP </label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="demandeLapdip" value="1">
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label">DEMANDE DE TAUX DE RETRAIT</label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="demandeTauxRetrait" value="1">
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label">TAUX DE MESURE </label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="tauxMesure" value="1">
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label">CONFORMITE DU DOSSIER </label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="conformiteDossier" value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="iddclientsdcetapedev" value="{{ $idDCSDCEtapeDev }}">
                    <input type="hidden" name="deadline" value="{{ $deadline }}">
                    <div class="form-group row">
                        <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                            <a href="{{ route('DEV.planningDEV') }}" class="btn btn-info mr-3">Retour</a>
                            <button type="submit" class="btn btn-success">Enregistrer</button>

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
