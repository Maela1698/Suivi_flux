<style>
    .entete {
        color: #7571f9;
        background-color: white;
    }

    .carte {
        color: white;
        background-color: white;
    }

    .texte {
        color: black;
    }

    .table {
        color: black;
    }

    .button-group {
        display: flex;
        justify-content: space-around;
    }

    .button-group form {
        margin-right: 10px;
        /* Adjust spacing as needed */
    }

    .form-inline .form-group {
        margin-right: 5px;
        /* Reduce the margin between form fields */
    }

    .form-inline .form-control {
        padding-left: 5px;
        /* Adjust padding if needed */
        padding-right: 5px;
        /* Adjust padding if needed */
    }

    .form-group.mb-2,
    .form-group.mx-sm-1.mb-2 {
        margin-bottom: 0;
        /* Remove bottom margin to bring elements closer */
    }

    .form-inline .form-control-plaintext {
        margin-right: 5px;
        /* Reduce space after "Stade" label */
    }

    .form-inline select,
    .form-inline button {
        margin-left: 5px;
        /* Reduce space before select and button */
    }

    .apercubc {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: white;
        border-bottom: solid 3px lightgrey;
        border-radius: 5px;

    }

    .container {
        max-width: 900px;
        margin: 0 auto;
        background-color: white;
        padding: 20px;
        color: black;
    }

    .product-table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
        font-size: 14px;
        color: rgb(15, 9, 9);
    }

    .product-table th,
    .product-table td {
        border: 1px solid #ddd;
        text-align: center;
    }

    .total-section {
        margin-top: 20px;
        text-align: right;
        font-size: 16px;
    }

    .total-section p {
        margin: 10px 0;
    }

    /* double_table */

    .double_table {
        display: flex;
        justify-content: space-between;
        /* Align the two "tables" side by side */
    }

    .table-left,
    .table-right {
        width: 26%;
    }

    p {
        margin: 5px 0;
        /* Reduce the spacing between paragraphs */
    }

    .label {
        font-weight: bold;
        /* Make the labels bold */
        display: inline-block;
        width: 150px;
        /* Adjust the label width to align content */
    }

    span {
        display: inline-block;
        /* Keep both label and value inline */
    }


    .table-left,
    .table-right {
        width: 26%;
        /* Ajuster la largeur des tables si nécessaire */
        border-collapse: collapse;
        /* Pour un style de table net */
    }

    .strong_tr p {
        font-weight: bold;
        margin: 0;
        padding-right: 10px;
        /* Optionnel : ajoute un peu d'espace après le texte en gras */
    }

    td {
        padding: 8px;
        border: 1px solid #ddd;
        /* Optionnel : ajout d'une bordure pour structurer */
    }
</style>

@include('CRM.header')
@include('CRM.sidebar')

