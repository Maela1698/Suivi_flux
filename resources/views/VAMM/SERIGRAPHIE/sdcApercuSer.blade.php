<title>SDCApercu</title>
<style>
    .checkbox-container {
        display: flex;
        flex-wrap: wrap;
    }
    .checkbox-item {
        flex: 0 0 23%; /* R�partir en quatre colonnes */
        margin: 1%; /* Espacement entre les checkboxes */
        box-sizing: border-box; /* Inclure les marges dans la taille totale */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        display: flex;
        align-items: center;
    }
    .checkbox-item input[type="checkbox"] {
        margin-right: 10px; /* Espacement entre le checkbox et le texte */
    }
    .checkbox-item label {
        margin: 0; /* R�initialiser les marges du label */
    }
    .checkbox-item:hover {
        background-color: #e6f7ff;
        border-color: #007bff;
    }
    .requete{
        height:  100px;
    }
</style>

@include('CRM.header')
@include('CRM.sidebar')

<title>SDCApercu</title>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    function exportToPDF() {
        const element = document.getElementById("sdcpdf");

        const options = {
            filename: 'SDC_{{ $detaildemande[0]->nom_modele }}_{{ $detaildemande[0]->nomtier }}_{{ $detaildemande[0]->type_stade }}.pdf',
            image: {type: 'jpeg', quality: 0.98},
            html2canvas: {scale: 2},
            jsPDF: {unit: 'mm', format: 'a3', orientation: 'portrait'}
        };

        html2pdf().set(options).from(element).save();
    }
</script>

