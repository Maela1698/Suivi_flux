<style>
    .entete {
        color: #7571f9;
        /* Ajuster la couleur du texte si n�cessaire */
        background-color: white;
    }

    .carte {
        color: white;
        /* Ajuster la couleur du texte si n�cessaire */
        background-color: white;
    }

    .texte {
        color: black;
    }

    .table {
        color: black;
    }

    .qte {
        height: 50px;
        width: 100px;
    }

    .checkbox-container {
        display: flex;
        flex-wrap: wrap;
    }

    .checkbox-item {
        flex: 0 0 19%;
        /* R�partir en quatre colonnes */
        margin: 1%;
        /* Espacement entre les checkboxes */
        box-sizing: border-box;
        /* Inclure les marges dans la taille totale */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        display: flex;
        align-items: center;
        color: black;
    }

    .checkbox-item input[type="checkbox"] {
        margin-right: 10px;
        /* Espacement entre le checkbox et le texte */
    }

    .checkbox-item label {
        margin: 0;
        /* R�initialiser les marges du label */
    }

    .checkbox-item:hover {
        background-color: #e6f7ff;
        border-color: #007bff;
    }

    .requete {
        height: 100px;
    }
</style>
<style>
    .custom-tooltip .tooltip-inner {
        background-color: #f8d7da;
        /* Couleur de fond */
        color: #721c24;
        /* Couleur du texte */
        font-size: 16px;
        /* Taille du texte */
        padding: 10px;
        /* Espacement */
    }

    .custom-tooltip .arrow::before {
        border-top-color: #f8d7da;
        /* Couleur de la fl�che */
    }
</style>
@include('CRM.header')
@include('CRM.sidebar')


