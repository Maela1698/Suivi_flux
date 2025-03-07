@include('CRM.header')
@include('CRM.sidebar')
@include('COMPLIANCE.STYLE.stylePlanAction')
<title>Plan Action Apercu</title>
<!-- content-body -->
<div class="content-body">
    <!-- container-fluid -->
    <div class="container-fluid">
        @include('COMPLIANCE.headerCompliance')
        <!-- row -->
        <div class="row">
            <div class="card col-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="entete">PLAN ACTION</h3>
                    <button type="button" class="btn btn-primary" onclick="exportToPDF()">Telecharger PDF</button>
                </div>
                <div class="card-body" id="pdf">
                    <div class="row align-items-center">
                        <div class="col-auto text-center">
                            <img src="./images/NEW LOGO.png" class="img-fluid" alt="Logo">
                        </div>
                        <div class="col text-right">
                            <h4 class="font-weight-bold">Rapport Plan Action</h4>
                            <p class="mb-1"><strong>Date début :</strong> <span id="dateDebut">[Date Début]</span></p>
                            <p class="mb-1"><strong>Date fin :</strong> <span id="dateFin">[Date Fin]</span></p>
                            <p class="mb-1"><strong>Section :</strong> <span id="section">{{ $section ? $section->designation : '--' }}</span></p>
                            <p class="mb-1"><strong>Priorite :</strong> <span id="priorite">--</span></p>
                            <p class="mb-1"><strong>Responsable:</strong> <span id="responsable">{{ $responsable ? $responsable->nom . ' ' . $responsable->prenom : '--' }}</span></p>
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Numero</th>
                                    <th>Debut</th>
                                    <th>Section</th>
                                    <th>Constat</th>
                                    <th>Moyens/Actions</th>
                                    <th>Priorité</th>
                                    <th>Responsable</th>
                                    <th>Deadline</th>
                                    <th>Avancement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($planActions as $action)
                                    <tr>
                                        <td>{{ $action->numero }}</td>
                                        <td>{{ $action->datedebut }}</td>
                                        <td>{{ $action->section }}</td>
                                        <td>{{ $action->constat }}</td>
                                        <td>{{ $action->moyens }}</td>
                                        <td>{{ $action->priorite }}</td>
                                        <td>{{ $action->responsable }} {{ $action->prenom }}</td>
                                        <td>{{ $action->deadline }}</td>
                                        <td>{{ $action->avancement }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>                                              
            </div>
        </div>
        <!-- row -->
    </div>
    <!-- container-fluid-end -->
</div>
<!-- content-body-end -->
@include('COMPLIANCE.JS.jsPlanActionPdf')
@include('CRM.footer')
