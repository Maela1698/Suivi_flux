@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">
    <div class="container-fluid">
        @include('GMAO.headerGMAO')
        <div class="row">
            @include('GMAO.cin_machine')
            <div class="card col-12">
                <div class="card-header d-flex justify-content-between align-items-center entete">
                    <h3 class="entete">Déplacer cette machine</h3>
                </div>

                <div class="card-body">
                    <div class="form-validation">
                        {{-- {{route('GMAO.affectermachine')}} --}}
                        <form class="form-valide" action="{{ route('deplacement.machine') }}" method="post" enctype="multipart/form-data" autocomplete="off" id="deplacement-form">
                            @csrf
                            <div class="form-group row">

                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label" >Date de déplacement </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="date" class="form-control" name="date_deplacement" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="secteur" class="col-form-label">Secteur Actuel<small><em style="color:rgb(255, 68, 68)">**</em></small></label>
                                    <input type="text" id="secteur1_show" name="secteur1_show" class="form-control"  value="{{$details_jointure_secteur[0]->secteur ?? 'None'}}">
                                    <input type="hidden" id="secteur1" name="secteur1" class="form-control" value="{{$details_jointure_secteur[0]->id_secteur ?? ''}}" required readonly>

                                </div>

                                <div class="col-3">
                                    <label for="secteur" class="col-form-label">Déplacer vers ce secteur<small><em style="color:rgb(255, 68, 68)">**</em></small></label>
                                    <input type="text" id="secteur2" class="form-control" placeholder="Secteur" required>
                                    <input type="hidden" id="idsecteur2" class="form-control" name="secteur2">
                                    <ul id="suggestionsListSecteur" class="list-group mt-2" style="display: none;"></ul>
                                </div>
                                <div class="col-3">
                                    <label for="commentaire" class="form-label">Commentaire</label>
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
                                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success">Ajouter</button>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <input type="hidden" id="id_j_secteur_machine" name="id_j_secteur_machine" class="form-control" value="{{$details_jointure_secteur[0]->id_j_secteur_machine ?? ''}}" required readonly>
                                    <input type="hidden" id="id_machine" name="id_machine" class="form-control" value="{{$details_jointure_secteur[0]->id_machine ?? ''}}" required readonly>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('GMAO.boutongmao')
    {{-- secteur auto-completion --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const secteur = document.getElementById('secteur2');
            const idsecteur = document.getElementById('idsecteur2');
            const suggestionsList = document.getElementById('suggestionsListSecteur');

            secteur.addEventListener('input', function () {
                const query = secteur.value.trim();

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                const xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route("recherche-secteur-machine") }}?secteur=' + encodeURIComponent(query), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const loca = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';

                        if (loca.length > 0) {
                            loca.forEach(function (lc) {
                                const li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = lc.secteur;
                                li.style.cursor = 'pointer';
                                li.addEventListener('click', function () {
                                    secteur.value = lc.secteur;
                                    idsecteur.value = lc.id;
                                    suggestionsList.style.display = 'none';
                                });
                                suggestionsList.appendChild(li);
                            });
                            suggestionsList.style.display = 'block';
                        } else {
                            suggestionsList.style.display = 'none';
                        }
                    } else {
                        console.error("Erreur lors de la récupération des secteurs");
                    }
                };
                xhr.onerror = function () {
                    console.error("Erreur lors de la requête AJAX");
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
    {{-- secteur auto-completion --}}
@include('CRM.footer')
