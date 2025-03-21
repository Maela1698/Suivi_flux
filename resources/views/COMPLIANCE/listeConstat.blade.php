@include('CRM.header')
@include('CRM.sidebar')
@include('COMPLIANCE.STYLE.styleListeConstatAuditInterne')
<title>ListeConstat</title>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('COMPLIANCE.headerCompliance')
        <div class="row">
            
            <div class="card col-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="entete">LISTE CONSTAT</h3>
                    <button type="button" data-toggle="modal" data-target="#constat" class="btn btn-primary">Ajouter</button>
                </div>
                <form action="{{ route('COMPLIANCE.listeConstat') }}" method="post" autocomplete="off">
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
                            <button class="btn btn-success" style="width: 100px">Filtrer</button>
                            <button type="button" class="btn btn-primary" id="apercuPdfBtn">Apercu PDF</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive" style="margin-top: -15px;">
                    <table class="table student-data-table m-t-20 table-hover mt-3 perso" style="color: black">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Date</th>
                                <th>Constat</th>
                                <th>Section</th>
                                <th>Actions</th>
                                <th>Priorite</th>
                                <th>Deadline</th>
                                <th>Avancement</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($constats as $constat)
                                <tr data-toggle="modal" data-target="#cinConstat" data-id="{{ $constat->constat_id }}">
                                    <td>{{ $constat->constat_numero }}</td>
                                    <td>{{ $constat->dateconstat }}</td>
                                    <td>
                                        <?php
                                            $descriptions = substr($constat->description, 0, 50);
                                            $hasMore = strlen($constat->description) > 50;
                                        ?>
                                        {{ $descriptions }} @if($hasMore)...@endif
                                    </td>
                                    <td>{{ $constat->section }}</td>
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
        @include('COMPLIANCE.MODAL.modalListeAuditInterne')
    </div>
</div>
@include('COMPLIANCE.JS.jsListeConstat')
@include('CRM.footer')