<div class="content-body">
    <div class="container-fluid mt-3">
        @include('VAMM.headerVAMM')
        <div id="sdcpdf" class="card col-12">
            <div class="card-body row" style="display: flex; align-items: center;border-bottom: solid 1px gray">
                <div class="col-2">
                    <div class="image"><img src="./images/NEW LOGO.png" alt="" width="70px"
                            height="50px"></div>
                </div>
                <div class="col-6"
                style="margin-left: 100px;border: solid,1px; width: 600px;height: 20px;text-align: center">
                    <div class="client"><h6>SAMPLE DEMANDE CLIENT : {{ $detaildemande[0]->nomtier }}</h6></div>
                </div>
            </div>
            <center>
                <div class="row mt-3" style="border-bottom: solid 1px gray;font-size: 12px;height: 100px;margin-top: -50px;height: 75px;">

                    <div class="col-4">
                        <div class="card-body" style="margin-left: 60px;margin-top: -40px;">
                            <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>CLIENT : </b>{{ $detaildemande[0]->nomtier }}</p>
                            <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>SAISON : </b>{{ $detaildemande[0]->type_saison }}</p>
                            <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>MODELE : </b>{{ $detaildemande[0]->nom_modele }}</p>
                            <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>STADE : </b>{{ $detaildemande[0]->type_stade }}</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-validation">
                            <div class="image" style="margin-top: -16px;margin-right: 10px;"><img src="data:image/png;base64,{{ $detaildemande[0]->photo_commande }}" class="img-fluid rounded-start mb-5" alt="Logo" width="50px" height="50px"></div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card-body" style="margin-left: 60px;margin-top: -40px;">

                            @if($sdc && $sdc->date_envoie)
                                <p class="texte" style="text-align: left;margin-bottom: 3px;">
                                    <b>Date de creation : </b>{{ \Carbon\Carbon::parse($sdc->date_entree)->format('d/m/y') }}
                                </p>
                            @endif
                            @if($sdc && $sdc->date_envoie)
                                <p class="texte" style="text-align: left;margin-bottom: 3px;">
                                    <b>Date d'envoie client: </b>{{ \Carbon\Carbon::parse($sdc->date_envoie)->format('d/m/y') }}
                                </p>
                            @endif
                            <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>Merch Senior :</b>
                                @if (!empty($tier[0]->merchsenior))
                                      {{ $tier[0]->merchsenior }}
                                @endif
                              </p>
                            <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>Merch Junior :</b>
                                 @if (!empty($tier[0]->merchjunior))
                                 {{ $tier[0]->merchjunior }}
                                   @endif
                                </p>
                        </div>
                    </div>
                </div>
            </center>

            <center>
                <table class="table table-bordered" style="border: 1px solid; border-collapse: collapse;width: 500px;font-size: 12px;">
                    <thead style="color: black;">
                        <tr>
                            <th scope="col" style="border: 1px solid;">Taille</th>
                            <th scope="col" style="border: 1px solid;">Quantité totale</th>
                            <th scope="col" style="border: 1px solid;">Quantité Client</th>
                            <th scope="col" style="border: 1px solid;">Keep</th>
                        </tr>
                    </thead>
                    <tbody style="color: black;">
                        @foreach ($detailsdc as $ds)
                        <tr>
                            <td style="border: 1px solid;">{{ $ds->unite_taille }}</td>
                            <td style="border: 1px solid;">{{ $ds->qte_total }}</td>
                            <td style="border: 1px solid;">{{ $ds->qte_client }}</td>
                            <td style="border: 1px solid;">{{ $ds->keep }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </center>


            <div class="form-validation" style=" width: 100%;text-align: center;background-color: #509baf;margin-top: -16px;height: 15px;">
                <div class="client"><h6>TISSU</h6></div>
            </div>

            <center>
                <table class="table table-bordered" style="border: 1px solid; border-collapse: collapse; font-size: 12px;">
                    <thead>
                        <tr>
                            <th>a</th>
                            <th>b</th>
                            <th>c</th>
                            <th>d</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tissus as $ti)
                        <tr style="text-align: center;">
                            <td style="border: 1px solid; flex: 1 1 5%; display: grid; grid-template-columns: repeat(10, 1fr); gap: 11px;">
                                <p><strong style="color: #000000;">{{ $ti->type_tissus }}</strong> </p>
                                <p>DES: <strong style="color: #000000;">{{ $ti->designation }}</strong> </p>
                                <p>REF:<strong style="color: #000000;">{{ $ti->reference }}</strong> </p>
                                <p>COMPO:<strong style="color: #000000;">{{ $ti->composition_tissus }}</strong> </p>
                                <p>COULEUR:<strong style="color: #000000;">{{ $ti->couleur }}</strong> </p>
                                <p>LAIZE:<strong style="color: #000000;">{{ $ti->laize_utile }}</strong> </p>
                                <p>GRAMMAGE:<strong style="color: #000000;">{{ $ti->grammage }}</strong> </p>
                            </td>
                            <td style=" flex: 1 1 5%;"> <img src="data:image/png;base64,{{ $ti->photo }}" alt="" style="width: 30px; height: auto;"></td>
                            <td style="flex: 1 1 10%; display: grid; grid-template-columns: repeat(5, 1fr); gap: 5px; width: -20px;">

                                @foreach($dispomat as $dm)
                                <div class="form-check" style="display: flex; align-items: center; font-size: 12px; border: none;">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value=""
                                        id="flexCheck{{ $ti->type_tissus }}{{ $detaildemande[0]->id }}{{ $dm->id }}"
                                        style="transform: scale(0.75); margin-right: 4px;"
                                        onchange="saveCheckboxState('{{ $dm->id }}')">
                                    <label style="color: #000000;" class="form-check-label" for="flexCheck{{ $dm->id }}">
                                        {{ $dm->disposition }}
                                    </label>
                                </div>
                                @endforeach
                            </td>
                            <td style="border: 1px solid; flex: 1 1 20%;">
                                <textarea id="commentaires{{ $ti->type_tissus }}{{ $dm }}"  name="commentaire" placeholder="Commentaire" style="width: 100%;height:10px ; resize: both; border: none; border-bottom: solid 1px lightgrey; font-size: 12px;"></textarea>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </center>



            <div class="form-validation" style=" width: 100%;text-align: center;background-color: #509baf;margin-top: -16px;height: 15px;">
                <div class="client"><h6>ACCESOIRES</h6></div>
            </div>

            <center>
                <table class="table table-bordered" style="border: 1px solid; border-collapse: collapse; font-size: 12px;">
                    <tbody>
                        @foreach($accessoire as $acc)
                        <tr style="display: flex; flex-wrap: wrap;">

                            <td style="border: 1px solid; flex: 1 1 5%; display: grid; grid-template-columns: repeat(10, 1fr); gap: 5px;">
                                 <p><strong style="color: #000000;">{{ $acc->type_accessoire }}</strong> </p>
                                <p>DESIGNATION:<strong style="color: #000000;">{{ $acc->designation }}</strong> </p>
                                <p>REFERENCE:<strong style="color: #000000;">{{ $acc->reference }}</strong> </p>
                                <p>UTILISATION:<strong style="color: #000000;">{{ $acc->utilisation }}</strong> </p>
                                <p>COULEUR:<strong style="color: #000000;">{{ $acc->couleur }}</strong> </p>
                            </td>
                            <td style="border: 1px solid; flex: 1 1 5%;"> <img  src="data:image/png;base64,{{ $acc->photo }}" alt="" style="width: 30px; height: auto;"></td>
                            <td style="border: 1px solid; flex: 1 1 10%; display: grid; grid-template-columns: repeat(5, 1fr); gap: 5px; width: -20px;">

                                @foreach($dispomat as $dm)
                                <div class="form-check" style="display: flex; align-items: center; font-size: 12px;">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value=""
                                        id="flexCheck{{ $acc->type_accessoire }}{{ $detaildemande[0]->nomtier }}{{ $dm->id }}"
                                        style="transform: scale(0.75); margin-right: 4px;"
                                        onchange="saveCheckboxState('{{ $dm->id }}')">
                                    <label style="color: #000000;" class="form-check-label" for="flexCheck{{ $dm->id }}">
                                        {{ $dm->disposition }}
                                    </label>
                                </div>
                                @endforeach

                            </td>
                            <td style="border: 1px solid; flex: 1 1 20%;">
                                <textarea id="commentaires{{ $acc->type_accessoire }}{{ $dm }}"  name="commentaire" placeholder="Commentaire" style="width: 100%;height:10px ; resize: both; border: none; border-bottom: solid 1px lightgrey; font-size: 12px;"></textarea>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </center>



            <div class="form-validation" style=" width: 100%;text-align: center;background-color: #509baf;font-size: 12px;margin-top: -16px;height: 15px;">
                <div class="client"><h6>VALEUR AJOUTEE</h6></div>
            </div>

            <div style="font-size: 12px;">
                <strong style="color: #000000;">LAVAGE:</strong>
                @foreach($lavage as $la)
                <strong style="color: #000000;">{{ $la->type_lavage }},</strong>
                @endforeach

            </div>

            <div style="font-size: 12px;">
                <strong style="color: #000000;">AUTRE VALEUR AJOUTEE:</strong>
                @foreach ($valeur as $va)
                <strong style="color: #000000;">{{ $va->type_valeur_ajoutee }},</strong>
                @endforeach
            </div>


        </div>



    <!-- #/ container -->
