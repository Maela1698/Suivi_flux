<!-- Modal ajout constat -->
<div class="modal fade" id="constat" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 450px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="choixEtapeModalLabel">Insertion constat
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('COMPLIANCE.newAjoutConstat') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 mt-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte">Numero</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="numero"  required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-1">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte">Date constat</label>
                                </div>
                                <div class="col-12">
                                    <input type="date" class="form-control" name="date_constat"  required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte">Section</label>
                                </div>
                                <div class="col-12">
                                    <select class="form-control" name="id_section">
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->designation }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte">Priorité</label>
                                </div>
                                <div class="col-12">
                                    <select class="form-control" name="priorite">
                                        <option value="1">Faible</option>
                                        <option value="2">Moyenne</option>
                                        <option value="3">Elevée</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte">Description</label>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" name="description" required>Je test le description de mon new ajout constat</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte">Moyen/Actions</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="action" value="Je test l'action de mon new ajout constat" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte">Deadline</label>
                                </div>
                                <div class="col-12">
                                    <input type="date" class="form-control" name="deadline"  required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte">Fichier</label>
                                </div>
                                <div class="col-12">
                                    <input type="file" class="form-control" name="fichierConstat" accept="image/*" capture="camera">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal CIN constat -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" aria-hidden="true" id="cinConstat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Audit Interne - <span id="numero"> </span></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <form action="{{ route('COMPLIANCE.updateAvancement') }}" method="GET">
                <div class="modal-body">
                    <div>
                        <img src="" class="img-fluid rounded-start mb-5" alt="Logo" width="200px" height="200px" id="fichierConstat">
                    </div>
                    <div class="basic-form">
                        <div class="form-row">
                            <input type="hidden" name="id_constat" id="id_constat">
                            <div class="form-group col-md-6">
                                <label>Numero</label>
                                <input type="text" class="form-control" id="numero-input" name="numero" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Date Constat</label>
                                <input type="date" class="form-control" id="date_constat" name="date_constat" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Section</label>
                                <select class="form-control" name="id_section" id="id_section">
                                    <!-- Options should be populated here -->
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Priorité</label>
                                <select class="form-control" name="priorite" id="priorite">
                                    <option value="1">Faible</option>
                                    <option value="2">Moyenne</option>
                                    <option value="3">Élevée</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <textarea class="form-control" name="description" id="description" required></textarea>
                            </div>
                            <div class="form-group col-md-7">
                                <label>Action</label>
                                <input type="text" class="form-control" name="action" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Deadline</label>
                                <input type="date" class="form-control" name="deadline" required>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Avancement(%)</label>
                                <input type="number" class="form-control" name="avancement" required>
                                <div id="check_violation" class="text-danger mb-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>            
        </div>
    </div>
</div>

{{-- Modal Apercu pdf --}}
<div class="modal fade bd-example-modal-lg" tabindex="-1" aria-hidden="true" id="pdf">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Audit Interne - <span id="numero"> </span></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            
                <div class="modal-body">
                    <div class="card-body" id="pdfContent">
                        <div class="row align-items-center">
                            <div class="col-auto text-center">
                                <img src="./images/NEW LOGO.png" class="img-loi" alt="Logo">
                            </div>
                            <div class="col text-right">
                                <h4 class="font-weight-bold">Rapport Audit Interne</h4>
                                <p class="mb-1"><strong>Début Constat :</strong> <span id="dateDebut">{{ $dateDebut ? : '--' }}</span></p>
                                <p class="mb-1"><strong>Fin Constat :</strong> <span id="dateFin">{{ $dateFin ? : '--' }}</span></p>
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
                                        <th>Deadline</th>
                                        <th>Avancement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($constats as $constat)
                                        <tr>
                                            <td>{{ $constat->constat_numero }}</td>
                                            <td>{{ $constat->dateconstat }}</td>
                                            <td>{{ $constat->section }}</td>
                                            <td>{{ $constat->description }}</td>
                                            <td>{{ $constat->action }}</td>
                                            <td>{{ $constat->priorite }}</td>
                                            <td>{{ $constat->constat_deadline }}</td>
                                            <td>{{ $constat->constat_avancement }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="exportToPDF()">Telechargez pdf</button>
                </div>           
        </div>
    </div>
</div>
<script>
    function exportToPDF() {
        const element = document.getElementById("pdfContent");

        const options = {
            filename: 'Rapport_Plan_Action.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };
        html2pdf().set(options).from(element).save();
    }
</script>
