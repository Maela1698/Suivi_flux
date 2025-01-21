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
</style>
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
        <div class="card col-12 carte">
            <div class="card-header d-flex justify-content-center align-items-center entete">
                <h3 class="entete">BON DE COMMANDE</h3>
            </div>

            <div class="card-body">
                <table class="table table-striped">
                    <thead style="color: black;">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody style="color: black;">
                        @foreach ($allbc as $bc)
                            <tr>
                                <th scope="row">{{ $bc->numero_bc }}/{{ $bc->nomtier }}</th>
                                <td><a href="{{ route('CRM.bcapercu', ['id' => $bc->bc_id,'idtier' => $bc->tiers_id]) }}"><button type="submit" class="btn btn-info"
                                            style="height: 25px; line-height: 10px;">Aperçue</button></a></td>
                                <td><button onclick="exportToPDF()" class="btn btn-primary"
                                        style="height: 25px; line-height: 10px;">Telecharger</button></td>
                                <form id="validerForm{{ $bc->bc_id }}" action="{{ route('CRM.validerBc') }}" method="get">
                                    @csrf
                                    <input type="hidden" name="idbc" value="{{ $bc->bc_id }}">
                                    <td><button type="button" class="btn btn-success" style="height: 30px;"
                                            data-toggle="modal"
                                            data-target="#confirmModal{{ $bc->bc_id }}">Valider</button></td>
                                </form>
                            </tr>
                            <!-- Modal HTML with dynamic id -->
                            <div class="modal fade" id="confirmModal{{ $bc->bc_id }}" tabindex="-1"
                                role="dialog" aria-labelledby="confirmModalLabel{{ $bc->bc_id }}"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmModalLabel{{ $bc->bc_id }}">
                                                Confirmer l'Action</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="color: black;">
                                            Êtes-vous sûr de vouloir valider ce bon de commande ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Annuler</button>
                                            <button type="button" class="btn btn-success"
                                                onclick="submitForm('{{ $bc->bc_id }}')">Valider</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <br>
            </div>
        </div>


        <div id="sdcpdf" style="display: none;">
            <div class="card col-md-11" style="margin-left: 45px;">
                <div class="card-header d-flex justify-content-center align-items-center entete">
                    <h3 class="entete">BC APERCU</h3>
                </div>
            </div>
            <div class="row apercubc">
                <div class="col-5 mt-5 mb-10" style="margin-left: 60px;">
                    <img src="" class="img-fluid rounded-start mb-5" alt="Logo" width="200"
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
                <hr style="border: 0; height: 4px; background-color: #ddd;">
                <div class="container">
                    <hr
                        style="border: 0; height: 2px; background-color: #ddd;>
                            <section class="main-info">
                    <div class="double_table mt-3">
                        <div class="table-left">
                            <p class="texte mb-0">Date : <b>19/08/2024 14:15:44</b></>
                            <p class="texte mb-0">N° BC : <b>0_TISSU/LOI/2024</b></p>
                            <p class="texte mb-0">Fournisseur :<b>SOCOTA</b></p>
                            <p class="texte mb-0">Échéance Livraison :<b>24/10/2024 00:00:00</b></p>
                            <p class="texte mb-0">ATTN :<b>VATSY/</b></p>
                            <p class="texte mb-0">ORIGINE :<b>Local</b></p>
                        </div>

                        <div class="table-right">
                            <p class="texte mb-0">Client : <b>JACADI</b></p>
                            <p class="texte mb-0">Saison : <b>H23</b></p>
                            <p class="texte mb-0">Devise : <b>Euro</b></p>
                            <p class="texte mb-0">Pays : <b>MADAGASCAR</b></p>
                        </div>
                    </div>
                    </section>
                    <hr style="border: 0; height: 2px; background-color: #ddd;">
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
                                <tr>
                                    <td>1</td>
                                    <td>GORCELLA/EECC VS9 C46703/100% COTTON</td>
                                    <td>CELINE</td>
                                    <td>BLANC</td>
                                    <td>143</td>
                                    <td>50,00</td>
                                    <td>m</td>
                                    <td>3,400</td>
                                    <td>Euro</td>
                                    <td>170,00</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>ESMONIA/EECC VS9 C46703/100% COTTON ORG</td>
                                    <td>vrosi</td>
                                    <td>ROUGE</td>
                                    <td>145</td>
                                    <td>20,00</td>
                                    <td>m</td>
                                    <td>3,400</td>
                                    <td>Euro</td>
                                    <td>68,00</td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                    <section class="total-section">
                        <p>TOTAL: <strong>238,00 Euro</strong></p>
                        <p>Signature: <br><br><br>19/08/2024</p>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>

<!-- Modal HTML -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmer l'Action</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color: black;">
                Êtes-vous sûr de vouloir valider ce bon de commande ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success" id="confirmButton">Valider</button>
            </div>
        </div>
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
<div class="col-md-1 fixed-top-right">
    <div class="d-flex flex-column align-items-end">
        <!-- Icône Paramètres -->
        <div class="settings-icon" id="settings-icon">
            <i class="fas fa-cog"></i>
        </div>

        <!-- Carte avec les boutons -->
        <div class="card p-2 custom-card" id="settings-menu">
            <!-- Bouton Matière Première -->
            <form action="{{ route('CRM.listeMatierePremiere') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Matière Première">
                    <i class="fas fa-box-open"></i> M.P
                </button>
            </form>

            <!-- Bouton SDC -->
            <form action="{{ route('CRM.sdc') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="SDC">
                    <i class="fas fa-tasks"></i> SDC
                </button>
            </form>

            <!-- Bouton FDC -->
            <form action="listeFDC" method="post">
                <input type='hidden' name='idDemandeClient' value="<%= listeDemande.get(0).getId()%>">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="FDC">
                    <i class="fas fa-check-double"></i> FDC
                </button>
            </form>

            <!-- Bouton SMV -->
            <form action="{{ route('CRM.smv') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="SMV">
                    <i class="fas fa-stopwatch"></i> SMV
                </button>
            </form>

            <!-- Bouton PRI -->
            <form action="{{ route('CRM.pri') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="PRI">
                    <i class="fas fa-money-bill-wave"></i> PRI
                </button>
            </form>

            <!-- Bouton Envoie Échantillon -->
            <form action="{{ route('CRM.echantillon') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Envoie Échantillon">
                    <i class="fas fa-shipping-fast"></i> E.E
                </button>
            </form>

            <!-- Bouton Bon de Commande -->
            <form action="{{ route('CRM.bc') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Bon de Commande">
                    <i class="fas fa-file-alt"></i> B.C
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function exportToPDF() {
        const element = document.getElementById("sdcpdf");

        // Si l'élément est caché, le montrer
        if (element.style.display === "none") {
            element.style.display = "block";
        } else {
            // Si l'élément est déjà visible, le cacher
            element.style.display = "none";
        }
        const options = {
            filename: 'bc.pdf',
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

<script>
    document.getElementById('settings-icon').addEventListener('mouseover', function() {
        document.getElementById('settings-menu').style.display = 'block';
    });

    document.getElementById('settings-menu').addEventListener('mouseleave', function() {
        document.getElementById('settings-menu').style.display = 'none';
    });
</script>

<!-- JavaScript for handling form submission -->
<script>
    function submitForm(formId) {
        document.getElementById('validerForm' + formId).submit();
    }
</script>

@include('CRM.footer')
