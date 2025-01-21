@include('CRM.header')
@include('CRM.sidebar')
<title>ChoixTissu</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .form-control {
        border: 1px solid #b5b5b5;
    }

    label {
        color: #767575;
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div class="row">
            <div class="card col-12">
                <div class="card-header d-flex justify-content-center align-items-center entete">
                    <h3 class="entete">CHOIX TISSU</h3>
                </div>

                <div class="card-body">

                    <div class="sdc" style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="button-group" style="display: flex; gap: 10px;">
                            <form action=" {{ route('CRM.ajoutFicheCoupe') }} " method="get">
                                @csrf
                                <div class="row">

                                    <div class="col-9">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label">Nom tissu</label>
                                            </div>
                                            <div class="col-12">
                                                <select class="form-control" name="tissu" required>
                                                    @for ($i = 0; $i < count($tissu); $i++)
                                                        <option value="{{ $tissu[$i]->id }}">{{ $tissu[$i]->type_tissus }}({{ $tissu[$i]->reference }})
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 mt-4">
                                        <button type="submit" class="btn btn-success">Ajouter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
