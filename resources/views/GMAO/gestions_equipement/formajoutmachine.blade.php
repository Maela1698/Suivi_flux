@include('CRM.header')
@include('CRM.sidebar')
{{-- pour les fichier --}}
<style>
        /* .custom-file-upload {
        display: inline-block;
        padding: 10px 20px;
        cursor: pointer;
        background-color: #345a83;
        color: white;
        border-radius: 4px;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .custom-file-upload i {
        margin-right: 8px;
    }

    .custom-file-upload:hover {
        background-color: #0056b3;
    }

    input[type="file"] {
        display: none;
    } */

</style>
{{-- pour les fichier --}}

{{-- pour les input emprunt et ** --}}
<style>
    input:disabled,
    select:disabled {
        background-color: #e9ecef; /* Couleur de fond gris clair */
        color: #6c757d; /* Couleur du texte gris */
        cursor: not-allowed; /* Curseur pour indiquer que l'élément est désactivé */
        opacity: 1; /* S'assurer que l'élément ne devient pas transparent */
    }

    #suggestionsListFournisseur{
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


    #suggestionsListCategorie{
    max-height: 200px;
    overflow-y: auto;
    color: #767575;
    z-index: 5000;
    position: absolute; /* Permet de positionner l'élément par rapport à son conteneur */
    background-color: #fff;
    border: 1px solid #ccc;
    width: 100%; /* Assure que la largeur de la liste correspond à celle du champ */
    top: 100%; /* Place la liste juste en dessous du champ */
    left: 0; /* Aligne la liste avec le champ */
    }

    #suggestionsListMarque{
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
{{-- pour les input emprunt et ** --}}
<div class="content-body">

    <div class="container-fluid">
        @include('GMAO.headerGMAO')
        <div class="row">
            <div class="card col-12">
                <div class="card-header d-flex justify-content-between align-items-center entete">
                    <h3 class="entete">Insertion d'une machine</h3>
                </div>

                <div class="card-body">
                    <div class="form-validation">
                        <form class="form-valide" action="{{route('GMAO.storemachine')}}" method="post" enctype="multipart/form-data" autocomplete="off" id="machine-form">
                            @csrf
                            {{-- <div class="form-group row ">
                                <div class="col-12">
                                    <input type="checkbox" id="emprunt" name="emprunt" class="form-check-input">
                                    <label for="emprunt" class="form-check-label">Emprunt <small>
                                        <em>cocher si la machine est un emprunt</em></small></label>
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label>Type de la machine :</label><br>
                                        </div>
                                        <div class="col-12">
                                            <input type="radio" id="propriete" name="type" value="100" class="form-check-input">
                                            <label for="propriete" class="form-check-label">Propriété</label>
                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <input type="radio" id="emprunt" name="type" value="200" class="form-check-input">
                                            <label for="emprunt" class="form-check-label">Emprunt</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label" >Date entrée </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="date" class="form-control" name="date_entree" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label" >Date Fin de contrat </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="date" class="form-control" name="date_fin_contrat" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-row d-flex">
                                <div class="col-2">
                                    <label for="nomfournisseur" class="col-form-label">Fournisseur <small><em>**</em></small></label>
                                    <input type="text" id="nomfournisseur" class="form-control" placeholder="Fournisseur" required>
                                    <input type="hidden" id="idfournisseur" class="form-control" name="nomfournisseur">
                                    <ul id="suggestionsListFournisseur" class="list-group mt-2" style="display: none;"></ul>
                                </div>

                                <div class="col-2">
                                    <label for="marque" class="col-form-label">Marque <small><em>**</em></small></label>
                                    <input type="text" id="marque" class="form-control" required>
                                    <input type="hidden" id="idmarque" class="form-control" name="marque">
                                    <ul id="suggestionsListMarque" class="list-group mt-2" style="display: none;"></ul>
                                </div>

                                <div class="col-2">
                                    <label for="id_fr" class="col-form-label">Id depuis Fournisseur</label>
                                    <input type="text" id="id_fr" class="form-control" name="id_fr" >
                                </div>
                                <div class="col-2">
                                    <label for="code" class="col-form-label">Code</label>
                                    <input type="text" id="code" class="form-control" name="code" required>
                                </div>

                                <div class="col-2">
                                    <label for="categorie" class="col-form-label">Catégorie <small><em>**</em></small></label>
                                    <input type="text" id="categorie" class="form-control" placeholder="Catégorie" required>
                                    <input type="hidden" id="idcategorie" class="form-control" name="categorie">
                                    <ul id="suggestionsListCategorie" class="list-group mt-2" style="display: none;"></ul>
                                </div>
                            </div>


                            <div class="form-group row">
                                {{-- <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Devise</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="id_unite_monetaire" disabled>
                                                @foreach ($uniteMonetaire as $devise)
                                                    <option value="{{ $devise->id }}">{{ $devise->unite }}</option>
                                                @endforeach
                                                <option value="">Uniter Monétaire</option>
                                                <option value=""></option>
                                                grisé par défaut, non grisé pour quand emprunt est checked
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Taille Machine</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="id_taille_machine" required>
                                                <option value="">Taille Machine</option>
                                                @foreach($categorie_machine as $taille)
                                                    <option value="{{ $taille->id }}">{{ $taille->taille }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Référence Machine</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="reference" name="reference" class="form-control" placeholder="Référence">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Capacite Machine</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="capacite" name="capacite" class="form-control" placeholder="Capacite">
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="form-row d-flex">
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label" >Coût Prestation</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" id="coutprestation"  name="coutprestation" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="col-12">
                                        <label class="col-form-label">Unité monétaire</label>
                                    </div>
                                    <div class="col-12">
                                        <select class="form-control" name="idUnite" required>
                                            @foreach ( $unite as $u)
                                            <option value="{{ $u->id }}">{{ $u->unite }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label" >Prix Unitaire</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text"  class="form-control"  name="prixu" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row d-flex">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Prendre une photo</label>
                                        </div>
                                        <div class="col-12">
                                            <video id="video" width="320" height="240" autoplay class="mb-2"></video>
                                            <!-- Le canvas est caché par défaut et sera affiché après la capture -->
                                            <canvas id="canvas" width="320" height="240" style="display:none;" class="mb-2"></canvas>

                                            <!-- Boutons alignés sous le canvas -->
                                            <div class="d-flex justify-content-between">
                                                <button type="button" id="snap" class="btn btn-primary mb-1">
                                                    <i class="fas fa-camera"></i> Prendre la photo
                                                </button>
                                                <form id="photo-form" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" id="imageData" name="image">
                                                    {{-- <button type="submit" class="btn btn-success mb-2">
                                                        <i class="fas fa-upload"></i> Envoyer la photo
                                                    </button> --}}

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Image demande -->
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Image Machine <small>importer si on ne prends pas de photos</small></label>
                                        </div>
                                        <div class="col-12">
                                            <label class="custom-file-upload">
                                                <input type="file" class="form-control-file" name="photo_machine">
                                                <i class="fas fa-image"></i> Ajouter une image
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Documentation -->
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Documentation</label>
                                        </div>
                                        <div class="col-12">
                                                <input type="file" class="form-control-file" name="document">
                                            <label class="custom-file-upload">
                                                <i class="fas fa-file"></i> Upload fichier
                                            </label>
                                        </div>
                                    </div>
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
                </div>
            </div>

        </div>
    </div>
</div>
@include('GMAO.boutongmao')

{{-- emprunt --}}
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     const empruntCheckbox = document.getElementById('emprunt');
        //     const dateFinContrat = document.querySelector('input[name="date_fin_contrat"]');
        //     // const devise = document.querySelector('select[name="id_unite_monetaire"]');
        //     const coutPrestation = document.querySelector('input[name="coutprestation"]');

        //     // Fonction pour activer ou désactiver les champs
        //     function toggleFields() {
        //         const isChecked = empruntCheckbox.checked;
        //         dateFinContrat.disabled = !isChecked;
        //         // devise.disabled = !isChecked;
        //         coutPrestation.disabled = !isChecked;
        //     }

        //     // Écouter les changements sur la case à cocher
        //     empruntCheckbox.addEventListener('change', toggleFields);
        //     toggleFields();
        // });


        document.addEventListener('DOMContentLoaded', function() {
            const empruntRadio = document.getElementById('emprunt');
            const proprieteRadio = document.getElementById('propriete');
            const dateFinContrat = document.querySelector('input[name="date_fin_contrat"]');
            const coutPrestation = document.querySelector('input[name="coutprestation"]');

            // Fonction pour activer ou désactiver les champs
            function toggleFields() {
                const isEmprunt = empruntRadio.checked;
                dateFinContrat.disabled = !isEmprunt;
                coutPrestation.disabled = !isEmprunt;
            }

            // Écouter les changements sur les boutons radios
            empruntRadio.addEventListener('change', toggleFields);
            proprieteRadio.addEventListener('change', toggleFields);

            // Initialiser l'état des champs
            toggleFields();
        });
    </script>
{{-- emprunt --}}

{{-- photo --}}
    <script>
        const video = document.querySelector('#video');
        const canvas = document.querySelector('#canvas');
        const snap = document.querySelector('#snap');
        const imageData = document.querySelector('#imageData');

        // Accéder à la caméra
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                video.srcObject = stream;
            });

        // Prendre la photo
        snap.addEventListener('click', () => {
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, 320, 240);
            const dataUrl = canvas.toDataURL('image/png');
            imageData.value = dataUrl;

            // Rendre le canvas visible après la capture
            canvas.style.display = 'block'; // Change l'affichage du canvas
        });

        // Soumettre le formulaire principal d'ajout de machine
        const machineForm = document.querySelector('#machine-form');
        //machineForm.addEventListener('submit', (event) => {
        //  if (!imageData.value) {
            //    alert('Veuillez prendre une photo avant de soumettre le formulaire.');
            //  event.preventDefault();
            //}
        //});
    </script>
{{-- photo --}}

{{-- Start auto-completions --}}
    {{-- fournisseur --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var nomfournisseur = document.getElementById('nomfournisseur');
            var idfournisseur= document.getElementById('idfournisseur');
            var suggestionsList = document.getElementById('suggestionsListFournisseur');

            nomfournisseur.addEventListener('input', function () {
                var query = nomfournisseur.value;

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route("recherche-fournisseur-machine") }}?nomfournisseur=' + encodeURIComponent(query), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var fournisseur = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';
                        if (fournisseur.length > 0) {
                            fournisseur.forEach(function (f) {
                                var li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = f.nom_fournisseur;
                                li.addEventListener('click', function () {
                                    nomfournisseur.value = f.nom_fournisseur;
                                    idfournisseur.value = f.id_fournisseur;
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
                if (!nomfournisseur.contains(event.target) && !suggestionsList.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        });
    </script>
    {{-- fournisseur --}}

    {{-- marquemachine --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var marque = document.getElementById('marque');
            var idmarque= document.getElementById('idmarque');
            var suggestionsList = document.getElementById('suggestionsListMarque');

            marque.addEventListener('input', function () {
                var query = marque.value;

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route("findmarquemachine") }}?marque=' + encodeURIComponent(query), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var marque_machine = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';
                        if (marque_machine.length > 0) {
                            marque_machine.forEach(function (f) {
                                var li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = f.marque;
                                li.addEventListener('click', function () {
                                    marque.value = f.marque;
                                    idmarque.value = f.id;
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
                if (!marque.contains(event.target) && !suggestionsList.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        });
    </script>
    {{-- marquemachine --}}

    {{-- categoriemachine--}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var categorie = document.getElementById('categorie');
            var idcategorie= document.getElementById('idcategorie');
            var suggestionsList = document.getElementById('suggestionsListCategorie');

            categorie.addEventListener('input', function () {
                var query = categorie.value;

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route("findcategoriemachine") }}?categorie=' + encodeURIComponent(query), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var categorie_machine = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';
                        if (categorie_machine.length > 0) {
                            categorie_machine.forEach(function (f) {
                                var li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = f.categorie;
                                li.addEventListener('click', function () {
                                    categorie.value = f.categorie;
                                    idcategorie.value = f.id;
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
                if (!categorie.contains(event.target) && !suggestionsList.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        });
    </script>
    {{-- categoriemachine --}}
{{-- end auto-completions --}}


@include('CRM.footer')
