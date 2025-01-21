@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">
    <div class="container-fluid">
        @include('WMS.headerWMS')
        {{-- <h3 class="text-dark mb-4" style="text-align: center">Parité</h3> --}}
        <div class="card">

            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Parité</p>
            </div>
            <div class="card-body">
                <form action="{{ route('enregistrer', ['modelName' => 'Parite']) }}" method="post"
                    style="border-radius: 34px;" enctype="multipart/form-data">
                    @csrf
                    <h4 class="text-center">Ajout parité</h4>
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('erreur') }}</div>
                    @endif
                    @if ($errors->has('error'))
                        <div class="alert alert-danger">
                            {{ $errors->first('error') }}
                        </div>
                    @endif

                    <div class="form-group d-flex flex-column align-items-center">
                        @error('dateparite')
                            <span class="text-danger mb-1">{{ $message }}</span>
                        @enderror
                        <input class="form-control w-50" type="date" name="dateparite">
                    </div>

                    <div class="form-group d-flex flex-column align-items-center">
                        @error('deviseeuro')
                            <span class="text-danger mb-1">{{ $message }}</span>
                        @enderror
                        <input class="form-control w-50" type="text" name="deviseeuro" placeholder="Devise euro">
                    </div>

                    <div class="form-group d-flex flex-column align-items-center">
                        @error('devisedollar')
                            <span class="text-danger mb-1">{{ $message }}</span>
                        @enderror
                        <input class="form-control w-50" type="text" name="devisedollar" placeholder="Devise dollar">
                    </div>

                    <div class="form-group d-flex flex-column align-items-center">
                        @error('valeur')
                            <span class="text-danger mb-1">{{ $message }}</span>
                        @enderror
                        <input class="form-control w-50" type="text" name="valeur" placeholder="Valeur">
                    </div>
                    <div class="form-group d-flex flex-column align-items-center">
                        <button class="btn btn-primary" type="submit">Ajouter</button>
                    </div>
                </form>
                <div class="table-responsive table mt-2" id="dataTable" role="grid"
                    aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>Date parité</th>
                                <th>Devise Euro</th>
                                <th>Devise Dollar</th>
                                <th>Valeur</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parite as $parites)
                                <tr>
                                    <td>{{ $parites->dateparite }}</td>
                                    <td>{{ $parites->deviseeuro }}</td>
                                    <td>{{ $parites->devisedollar }}</td>
                                    <td>{{ $parites->valeur }}</td>
                                    <td>
                                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                            data-target="#modification-modal-{{ $parites->id }}"
                                            style="border-radius: 50%">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" type="button" data-toggle="modal"
                                            data-target="#suppression-modal-{{ $parites->id }}"
                                            style="border-radius: 50%">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>

                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Modification modal
                                --}}
                                <div class="modal" id="modification-modal-{{ $parites->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Modification</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info">Modification de la parité</p>
                                                <form id="modification-form"
                                                    action="{{ route('modifier', ['modelName' => 'Parite', 'id' => $parites->id]) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3"><label class="form-label">Date parité</label>
                                                        <input class="form-control" type="date" name="dateparite"
                                                            value="{{ $parites->dateparite }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Devise Euro</label>
                                                        <input class="form-control" type="text" name="deviseeuro"
                                                            value="{{ $parites->deviseeuro }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Devise Dollar</label>
                                                        <input class="form-control" type="text" name="devisedollar"
                                                            value="{{ $parites->devisedollar }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Valeur</label>
                                                        <input class="form-control" type="text" name="valeur"
                                                            value="{{ $parites->valeur }}">
                                                    </div>
                                            </div>
                                            <div style="text-align: center">
                                                <div class="modal-footer" style="text-align: center">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal"
                                                        onclick="resetFormValues({{ $parites->id }})">Annuler</button>
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
                                <div class="modal" id="suppression-modal-{{ $parites->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Suppression</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="{{ route('supprimer', ['modelName' => 'Parite', 'id' => $parites->id]) }}">
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
                    <div class="pagination justify-content-center">
                        @if ($parite->lastPage() > 1)
                            <ul class="pagination justify-content-center">
                                <!-- Previous Page Link -->
                                <li class="page-item {{ $parite->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $parite->previousPageUrl() }}"
                                        aria-label="Précedent">
                                        <span aria-hidden="true" style="color: black">&laquo; Précedent</span>
                                    </a>
                                </li>

                                <!-- Pagination Links -->
                                @php
                                    $currentPage = $parite->currentPage();
                                    $lastPage = $parite->lastPage();
                                    $visiblePages = min($lastPage, 4); // Maximum number of visible pages
                                    $startPage = max(1, $currentPage - floor($visiblePages / 2));
                                    $endPage = min($lastPage, $startPage + $visiblePages - 1);
                                @endphp

                                @if ($startPage > 1)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                @for ($i = $startPage; $i <= $endPage; $i++)
                                    <li class="page-item {{ $parite->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $parite->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ($endPage < $lastPage)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                <!-- Next Page Link -->
                                <li
                                    class="page-item {{ $parite->currentPage() == $parite->lastPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $parite->nextPageUrl() }}" aria-label="Suivant">
                                        <span aria-hidden="true" style="color: black">Suivant &raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@include('CRM.footer')
<script>
    function resetFormValues(id) {
        // Reset the form fields to their initial values
        document.getElementById(`modification-modal-${id}`).reset();
    }
</script>
