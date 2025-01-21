@include('CRM.header')
@include('CRM.sidebar')
<title>InsertFDC</title>

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
            filename: 'SDC_{{ $demande[0]->nomtier }}.pdf',
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
        @include('CRM.headerCrm')
        <form action="{{ route('CRM.ajoutCaractereTissu') }}" method="POST">
        <div class="row">
            <div id="sdcpdf" class="card col-12">
                <div class="card-header d-flex justify-content-center align-items-center entete">
                    <h3 class="entete">AJOUT CONSO</h3>
                </div>
                <br>
                <div>
                    <h6>Date de creation : </h6>
                </div>
                <div>
                    <h6>Demande de Client :
                        {{ $demande[0]->nomtier }}_{{ $demande[0]->nom_modele }}_{{ $demande[0]->type_stade }}</h6>
                </div>
                <br>


                <div class="form-validation" style=" width: 100%;text-align: center;background-color: #509baf;">
                    <div class="client">
                        <h6>CONSO TISSU</h6>
                    </div>
                </div>

                <center>
                    <table style="border: 1px solid; border-collapse: collapse; font-size: 10px;">
                        <thead>
                            <tr>
                                <th>TISSUS</th>
                                <th>CARACTERISTIQUES</th>
                                <th>RETRAIT</th>
                                <th>CONSO</th>
                                <th>EFF %</th>
                                <th>Edit</th>
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

                                            @csrf
                                            <div class="check"
                                                style="flex: 1 1 10%; display: grid; grid-template-columns: repeat(8, 1fr); gap: 8px;margin-top: 10px;">
                                                @for ($d = 0; $d < count($caracteristique); $d++)
                                                    <label class="checkbox-label"><input type="checkbox"
                                                            name="caractere{{ $tissu[$t]->id }}[]"
                                                            id="caracteristiqueT{{ $idDC }}{{ $d }}{{ $tissu[$t]->id }}"
                                                            value="{{ $caracteristique[$d]->id }}">{{ $caracteristique[$d]->caracteristique }}</label>
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
                                                        style="color: #000000;">{{ number_format($consoTissu[$v]->conso_tissus, 3, '.', ' ') }}</b>
                                                </div>
                                            </td>
                                            <td style="background-color:lightyellow;">
                                                <div style="color: black;"><b
                                                        style="color: #000000;">{{ number_format($consoTissu[$v]->efficience_tissus, 3, '.', ' ') }}
                                                        %</b></div>
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-warning btn-edit"
                                                    data-toggle="modal" data-target="#editTiersModal"
                                                    data-id="{{ $consoTissu[$v]->id }}"
                                                    data-conso="{{ $consoTissu[$v]->conso_tissus }}"
                                                    data-idtissus="{{ $tissu[$t]->id }}"
                                                    data-demandeclient="{{ $demande[0]->id }}"
                                                    data-efficience="{{ $consoTissu[$v]->efficience_tissus }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        @endif
                                    @endfor
                                </tr>
                                 <input type="hidden" name="tissu[]" value="{{ $tissu[$t]->id }}">
                            @endfor
                        </tbody>

                    </table>



                </center>



                <div class="form-validation" style=" width: 100%;text-align: center;background-color: #509baf;">
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
                                <th>Edit</th>
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
                                                <label class="checkbox-label"><input type="checkbox"
                                                        id="dispoAccy{{ $idDC }}{{ $l }}{{ $accessoire[$a]->id }}">{{ $dispo[$l]->disposition }}</label>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>
                                        <div
                                            style=" flex: 1 1 20%; display: grid; grid-template-columns: repeat(8, 1fr); gap: 8px;font-size: 10px;">
                                            @for ($d = 0; $d < count($detailTaille); $d++)
                                                <label>{{ $detailTaille[$d]->unite_taille }}
                                                    @if (count($consoAccy) > 0)
                                                        @for ($consoA = 0; $consoA < count($consoAccy); $consoA++)
                                                            @if (
                                                                $consoAccy[$consoA]->id_unite_taille == $detailTaille[$d]->id_unite_taille &&
                                                                    $accessoire[$a]->id == $consoAccy[$consoA]->id_accessoire)
                                                                /{{ $consoAccy[$consoA]->conso_accessoire }}
                                                                {{ $accessoire[$a]->unite_mesure }}
                                                </label>
                                            @endif
                            @endfor
                            @endif
                            </label>
                            @endfor
            </div>
            </td>
            <td>
                <a href="{{ route('CRM.formUpdateConsoAccessoire', ['idAccessoire' => $accessoire[$a]->id]) }}" class="btn btn-warning"> <i class="fas fa-edit"></i></a>

            </td>

            </tr>

            @endfor
            </tbody>
            </table>
            </center>
        </div>

    </form>


        <div class="modal fade" id="editTiersModal" tabindex="-1" role="dialog" aria-labelledby="editTiersModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTiersModalLabel">Modifier conso tissus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('CRM.modifConsoTissu') }}" method="get" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" id="consoId" name="consoId">
                            <input type="hidden" id="idtissus" name="idtissus">
                            <div class="form-group">
                                <label for="consoInput">Consommation</label>
                                <input type="text" class="form-control" id="consoInput" name="conso">
                            </div>
                            <div class="form-group">
                                <label for="efficienceInput">Efficience</label>
                                <input type="text" class="form-control" id="efficienceInput" name="efficience">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!--**********************************
        modal start
***********************************-->



@include('CRM.parametre')

<!--**********************************
        javascript start
***********************************-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#editTiersModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var conso = button.data('conso');
            var efficience = button.data('efficience');
            var demandeClient = button.data('demandeclient');
            var idtissus = button.data('idtissus');

            console.log('heyy');
            console.log('conso:', conso); // Débogage
            console.log('efficience:', efficience); // Débogage

            var modal = $(this);
            modal.find('.modal-body #consoId').val(id);
            modal.find('.modal-body #demandeClient').val(demandeClient);
            modal.find('.modal-body #idtissus').val(idtissus);
            modal.find('.modal-body #consoInput').val(conso);
            modal.find('.modal-body #efficienceInput').val(efficience);
        });

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
<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
