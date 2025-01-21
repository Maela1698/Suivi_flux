@include('CRM.header')
@include('CRM.sidebar')
<title>FDCApercu</title>

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
<style>
    .checkbox-container {
        display: flex;
        flex-wrap: wrap;
    }

    .checkbox-item {
        flex: 0 0 23%;
        /* Répartir en quatre colonnes */
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
    }

    .checkbox-item input[type="checkbox"] {
        margin-right: 10px;
        /* Espacement entre le checkbox et le texte */
    }

    .checkbox-item label {
        margin: 0;
        /* Réinitialiser les marges du label */
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
    body {
        font-family: Arial, sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .caracteristiques {
        text-align: left;
    }

    .checkbox-label {
        display: block;
        margin-bottom: 4px;
    }

    .checkbox-label input {
        margin-right: 8px;
    }

    .graph {
        height: 50px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }

    .conso-bar {
        background-color: #00c8ff;
    }

    .eff-bar {
        background-color: #ffc000;
    }
</style>



<script>
    function exportToPDF() {
        const element = document.getElementById("sdcpdf");

        // Options de configuration pour html2pdf
        const options = {
            filename: 'FDC_{{ $demande[0]->nom_modele }}_{{ $demande[0]->nomtier }}_{{ $demande[0]->type_stade }}.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'mm',
                format: 'a3',
                orientation: 'portrait'
            }
        };

        // Utilisez html2pdf pour exporter l'élément en PDF
        html2pdf().set(options).from(element).save();
    }
</script>

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('DEV.headerDEV')
        <div class="row">
            <div id="sdcpdf" class="card col-12">
                <div class="card-body row" style="display: flex; align-items: center;border-bottom: solid 1px gray">
                    <div class="col-2">
                        <div class="image"><img src="./images/logoLoi.jpeg" alt="" width="50px"
                                height="50px"></div>
                    </div>
                    <div class="col-6"
                        style="margin-left: 100px;border: solid,1px; width: 600px;height: 20px;text-align: center">
                        <div class="client">
                            <h6>FICHE CONSO : {{ $demande[0]->nomtier }}</h6>
                        </div>
                    </div>
                </div>
                <center>
                    <div class="row mt-3" style="border-bottom: solid 1px gray;font-size: 10px;height: 100px;">

                        <div class="col-4">
                            <div class="card-body" style="margin-left: 60px;margin-top: -20px;">
                                <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>CLIENT :</b>
                                    {{ $demande[0]->nomtier }}</p>
                                <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>SAISON</b>
                                    {{ $demande[0]->type_saison }}</p>
                                <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>MODELE :</b>
                                    {{ $demande[0]->nom_modele }}</p>
                                <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>STADE :</b>
                                    {{ $demande[0]->type_stade }}</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-validation">
                                <div class="image" style="margin-top: -10px;margin-right: 10px;"><img
                                        src="data:image/png;base64,{{ $demande[0]->photo_commande }}" alt=""
                                        width="100px" height="100px"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card-body" style="margin-left: 60px;margin-top: -30px;">
                                <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>Date de creation :</b>
                                    {{ \Carbon\Carbon::parse($demande[0]->date_entree)->format('d/m/y') }} </p>
                                <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>Merch :</b>
                                    @if (!empty($tier[0]->merchsenior))
                                        {{ $tier[0]->merchsenior }}
                                    @elseif (!empty($tier[0]->merchjunior))
                                        {{ $tier[0]->merchjunior }}
                                    @elseif (!empty($tier[0]->assistant))
                                        {{ $tier[0]->merchjunior }}
                                    @else
                                        Pas de merch
                                    @endif
                                <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>Placeur :</b>
                                </p>
                                <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>Methode :</b>
                                </p>
                                <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>Validé par :</b>
                                </p>
                            </div>
                        </div>
                    </div>
                </center>
                <br>
                <center>
                    <table class="table table-bordered"
                        style="border: 1px solid; border-collapse: collapse;width: 500px;font-size: 10px;">
                        <thead>
                            <tr>
                                <th scope="col" style="border: 1px solid;"><strong>TAILLE</strong></th>
                                @for ($i = 0; $i < count($detailTaille); $i++)
                                    <th scope="col" style="border: 1px solid;">{{ $detailTaille[$i]->unite_taille }}
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid;"><strong>QUANTITE</strong></td>
                                @for ($j = 0; $j < count($detailTaille); $j++)
                                    <th scope="col" style="border: 1px solid;">{{ $detailTaille[$j]->quantite }}
                                    </th>
                                @endfor
                            </tr>
                        </tbody>
                    </table>
                </center>


                <div class="form-validation" style=" width: 100%;text-align: center;background-color: #509baf;">
                    <div class="client">
                        <h6>CONSO TISSU</h6>
                    </div>
                </div>

                <center>
                    <table style="border: 1px solid; border-collapse: collapse; font-size: 10px;">
                        <thead>
                            <tr>
                                <th>TISSU</th>
                                <th>CARACTERISTIQUES</th>
                                <th>RETRAIT</th>
                                <th>CONSO</th>
                                <th>EFF %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($t = 0; $t < count($tissu); $t++)
                                <tr>
                                    <td><b style="color: #000000;">{{ $tissu[$t]->type_tissus }}</b></td>
                                    <td class="caracteristiques">
                                        <div class="paragraphe"
                                            style="border-bottom: 1px solid lightgray; flex: 1 1 10%; display: grid; grid-template-columns: repeat(6, 1fr); gap: 5px;">
                                            <p><span style="color: #000000;">DESIGNATION:</span>
                                                <b style="color: #000000;">{{ $tissu[$t]->designation }}</b>
                                            </p>
                                            <p><span style="color: #000000;">REFERENCE:</span><b
                                                    style="color: #000000;">{{ $tissu[$t]->reference }}</b>
                                            </p>
                                            <p><span style="color: #000000;">COMPOSITION:</span><b
                                                    style="color: #000000;">{{ $tissu[$t]->composition_tissus }}</b>
                                            </p>
                                            <p><span style="color: #000000;">COULEUR:</span><b
                                                    style="color: #000000;">{{ $tissu[$t]->couleur }}</b>
                                            </p>
                                            <p><span style="color: #000000;">LAIZE:</span>
                                                <b style="color: #000000;">{{ $tissu[$t]->laize_utile }}
                                                    {{ $tissu[$t]->unite_mesure }}</b>
                                            </p>
                                            <p><span style="color: #000000;">GRAMMAGE:</span><b
                                                    style="color: #000000;">{{ $tissu[$t]->grammage }}g</b>
                                            </p>
                                        </div>

                                        <div class="check"
                                            style=" flex: 1 1 10%; display: grid; grid-template-columns: repeat(8, 1fr); gap: 8px;margin-top: 10px;">
                                            @for ($d = 0; $d < count($caracteristique); $d++)
                                                <label class="checkbox-label"><input type="checkbox"
                                                        id="caracteristiqueT{{ $idDC }}{{ $d }}{{ $tissu[$t]->id }}"
                                                        disabled>{{ $caracteristique[$d]->caracteristique }}</label>
                                            @endfor
                                        </div>

                                    </td>
                                    <td>
                                        <span>Retrait Lavage : </span><br><b style="color: #000000;">L-
                                            {{ $tissu[$t]->l_retrait_lavage }}%
                                            W-{{ $tissu[$t]->w_retrait_lavage }}%</b><br>
                                        <span>Retrait Teinture : </span><br><b
                                            style="color: #000000;">L-{{ $tissu[$t]->l_retrait_teinture }}%
                                            W-{{ $tissu[$t]->w_retrait_teinture }}%</b>
                                    </td>
                                    @for ($v = 0; $v < count($consoTissu); $v++)
                                        @if ($consoTissu[$v]->id_tissus == $tissu[$t]->id)
                                            <td style="background-color:lightblue;">
                                                <div style="color: black;"><b
                                                        style="color: #000000;">{{ $consoTissu[$v]->conso_tissus }}</b>
                                                </div>
                                            </td>
                                            <td style="background-color:lightyellow;">
                                                <div style="color: black;"><b
                                                        style="color: #000000;">{{ $consoTissu[$v]->efficience_tissus }}
                                                        %</b></div>
                                            </td>
                                        @endif
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>

                    </table>
                </center>



                <div class="form-validation mt-2" style=" width: 100%;text-align: center;background-color: #509baf;">
                    <div class="client">
                        <h6>CONSO ACCESOIRES</h6>
                    </div>
                </div>

                <center>
                    <table style="border: 1px solid; border-collapse: collapse; font-size: 10px;">
                        <thead>
                            <tr>
                                <th>FAMILLE</th>
                                <th>CARACTERISTIQUES</th>
                                <th>TAILLE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($a = 0; $a < count($accessoire); $a++)


                                <tr>
                                    <td><b><span style="color: #000000;">
                                                {{ $accessoire[$a]->type_accessoire }}</b></span></td>
                                    <td class="caracteristiques">
                                        <div class="paragraphe"
                                            style="border-bottom: 1px solid lightgray; flex: 1 1 10%; display: grid; grid-template-columns: repeat(4, 1fr); gap: 5px;">
                                            <p><span style="color: #000000;">DESIGNATION:
                                                    <b>{{ $accessoire[$a]->designation }}</b></span></p>
                                            <p><span
                                                    style="color: #000000;">REFERENCE:<b>{{ $accessoire[$a]->reference }}</b></span>
                                            </p>
                                            <p><span
                                                    style="color: #000000;">COULEUR:<b>{{ $accessoire[$a]->couleur }}</b></span>
                                            </p>
                                            <p><span style="color: #000000;">UTILISATION:
                                                    <b>{{ $accessoire[$a]->utilisation }}</b></span></p>
                                        </div>

                                        <div class="check"
                                            style=" flex: 1 1 10%; display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;margin-top: 10px;">
                                            @for ($l = 0; $l < count($dispo); $l++)
                                                <label class="checkbox-label">
                                                    <input type="checkbox"
                                                        id="dispoAccy{{ $idDC }}{{ $l }}{{ $accessoire[$a]->id }}"
                                                        disabled>{{ $dispo[$l]->disposition }}
                                                </label>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>
                                        <div
                                            style=" flex: 1 1 20%; display: grid; grid-template-columns: repeat(8, 1fr); gap: 8px;font-size: 10px;">
                                            @for ($d = 0; $d < count($detailTaille); $d++)
                                                <label><b>{{ $detailTaille[$d]->unite_taille }}</b>
                                                    @if (count($consoAccy) > 0)
                                                        @for ($consoA = 0; $consoA < count($consoAccy); $consoA++)
                                                            @if (
                                                                $consoAccy[$consoA]->id_unite_taille == $detailTaille[$d]->id_unite_taille &&
                                                                    $accessoire[$a]->id == $consoAccy[$consoA]->id_accessoire)
                                                                <b>/</b>
                                                                <b> {{ $consoAccy[$consoA]->conso_accessoire }}
                                                                    {{ $accessoire[$a]->unite_mesure }}</b>
                                                </label>
                                            @endif
                            @endfor
                            @endif
                            </label>
                            @endfor
            </div>
            </td>
            </tr>
            @endfor
            </tbody>
            </table>
            </center>

        </div>
        <div class="form-group row">
            <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                <button type="submit" onclick="exportToPDF()" class="btn btn-success mr-3">Telecharger</button>

                <form action="{{ route('DEV.fdc') }}" method="get">
                    <button type="submit" class="btn btn-info">Retour</button>
                </form>
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

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
