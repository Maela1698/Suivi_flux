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
                                <button type="button" class="btn btn-primary" id="export-pdf">Exporter</button>
                            </div>
                        </div>
                    </form>
                    <div class="card-body" id="pdfContent">
                        <div class="row align-items-center">
                            <div class="col-auto text-center">
                                <img src="./images/NEW LOGO.png" class="img-loi" alt="Logo">
                            </div>
                            <div class="col text-right">
                                <h4 class="font-weight-bold">Rapport Audit Interne</h4>
                                <p class="mb-1"><strong>Mois/Annee :</strong>{{ $mois_annee_affichage ?? '' }} <span id="dateDebut"></span></p>
                            </div>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="th-cell">ID</th>
                                        <th>Detection</th>
                                        <th>Section</th>
                                        <th>Responsable</th>
                                        <th>Constat</th>
                                        <th>Moyens</th>
                                        <th>Priorité</th>
                                        <th>Deadline</th>
                                        <th>New Deadline</th>
                                        <th>Avancement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($audits as $audit)
                                        <tr>
                                            <td class="id-cell">{{ $audit->id }}</td>
                                            <td class="id-cell">{{ $audit->date_detection }}</td>
                                            <td>{{ $audit->section }}</td>
                                            <td>{{ $audit->nom_emp ?? '-'}} {{ $audit->prenom_emp ?? '-' }}</th>
                                            <td>{{ $audit->constat }}</td>
                                            <td>{{ $audit->action }}</td>
                                            <td class="{{ $audit->priorite['classe'] }}">{{ $audit->priorite['valeur'] }}</td>
                                            <td class="id-cell">{{ $audit->deadline }}</td>
                                            <td class="id-cell">{{ $audit->new_deadline ?? '--' }}</td>
                                            <td class="{{ $audit->avancement['classe'] }}">{{ $audit->avancement['valeur'] }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-auto text-center">
                                <img src="./images/NEW LOGO.png" class="img-loi" alt="Logo">
                            </div>
                            <div class="col text-right">
                                <h4 class="font-weight-bold">Rapport Actions Resolus</h4>
                                <p class="mb-1"><strong>Mois/Annee :</strong>{{ $mois_annee_affichage ?? '' }}<span id="dateFin"></span></p>
                            </div>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="th-cell">ID</th>
                                        <th>Detection</th>
                                        <th>Section</th>
                                        <th>Responsable</th>
                                        <th>Constat</th>
                                        <th>Moyens</th>
                                        <th>Priorité</th>
                                        <th>Deadline</th>
                                        <th>New Deadline</th>
                                        <th>Realisation</th>
                                        <th>Avancement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($resolus as $audit)
                                        <tr class="faible">
                                            <td class="id-cell">{{ $audit->id }}</td>
                                            <td class="id-cell">{{ $audit->date_detection }}</td>
                                            <td>{{ $audit->section }}</td>
                                            <td>{{ $audit->nom_emp ?? '-'}} {{ $audit->prenom_emp ?? '-' }}</th>
                                            <td>{{ $audit->constat }}</td>
                                            <td>{{ $audit->action }}</td>
                                            <td>{{ $audit->priorite['valeur'] }}</td>
                                            <td class="id-cell">{{ $audit->deadline }}</td>
                                            <td class="id-cell">{{ $audit->new_deadline ?? '--' }}</td>
                                            <td class="id-cell">{{ $audit->date_realisation ?? '--' }}</td>
                                            <td>{{ $audit->avancement['valeur'] }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-auto text-center">
                                <img src="./images/NEW LOGO.png" class="img-loi" alt="Logo">
                            </div>
                            <div class="col text-right">
                                <h4 class="font-weight-bold">Reste des actions non resolus</h4>
                                <p class="mb-1"><strong>Mois/Annee :</strong>{{ $mois_annee_affichage ?? '' }} <span id="dateDebut"></span></p>
                                
                            </div>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="th-cell">ID</th>
                                        <th>Detection</th>
                                        <th>Section</th>
                                        <th>Responsable</th>
                                        <th>Constat</th>
                                        <th>Moyens</th>
                                        <th>Priorité</th>
                                        <th>Deadline</th>
                                        <th>New Deadline</th>
                                        <th>Avancement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($restes as $audit)
                                        <tr>
                                            <td class="id-cell">{{ $audit->id }}</td>
                                            <td class="id-cell">{{ $audit->date_detection }}</td>
                                            <td>{{ $audit->section }}</td>
                                            <td>{{ $audit->nom_emp ?? '-'}} {{ $audit->prenom_emp ?? '-' }}</th>
                                            <td>{{ $audit->constat }}</td>
                                            <td>{{ $audit->action }}</td>
                                            <td class="{{ $audit->priorite['classe'] }}">{{ $audit->priorite['valeur'] }}</td>
                                            <td class="id-cell">{{ $audit->deadline }}</td>
                                            <td class="id-cell">{{ $audit->new_deadline ?? '--' }}</td>
                                            <td class="{{ $audit->avancement['classe'] }}">{{ $audit->avancement['valeur'] }}%</td>
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
</div>
<script>
    document.getElementById('export-pdf').addEventListener('click', function() {
        exportToPDF();
    });
    function exportToPDF() {
        const element = document.getElementById("pdfContent");

        const options = {
            filename: 'Rapport_Audit_Interne_{{ $mois_annee_affichage }}.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };
        html2pdf().set(options).from(element).save();
    }
</script>

@include('CRM.footer')