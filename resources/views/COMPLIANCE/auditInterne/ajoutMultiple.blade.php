@include('CRM.header')
@include('CRM.sidebar')
@include('COMPLIANCE.STYLE.styleAjoutMultiple')
<title>Ajout Multiple Audit Interne</title>
<div class="content-body">
    <div class="container-fluid">
        @include('COMPLIANCE.headerCompliance')
        <div class="row">
            <div class="card col-lg-12">
                <div class="card-header">
                    <h4 class="card-title">AJOUT MULTIPLE AUDIT INTERNE</h4>
                </div>
                <form action="{{ route('AUDITINTERNE.doAjoutMultiple') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="row align-items-end">
                            <div class="col-7">
                                <label>Section</label>
                                <input class="form-control" list="liste_sections" id="sectionInput" placeholder="Section" required>
                                <input type="hidden" name="id_section" id="id_section_input" value="{{ request('id_section_input') }}">
                                <datalist id="liste_sections">
                                    @foreach ($sections as $section)
                                        <option data-id="{{ $section->id }}"  data-nom="{{ $section->nom_emp }}" data-prenom="{{ $section->prenom_emp }}" value="{{ $section->nom_section }}"></option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-lg">
                                <p>Responsable: <span id="responsable">--</span></p>
                            </div>
                            <div class="col-lg">
                                <label>Date detection</label>
                                <input class="form-control" type="date" name="date_detection" value="{{ $date }}" disabled>
                            </div>
                            <div class="col-lg">
                                <button type="button" class="btn btn-primary" id="btn-ajout-mult">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="basic-form formulaire">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Constat</label>
                                    <input type="text" class="form-control" required name="constat[]">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Action</label>
                                    <input type="text" class="form-control" required name="action[]">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Priorité</label>
                                    <select class="form-control" name="priorite[]">
                                        <option value="1">Faible</option>
                                        <option value="2">Moyenne</option>
                                        <option value="3">Elevée</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Deadline</label>
                                    <input type="date" class="form-control" name="deadline[]">
                                </div>
                                <div class="form-group col-md-1">
                                    <label>Photo</label>
                                    <input type="file" class="form-control" name="photo_initial[]" accept="image/*">
                                    
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-remove">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('COMPLIANCE.JS.jsAjoutMultipleAuditInterne')
@include('CRM.footer')