<div class="content-body">
    <div class="container-fluid mt-3">
        @include('Planning.headerPlan')
        <div class="row">

            <div class="card col-md-12" >
                <div class="card-header d-flex justify-content-between align-items-center entete">
                    <h3 class="entete">AJOUT MACRO</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('macrocharge.store') }}" method="post" autocomplete="off">
                        @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="utilisation" class="col-form-label" style="color: rgb(105, 102, 102);">Macro</label>
                                        <select class="form-control" id="macro" name="macro" required>
                                            <option value="" selected>Sélectionner un type de macro</option>
                                            @if(!empty($type_macro))
                                                @foreach($type_macro as $t)
                                                    <option value="{{ $t->id_type_macro }}"
                                                        {{ (old('type_macro') ?? request()->type_macro) == $t->type_macro ? 'selected' : '' }}>
                                                        {{ $t->type_macro }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="utilisation" class="col-form-label" style="color: rgb(105, 102, 102);">Mois</label>
                                        <select class="form-control" id="mois" name="mois" required>
                                            <option value="" selected>Sélectionner un mois</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="smvprod" class="col-form-label" style="color: rgb(105, 102, 102);">Année
                                            <small><em style="color:#ccc;">(Veuillez insérer une année ci-dessous 20XX)</em></small>
                                        </label>
                                        <input type="text" class="form-control" id="annee" name="annee" value="" placeholder="">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="smvprod" class="col-form-label" style="color: rgb(105, 102, 102);">Jour ouvrables
                                            <small><em style="color:#ccc;">(modifiable)</em></small>
                                        </label>
                                        <input type="text" class="form-control" id="jours_ouvrables" name="jours_ouvrables" value="" >
                                        {{-- readonly --}}
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">

                                <div class="col-md-4" id="absence-container">
                                    <div class="form-group">
                                        <label for="couleur" class="col-form-label" style="color: rgb(105, 102, 102);">Taux d'absence
                                            <small><em> (=3.60%)</em><em style="color:#ccc;"> (modifiable)</em></small>
                                        </label>
                                        <input type="text" class="form-control" id="absence" name="absence" value="0.036">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="utilisation" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Heure de travail<small><em style="color:#ccc;"> (modifiable)</em></small></label>
                                            <input type="text" class="form-control" id="heuret" name="heuret"
                                            value="8">

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="utilisation" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Heure supp<small><em style="color:#ccc;"> (modifiable)</em></small></label>
                                            <input type="text" class="form-control" id="heuresup" name="heuresup"
                                            value="0">

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="effectif" class="col-form-label" style="color: rgb(105, 102, 102);">Effectif</label>
                                        <input type="text" class="form-control" id="effectif" name="effectif" value="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="efficience" class="col-form-label" style="color: rgb(105, 102, 102);">Efficience/Rendement</label>
                                        <input type="text" class="form-control" id="efficience" name="efficience" value="">
                                    </div>
                                </div>
                                <div class="col-md-4" id="besoin-effectif-container" style="display:none;">
                                    <div class="form-group">
                                        <label for="besoin_effectif" class="col-form-label" style="color: rgb(105, 102, 102);">Besoin en effectif</label>
                                        <input type="text" class="form-control" id="besoin_effectif" name="besoin_effectif" value="">
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
                                    <a href="{{ route('LRP.listeData') }}" class="btn btn-info mr-3">Retour</a>
                                    <button type="submit" class="btn btn-success mr-3">Ajouter</button>

                                </div>
                            </div>
                    </form>
                </div>


            </div>
        </div>
    </div>

    <!-- Modale de confirmation -->


</div>
</div>
<!-- #/ container -->
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        console.log('Script chargé et prêt.');

        // Configurer le token CSRF pour toutes les requêtes AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log('Token CSRF configuré.');

        // Déclencher la requête AJAX lors de la modification du mois ou de l'année
        $('#mois, #annee').on('input change', function() {
            console.log('Changement détecté dans le mois ou l\'année.');

            var mois = $('#mois').val();   // Valeur du mois sélectionné
            var annee = $('#annee').val(); // Valeur de l'année entrée

            console.log('Mois sélectionné :', mois);
            console.log('Année entrée :', annee);

            if (mois && annee) {
                console.log('Lancement de la requête AJAX.');

                $.ajax({
                    url: "{{ route('joursouvrables.count') }}", // Assurez-vous que cette route est correcte
                    type: "GET",
                    data: {
                        mois: mois,
                        annee: annee
                    },
                    success: function(response) {
                        console.log('Réponse AJAX reçue :', response);

                        // Si la réponse contient le nombre de jours ouvrables
                        if (response.joursOuvrables !== undefined) {
                            console.log('Jours ouvrables trouvés :', response.joursOuvrables);
                            $('#jours_ouvrables').val(response.joursOuvrables); // Remplir l'input des jours ouvrables
                        } else {
                            console.log('Jours ouvrables non définis dans la réponse.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur AJAX:', status, error); // Afficher une erreur si la requête échoue
                    }
                });
            } else {
                console.log('Mois ou année non renseignés.');
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const macroSelect = document.getElementById('macro');

        macroSelect.addEventListener('change', function() {
            const selectedMacroType = this.value;
            const csrfToken = '{{ csrf_token() }}'; // Token CSRF pour la requête

            // Créer un objet FormData pour envoyer les données
            const formData = new FormData();
            formData.append('type_macro', selectedMacroType);
            formData.append('_token', csrfToken);

            // Faire une requête AJAX
            fetch('{{ route('get.macro.data') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                document.getElementById('effectif').value = data.effectif || '';
                document.getElementById('efficience').value = data.efficience || '';
                document.getElementById('absence').value = data.absence || '';


                 const absenceContainer = document.getElementById('absence-container');
                if (data.absence !== null) {
                    document.getElementById('absence').value = data.absence;
                    absenceContainer.style.display = 'block'; // Afficher le champ
                } else {
                    absenceContainer.style.display = 'none'; // Cacher le champ
                }

                const besoinEffectifContainer = document.getElementById('besoin-effectif-container');
                if (data.besoin_effectif !== null) {
                    document.getElementById('besoin_effectif').value = data.besoin_effectif;
                    besoinEffectifContainer.style.display = 'block'; // Afficher le champ
                } else {
                    besoinEffectifContainer.style.display = 'none'; // Cacher le champ
                }

            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    });
</script>

@include('CRM.footer')