</div>


<style>
    .fixed-top-right {
    position: fixed;
    top: 0;
    right: 0;
    margin-top: 160px; /* Optionnel, pour donner un petit espace par rapport au bord */
    margin-right: 25px;
    z-index: 1000; /* Assure que le div reste au-dessus des autres éléments */
    }
    .settings-icon {
    font-size: 1.5rem; /* Taille de l'icône */
    cursor: pointer; /* Curseur pointeur au survol */
    color: #495057; /* Couleur de l'icône */
    transition: transform 0.5s ease-in-out; /* Transition pour la rotation */
    }

    .settings-icon:hover {
        transform: rotate(180deg); /* Rotation au survol */
    }

    .custom-card {
        background-color: #343a40; /* Couleur de fond foncée */
        border-radius: 8px; /* Bordure arrondie */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ombre pour un effet de relief */
        display: none; /* Caché par défaut */
        margin-top: 10px; /* Espacement entre l'icône et le menu */
    }

    .custom-card .btn {
        width: 100%; /* Assure que les boutons prennent toute la largeur */
        text-align: left; /* Aligne le texte et l'icône à gauche */
        color: #fff; /* Couleur du texte blanche */
        background-color: #495057; /* Couleur de fond des boutons */
        border: none; /* Supprime la bordure */
        transition: background-color 0.3s; /* Transition douce pour le changement de couleur */
    }

    .custom-card .btn:hover {
        background-color: #6c757d; /* Changement de couleur au survol */
    }

    .custom-card i {
        margin-right: 8px; /* Espace entre l'icône et le texte */
    }
</style>

    @include('VAMM.SERIGRAPHIE.parametreSer')



<script>
    document.getElementById('settings-icon').addEventListener('mouseover', function() {
    document.getElementById('settings-menu').style.display = 'block';
    });

    document.getElementById('settings-menu').addEventListener('mouseleave', function() {
        document.getElementById('settings-menu').style.display = 'none';
    });
</script>



<script>
    // Fonction pour charger le contenu sauvegardé dans localStorage
    function loadInputs() {
        // Charger les textareas
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            const savedText = localStorage.getItem(textarea.id);
            if (savedText) {
                textarea.value = savedText;
            }
        });

        // Charger les checkboxes
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            const savedState = localStorage.getItem(checkbox.id);
            if (savedState !== null) {
                checkbox.checked = JSON.parse(savedState);
            }
        });
    }

    // Fonction pour sauvegarder le contenu des inputs dans localStorage
    function saveInputs() {
        // Sauvegarder les textareas
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            textarea.addEventListener('input', function() {
                localStorage.setItem(textarea.id, textarea.value);
            });
        });

        // Sauvegarder les checkboxes
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                localStorage.setItem(checkbox.id, checkbox.checked);
            });
        });
    }

    // Charger les données au chargement de la page
    window.onload = function() {
        loadInputs();
        saveInputs();
    }
</script>


@include('CRM.footer')
