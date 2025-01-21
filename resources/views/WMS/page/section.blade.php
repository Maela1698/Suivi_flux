@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">

    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Section</p>
            </div>
            <div class="card-body">
                <form action="{{ route('enregistrer', ['modelName' => 'SectionWMS']) }}" method="post"
                    style="border-radius: 34px;" enctype="multipart/form-data">
                    @csrf
                    <h4 class="text-center">Ajout de nouveau section</h4>
                    <div class="form-group d-flex justify-content-center">
                        @error('section')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        <input class="form-control w-50" type="text" name="section"
                            placeholder="{{ $errors->has('section') ? $errors->first('section') : 'Nom de la section' }}">
                    </div>

                    <div class="form-group d-flex justify-content-center">
                        <button class="btn btn-primary" type="submit">Ajouter</button>
                    </div>
                </form>
                <div>
                    @if (Session::has('DonneErreur'))
                        <div class="alert alert-warning" style="text-align: center;color: #495057">
                            {{ Session::get('DonneErreur') }}
                        </div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success" style="text-align: center;color: #495057">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::has('fail'))
                        <div class="alert alert-danger" style="text-align: center;color: #495057">
                            {{ Session::get('fail') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger" style="text-align: center;color: #495057">
                            {{ Session::get('erreur') }}
                        </div>
                    @endif
                </div>
                <div class="table-responsive table mt-2" id="dataTable" role="grid"
                    aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>Section</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($section as $sections)
                                <tr>
                                    <td>{{ $sections->section }}</td>
                                    <td>
                                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                            data-target="#modification-modal" style="border-radius: 50%">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" type="button" data-toggle="modal"
                                            data-target="#suppression-modal" style="border-radius: 50%">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Modification modal
                                --}}
                                <div class="modal" id="modification-modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Modification</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info">Modification de la section</p>
                                                <form id="modification-form" action="#" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3"><label class="form-label">Section</label>
                                                        <input class="form-control" type="text" name="section"
                                                            value="">
                                                    </div>
                                            </div>
                                            <div style="text-align: center">
                                                <div class="modal-footer" style="text-align: center">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal"
                                                        onclick="resetFormValues()">Annuler</button>
                                                    <button class="btn btn-primary" type="submit">Modifier</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Suppression
                                --}}
                                <div class="modal" id="suppression-modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Suppression</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="#">
                                                    @csrf
                                                    <p class="alert alert-danger" style="color: black">
                                                        Voulez-vous
                                                        vraiment
                                                        supprimer cette donnée ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">Annuler</button>
                                                <button class="btn btn-danger" type="submit">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@include('CRM.footer')
{{-- <script>
    $(document).ready(function() {
        @foreach ($utilisateur as $utilisateurs)
            $('#fonction_id_{{ $utilisateurs->id }}').select2({
                width: '100%',
                ajax: {
                    url: '{{ route('p-autocomplete-fonction') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            query: params.term, // Search term
                            page: params.page
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(fonction) {
                                return {
                                    id: fonction.id,
                                    text: fonction.nom
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        @endforeach

    });
</script> --}}
{{-- <script>
    function resetFormValues(directionId) {
        // Reset the form fields to their initial values
        document.getElementById(`modification-form-${directionId}`).reset();
    }
    @foreach ($utilisateur as $utilisateurs)
        $('#modification-modal-{{ $utilisateurs->id }}').on('hidden.bs.modal', function() {
            resetFormValues({{ $utilisateurs->id }});
        });
    @endforeach
</script> --}}
