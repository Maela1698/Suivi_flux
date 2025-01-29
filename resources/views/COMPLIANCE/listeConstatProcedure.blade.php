@include('CRM.header')
@include('CRM.sidebar')
<title>ListeConstat</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .table th {
        color: #000000;
        font-weight: bold;
    }

    .table td {
        color: #828282;
        font-weight: bold;
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('COMPLIANCE.headerCompliance')

        <div class="row">
            <div class="card col-12">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="entete">LISTE CONSTAT PROCEDURES</h3>
                </div>
                <br>
                <div class="table-responsive" style="margin-top: -25px;">
                    <form method="GET" action="{{ route('COMPLIANCE.listeConstatPerimetre') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="input-group" id="date-range">
                                    <input type="date" class="form-control" name="startdate">
                                    <span class="input-group-addon b-0 text-white"
                                        style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                    <input type="date" class="form-control" name="enddate">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="section" class="form-control">
                                    <option value="">Section</option>
                                    @foreach ($section as $s)
                                        <option value="{{ $s->id }}">{{ $s->designation }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="priorite" class="form-control">
                                    <option value="">Priorité</option>
                                    <option value="1">Haute</option>
                                    <option value="2">Moyenne</option>
                                    <option value="3">Basse</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Filtrer</button>
                            </div>
                        </div>
                    </form>

                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead class="thead-dark">
                            <tr>
                                <th>Date</th>
                                <th>Constat</th>
                                <th>Section</th>
                                <th>Priorité</th>
                                <th>Question</th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            @foreach ($constat as $c)
                                <tr onclick="window.location.href='{{ route('COMPLIANCE.detailConstatPerimetre', ['idconstat' => $c->constat_id]) }}';">
                                    <td>{{ \Carbon\Carbon::parse($c->dateconstat)->format('d/m/y') }}</td>
                                    <td>{{ Str::limit($c->description, 50, '...') }}</td>
                                    <td>{{ $c->section }}</td>
                                    @if($c->priorite==1)
                                    <td>Faible</td>
                                    @endif
                                    @if($c->priorite==2)
                                    <td>Moyen</td>
                                    @endif
                                    @if($c->priorite==3)
                                    <td>Elevé</td>
                                    @endif
                                    <td>{{ $c->question }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('CRM.footer')
