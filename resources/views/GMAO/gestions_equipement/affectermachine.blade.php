@include('CRM.header')
@include('CRM.sidebar')

{{-- pour les input emprunt et ** --}}
<style>
    input:disabled,
    select:disabled {
        background-color: #e9ecef; /* Couleur de fond gris clair */
        color: #6c757d; /* Couleur du texte gris */
        cursor: not-allowed; /* Curseur pour indiquer que l'élément est désactivé */
        opacity: 1; /* S'assurer que l'élément ne devient pas transparent */
    }



</style>
{{-- pour les input emprunt et ** --}}
<div class="content-body">
    <div class="container-fluid">
        @include('GMAO.headerGMAO')
        <div class="row">
            @include('GMAO.cin_machine')
            <div class="card col-12">
                <div class="card-header d-flex justify-content-between align-items-center entete">
                    <h3 class="entete">Affectation d'une machine</h3>
                </div>

                <div class="card-body">
                    <div class="form-validation">
                        <form class="form-valide" action="{{route('GMAO.affectermachine')}}" method="post" enctype="multipart/form-data" autocomplete="off" id="machine-form">
                            @csrf
                            <div class="form-group row">
                                <input type="hidden" name="id_machine" value={{$id_machine}}>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label" >Date Affectation </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="date" class="form-control" name="date_affectation" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="secteur" class="col-form-label">Secteur<small><em style="color:rgb(255, 68, 68)">**</em></small></label>
                                    <input type="text" id="secteur" class="form-control" placeholder="Secteur" required>
                                    <input type="hidden" id="idsecteur" class="form-control" name="secteur">
                                    <ul id="suggestionsListSecteur" class="list-group mt-2" style="display: none;"></ul>
                                </div>
                                <div class="col-4">
                                    <label for="piece" class="form-label">Commentaire</label>
                                    <textarea class="form-control" id="commentaire" name="commentaire"></textarea>
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
                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success">Ajouter</button>
                                </div>
                            </div>
                            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                        </form>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@include('GMAO.boutongmao')
{{-- autocompletion --}}
    {{-- fournisseur --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var secteur = document.getElementById('secteur');
            var idsecteur= document.getElementById('idsecteur');
            var suggestionsList = document.getElementById('suggestionsListSecteur');

            secteur.addEventListener('input', function () {
                var query = secteur.value;

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route("recherche-secteur-machine") }}?secteur=' + encodeURIComponent(query), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var secteurs = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';
                        if (secteurs.length > 0) {
                            secteurs.forEach(function (sec) {
                                var li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = sec.secteur;
                                li.addEventListener('click', function () {
                                    secteur.value = sec.secteur;
                                    idsecteur.value = sec.id;
                                    suggestionsList.style.display = 'none';
                                });
                                suggestionsList.appendChild(li);
                            });
                            suggestionsList.style.display = 'block';
                        } else {
                            suggestionsList.style.display = 'none';
                        }
                    }
                };
                xhr.send();
            });

            document.addEventListener('click', function (event) {
                if (!secteur.contains(event.target) && !suggestionsList.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        });
    </script>
    {{-- fournisseur --}}
{{-- autocompletion --}}
@include('CRM.footer')
