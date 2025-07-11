<title>SMVApercue</title>
<style>
    .checkbox-container {
        display: flex;
        flex-wrap: wrap;
    }

    .checkbox-item {
        flex: 0 0 23%;
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

@include('CRM.header')
@include('CRM.sidebar')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    function exportToPDF() {
        const element = document.getElementById("smvpdf");

        const options = {
            filename: 'SMV_{{ $detaildemande[0]->nom_modele }}_{{ $detaildemande[0]->nomtier }}_{{ $detaildemande[0]->type_stade }}.pdf',
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

        html2pdf().set(options).from(element).save();
    }
</script>


<div class="content-body">
    <div class="container-fluid mt-3">
        @include('VAMM.headerVAMM')
        <div id="smvpdf" class="card col-12">
            <div class="card-body row" style="display: flex; align-items: center;border-bottom: solid 1px gray">
                <div class="col-2">
                    <div class="image"><img src="./images/NEW LOGO.png" alt="" width="50px" height="50px">
                    </div>
                </div>
                <div class="col-6"
                    style="margin-left: 100px;border: solid,1px; width: 600px;height: 20px;text-align: center">
                    <div class="client">
                        <h6>HISTORIQUE SMV : {{ $detaildemande[0]->nomtier }}</h6>
                    </div>
                </div>
            </div>
            <center>
                <div class="row mt-3" style="border-bottom: solid 1px gray;font-size: 10px;height: 100px;">

                    <div class="col-4">
                        <div class="card-body" style="margin-left: 60px;margin-top: -20px;">
                            <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>CLIENT :
                                </b>{{ $detaildemande[0]->nomtier }}</p>
                            <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>SAISON :
                                </b>{{ $detaildemande[0]->type_saison }}</p>
                            <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>MODELE :
                                </b>{{ $detaildemande[0]->nom_modele }}</p>
                            <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>STADE :
                                </b>{{ $detaildemande[0]->type_stade }}</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-validation">
                            <div class="image" style="margin-top: -16px;margin-right: 10px;"><img
                                    src="data:image/png;base64,{{ $detaildemande[0]->photo_commande }}"
                                    class="img-fluid rounded-start mb-5" alt="Logo" width="70px" height="50px">
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card-body" style="margin-left: 60px;margin-top: -10px;">
                            <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>Methode :</b> </p>
                            <p class="texte" style="text-align: left;margin-bottom: 3px;"><b>Validé par :</b> </p>
                        </div>
                    </div>
                </div>
            </center>
            <br>
            <center>
                <table class="table table-striped" font-size: 10px;>
                    <thead style="color: black;">
                        <tr>
                            <th scope="col">DateSmv</th>
                            <th scope="col">Stade</th>
                            <th scope="col">SmvProd (min)</th>
                            <th scope="col">SmvFinition (min)</th>
                            <th scope="col">Prix Print</th>
                            <th scope="col">Nombre des Points</th>
                            <th scope="col">Heure BrodMain</th>
                            <th scope="col">Commentaire</th>
                        </tr>
                    </thead>
                    <tbody style="color: black;">
                        @foreach ($smv as $s)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($s->date_smv)->format('d/m/y') }}</td>
                                <td>{{ $s->type_stade }}</td>
                                <td>{{ $s->smv_prod }}</td>
                                <td>{{ $s->smv_finition }}</td>
                                <td>{{ $s->prix_print }}</td>
                                <td>{{ $s->nombre_points }}</td>
                                <td>{{ $s->smv_brod_main }}</td>
                                <td>{{ $s->commentaire }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </center>
        </div>


        <br>
    </div>
</div>



<style>
    .fixed-top-right {
        position: fixed;
        top: 0;
        right: 0;
        margin-top: 160px;
        /* Optionnel, pour donner un petit espace par rapport au bord */
        margin-right: 25px;
        z-index: 1000;
        /* Assure que le div reste au-dessus des autres éléments */
    }

    .settings-icon {
        font-size: 1.5rem;
        /* Taille de l'icône */
        cursor: pointer;
        /* Curseur pointeur au survol */
        color: #495057;
        /* Couleur de l'icône */
        transition: transform 0.5s ease-in-out;
        /* Transition pour la rotation */
    }

    .settings-icon:hover {
        transform: rotate(180deg);
        /* Rotation au survol */
    }

    .custom-card {
        background-color: #343a40;
        /* Couleur de fond foncée */
        border-radius: 8px;
        /* Bordure arrondie */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Ombre pour un effet de relief */
        display: none;
        /* Caché par défaut */
        margin-top: 10px;
        /* Espacement entre l'icône et le menu */
    }

    .custom-card .btn {
        width: 100%;
        /* Assure que les boutons prennent toute la largeur */
        text-align: left;
        /* Aligne le texte et l'icône à gauche */
        color: #fff;
        /* Couleur du texte blanche */
        background-color: #495057;
        /* Couleur de fond des boutons */
        border: none;
        /* Supprime la bordure */
        transition: background-color 0.3s;
        /* Transition douce pour le changement de couleur */
    }

    .custom-card .btn:hover {
        background-color: #6c757d;
        /* Changement de couleur au survol */
    }

    .custom-card i {
        margin-right: 8px;
        /* Espace entre l'icône et le texte */
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
@include('CRM.footer')