<div class="content-body">
    <div class="container-fluid mt-3">
        @include('CRM.headerCrm')
        <div>
            <div class="card col-md-11" style="margin-left: 45px;">
                <div class="card-header d-flex justify-content-center align-items-center entete">
                    <h3 class="entete">BC APERCU</h3>
                </div>
            </div>
            <div class="row apercubc" id="sdcpdf">
                <div class="col-5 mt-5 mb-10" style="margin-left: 60px;">
                    <img src="../../images/NEW LOGO.png" class="img-fluid rounded-start mb-5" alt="Logo" width="200"
                        height="200px">
                </div>
                <div class="col-5" style="margin-top: -60px; margin-left:130px; margin-top:10px;padding-left: 157px;">
                    <p class="texte mb-0"><b>Société Anonyme avec conseil d'administration</b></p>
                    <p class="texte mb-0"><b>au capital de 148 400 000 Ariary</b></p>
                    <p class="texte mb-0"><b>LOT 03810D Ambohitrangano Sabotsy Namehana</b></p>
                    <p class="texte mb-0"><b>Antananarivo 103</b></p>
                    <p class="texte mb-0"><b>NIF: 2000100388</b></p>
                    <p class="texte mb-0"><b>STAT: 14105 11 1995 0 00077</b></p>
                    <p class="texte mb-0"><b>Décret d'agrément n°95-410 du 30 Mai 1995</b></p>
                    <p class="texte mb-0"><b>TEL 22 451 54 / 22 534 84</b></p>
                    <p class="texte mb-0"><b>FAX / 24 741 05</b></p>
                </div>
                @php
                $value = collect($interloc)->pluck('nominterlocateur')->implode('/');
                @endphp
                <hr style="border: 0; height: 4px; background-color: #ddd;">
                <div class="container">
                    <hr
                        style="border: 0; height: 2px; background-color: #ddd;>
                            <section class="main-info">
                    <div class="double_table mt-3">
                            <div class="table-left">
                                <p class="texte mb-0">Date : <b>  {{ \Carbon\Carbon::parse($donne[0]->date_bc)->format('d/m/y') }}</b></>
                                <p class="texte mb-0">N° BC : <b>{{ $donne[0]->numerobc }}</b></p>
                                <p class="texte mb-0">Fournisseur :<b>{{ $donne[0]->fournisseur }}</b></p>
                                <p class="texte mb-0">Échéance Livraison :<b> {{ \Carbon\Carbon::parse($donne[0]->deadline)->format('d/m/y') }}</b></p>
                                <p class="texte mb-0">ATTN :<b>{{ $value }}</b></p>
                                @if($donne[0]->pays=='Madagascar')
                                <p class="texte mb-0">ORIGINE :<b>Local</b></p>
                                @else
                                <p class="texte mb-0">ORIGINE :<b>Import</b></p>
                                @endif

                            </div>
                            <div class="table-right">
                                <p class="texte mb-0">Client : <b>{{ $donne[0]->client }}</b></p>
                                <p class="texte mb-0">Saison : <b>{{ $donne[0]->type_saison }}</b></p>
                                <p class="texte mb-0">Devise : <b>{{ $donne[0]->devise }}</b></p>
                                <p class="texte mb-0">Pays : <b>{{ $donne[0]->pays }}</b></p>
                            </div>
                    </div>
                    </section>
                    <hr
                        style="border: 0; height: 2px; background-color: #ddd;>
                            <section class="product-table-section">
                    <table class="product-table ">
                        <thead>
                            <tr class="table-success">
                                <th>Ref</th>
                                <th>Désignation</th>
                                <th>Modèle</th>
                                <th>Couleur</th>
                                <th>Taille/Laize</th>
                                <th>Qte</th>
                                <th>Unite</th>
                                <th>PU</th>
                                <th>UM</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $ref = 1;
                                $total = 0;
                            @endphp
                            @foreach($donne as $d)
                            <tr>
                                <td>{{ $ref }}</td>
                                <td>{{ $d->designation }}</td>
                                <td>{{ $d->nom_modele }}</td>
                                <td>{{ $d->couleur }}</td>
                                <td>{{ $d->laize }}</td>
                                <td>{{ $d->quantite }}</td>
                                <td>{{ $d->unite }}</td>
                                <td>{{ $d->prix_unitaire }}</td>
                                <td>{{ $d->devise }}</td>
                                <td>{{ $d->prix_total }}</td>
                            </tr>
                            @php
                                $ref++;
                                $total = $total+$d->prix_total
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                    </section>
                    <section class="total-section">
                        <p>TOTAL: <strong>{{ $total }}</strong>{{ $donne[0]->devise }}</p>
                        <p>Signature: <br><br><br>19/08/2024</p>
                    </section>
                </div>
            </div>
        </div>
        <button onclick="exportToPDF()" type="submit" class="btn btn-primary"
            style="height: 25px; line-height: 10px;">Telecharger</button>

    </div>
</div>
</div>



<!-- #/ container -->
</div>


<script>
    function exportToPDF() {
        const element = document.getElementById("sdcpdf");

        const options = {
            filename: 'sdc.pdf',
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
@include('CRM.parametre')
@include('CRM.footer')
