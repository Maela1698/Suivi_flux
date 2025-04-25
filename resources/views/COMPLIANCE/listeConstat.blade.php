@include('CRM.header')
@include('CRM.sidebar')
@include('COMPLIANCE.STYLE.styleListeConstatAuditInterne')
<title>ListeConstat</title>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('COMPLIANCE.headerCompliance')
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-two card-body">
                        <div class="stat-content">
                            <div class="stat-text">Nombre Constat</div>
                            <div class="stat-digit"></i>{{ $constat_stat->nb_constat }}</div>
                        </div>
                        <div class="progress" style="opacity: 0;">
                            <div role="progressbar" aria-valuemin="0" aria-valuemax="100" style="background-color: white"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-two card-body">
                        <div class="stat-content">
                            <div class="stat-text">Resolu</div>
                            <div class="stat-digit"></i>{{ $constat_stat->taux_resolu }}%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: {{ $constat_stat->taux_resolu }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-two card-body">
                        <div class="stat-content">
                            <div class="stat-text">A Traiter</div>
                            <div class="stat-digit"></i>{{ $constat_stat->taux_a_traiter }}%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: {{ $constat_stat->taux_a_traiter }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-two card-body">
                        <div class="stat-content">
                            <div class="stat-text">Retard</div>
                            <div class="stat-digit"></i>{{ $constat_stat->taux_retard }}%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: {{ $constat_stat->taux_retard }}%;"></div>
                        </div>
                    </div>
                </div>
                <!-- /# card -->
            </div>
            <!-- /# column -->
        </div>
        <div class="row">
            <div class="card col-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="entete">LISTE CONSTAT</h3>
                    <button type="button" data-toggle="modal" data-target="#constat" class="btn btn-primary">Ajouter</button>
                    <button type="button" class="btn btn-primary" id="btn-ajout-mult">Ajout Multiple</button>
                </div>
                <form action="{{ route('COMPLIANCE.readAuditInterne') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-lg">
                            <input class="form-control" id="daterange" type="text" name="daterange" placeholder="date constat" value="{{ request('daterange') }}">
                        </div>
                        <div class="col-lg">
                            <div class="input-group">
                                <select class="form-control" name="resolution">
                                    <option value="">Resolution</option>
                                    <option value="true" {{ request('resolution') === 'true' ? 'selected' : '' }}>Resolu</option>
                                    <option value="false" {{ request('resolution') === 'false' ? 'selected' : '' }}>En cours</option>
                                </select>                                
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="input-group">
                                <input class="form-control" list="liste_sections" id="sectionInput" placeholder="Section" value="{{ $section ? $section->nom_section : ''}}">
                                <input type="hidden" name="id_section" id="id_section_input" value="{{ request('id_section_input') }}">
                                <datalist id="liste_sections">
                                    @foreach ($sections as $section)
                                        <option data-id="{{ $section->id }}"  value="{{ $section->nom_section }}"></option>
                                    @endforeach
                                </datalist>                              
                            </div>
                        </div>
                        <div class="col-lg">
                            <button class="btn btn-success" style="width: 100px">Filtrer</button>
                            <button type="button" class="btn btn-primary" id="rapport-button">Rapport</button>    
                            <button type="button" class="btn btn-primary" id="rapportHebdo-button">Rapport hebdo</button>    
                        </div>
                    </div>
                </form>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>ID</th>
                                <th>Detection</th>
                                <th>Constat</th>
                                <th>Section</th>
                                <th>Responsable</th>
                                <th>Actions</th>
                                <th>Priorite</th>
                                <th>Deadline</th>
                                <th>Avancement</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($audits as $constat)
                                <tr id="audit-{{ $constat->id }}" data-toggle="modal" data-target="#cinConstat" data-id="{{ $constat->id }}">
                                    <td>
                                        <div class="code">
                                            <div class="circle
                                                {{ $constat->etat_constat == 1 ? 'resolu' : '' }}
                                                {{ $constat->etat_constat == 2 ? 'a_traiter' : '' }}
                                                {{ $constat->etat_constat == 3 ? 'retard' : '' }}
                                            "></div>
                                        </div>
                                    </td>
                                    <td class="id-cell">{{ $constat->id }}</td>
                                    <td class="id-cell">{{ $constat->date_detection }}</td>
                                    <td>
                                        <?php
                                            $descriptions = substr($constat->constat, 0, 50);
                                            $hasMore = strlen($constat->constat) > 50;
                                        ?>
                                        {{ $descriptions }} @if($hasMore)...@endif
                                    </td>
                                    <td>{{ $constat->section }}</td>
                                    <td>{{ $constat->nom_emp ?? '-'}} {{ $constat->prenom_emp ?? '-' }}</td>
                                    <td>{{ $constat->action }}</td>
                                    <td>{{ $constat->priorite['valeur'] }}</td>
                                    <td class="id-cell">
                                        {{ $constat->new_deadline ? $constat->new_deadline : $constat->deadline }}
                                    </td>
                                    <td>{{ $constat->avancement['valeur'] }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('COMPLIANCE.MODAL.modalListeAuditInterne')
    </div>
</div>
@include('COMPLIANCE.JS.jsListeConstat')
@include('CRM.footer')