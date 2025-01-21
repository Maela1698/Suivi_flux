@include('CRM.header')
@include('CRM.sidebar')
<style>
    #suggestionsListLocalisation{
        max-height: 200px;
        overflow-y: auto;
        color: #000000;
        z-index: 5000;
        position: absolute; /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%; /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%; /* Place la liste juste en dessous du champ */
        left: 0; /* Aligne la liste avec le champ */
        }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('GMAO.headerGMAO')
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="col-sm-4">
                           <h3  class="entete">AJOUTER UN SECTEUR</h3>
                        </div>
                    </div>
                    <div class="card-header">
                        {{-- <h4 class="card-title">Ajouter ici un secteur</h4> --}}
                    </div>

                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ route('ajouter-secteur') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="localisation" class="col-form-label">Localisation</label>
                                                {{-- <small><em>*</em></small> --}}
                                                <input type="text" id="localisation" name="localisation" class="form-control" placeholder="Localisation" required>
                                                <input type="hidden" id="idlocalisation" class="form-control" name="localisation">
                                                <ul id="suggestionsListLocalisation" class="list-group mt-2" style="display: none;"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label" >Secteur</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" class="form-control" name="secteur" placeholder="Secteur" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success">Ajouter</button>
                                    </div>
                                </div>


                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif


                                @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                                @endif

                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@include('GMAO.boutongmao')
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}

    {{-- localisation --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const localisation = document.getElementById('localisation');
            const idlocalisation = document.getElementById('idlocalisation');
            const suggestionsList = document.getElementById('suggestionsListLocalisation');

            localisation.addEventListener('input', function () {
                const query = localisation.value.trim();

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                const xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route("recherche-localisation-machine") }}?localisation=' + encodeURIComponent(query), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const loca = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';

                        if (loca.length > 0) {
                            loca.forEach(function (lc) {
                                const li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = lc.localisation;
                                li.style.cursor = 'pointer';
                                li.addEventListener('click', function () {
                                    localisation.value = lc.localisation;
                                    idlocalisation.value = lc.id;
                                    suggestionsList.style.display = 'none';
                                });
                                suggestionsList.appendChild(li);
                            });
                            suggestionsList.style.display = 'block';
                        } else {
                            suggestionsList.style.display = 'none';
                        }
                    } else {
                        console.error("Erreur lors de la récupération des localisations");
                    }
                };
                xhr.onerror = function () {
                    console.error("Erreur lors de la requête AJAX");
                };
                xhr.send();
            });

            document.addEventListener('click', function (event) {
                if (!localisation.contains(event.target) && !suggestionsList.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        });
    </script>
    {{-- localisation --}}
@include('CRM.footer')

