@include('CRM.header')
@include('CRM.sidebar')
@include('COMPLIANCE.STYLE.styleRapportAuditInterne')
<title>Rapport Audit Interne</title>
<div class="content-body">
    <div class="container-fluid">
        @include('COMPLIANCE.headerCompliance')
        <div class="row">
            <div class="card col-lg-12">
                <div class="card-header">
                    <h4 class="card-title">RAPPORT AUDIT INTERNE</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('AUDITINTERNE.Rapport') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="col-lg">
                                <label>Mois/Annee</label>
                                <input class="form-control" type="month" name="mois_annee" value="{{ request('mois_annee') }}">
                            </div>
                            <div class="col-lg d-flex align-items-end">
                                <button type="submit" class="btn btn-success">Filtrer</button>
                            </div>
                        </div>
                    </form>
                    <div class=>
                    <div class="row align-items-center">
                        <div class="col-auto text-center">
                            <img src="./images/NEW LOGO.png" class="img-loi" alt="Logo">
                        </div>
                        <div class="col text-right">
                            <h4 class="font-weight-bold">Rapport Audit Interne</h4>
                            <p class="mb-1"><strong>Début Constat :</strong> <span id="dateDebut"></span></p>
                            <p class="mb-1"><strong>Fin Constat :</strong> <span id="dateFin"></span></p>
                        </div>
                    </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Detection</th>
                                    <th>Section</th>
                                    <th>Constat</th>
                                    <th>Moyens</th>
                                    <th>Priorité</th>
                                    <th>Deadline</th>
                                    <th>Avancement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($audits as $audit)
                                    <tr>
                                        <td>{{ $audit->id }}</td>
                                        <td>{{ $audit->date_detection }}</td>
                                        <td>{{ $audit->section }}</td>
                                        <td>{{ $audit->constat }}</td>
                                        <td>{{ $audit->action }}</td>
                                        <td>{{ $audit->priorite }}</td>
                                        <td>{{ $audit->deadline }}</td>
                                        <td>{{ $audit->avancement }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('CRM.footer')