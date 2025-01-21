@include('CRM.header')
@include('CRM.sidebar')

<!--**********************************
    Content body start
***********************************-->

<style>
    .entete {
        color: #7571f9; /* Ajuster la couleur du texte si nécessaire */
    }
    .card-small {
        height: 110px; /* Ajustez cette valeur selon vos besoins */
        padding: 10px;
    }
    .card-small .card-title {
        font-size: 1.3rem; /* Taille de la police du titre */
    }
    .card-small h2 {
        font-size: 2rem; /* Taille de la police du chiffre */
    }
    .card-small .display-5 {
        font-size: 2.2rem; /* Taille de l'icône */
        opacity: 0.5; /* Garder l'opacité comme avant */
    }
    .texte {
        color: black;
    }

</style>

<style>
    .table th {
        color: #000000; /* Couleur noire intense */
        font-weight: bold; /* Optionnel : Rend le texte plus épais */
    }
    .table td {
        color: #828282; /* Couleur noire intense */
        font-weight: bold; /* Optionnel : Rend le texte plus épais */
    }
</style>

<div class="content-body">
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div style="margin-top: 10px;">
            @include('CRM.reglage')
        </div>
         <div class="card" style="width: 102%;margin-left: -15.8px;" >
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="entete">LISTE DES UNITES TIERS</h3>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTiersModal">
                    Ajouter
                </button>
            </div>
            <div class="table-responsive mt-4" style="margin-left: 20px;">
                <table class="table table-striped" style="width: 97%;">
                    <thead>
                        <tr>
                            <th>Unité tiers</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>Unite1</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#deleteConfirmModal" data-id="1">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-edit" data-toggle="modal" data-target="#editTiersModal" data-id="1" data-name="2">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Unite2</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#deleteConfirmModal" data-id="1">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-edit" data-toggle="modal" data-target="#editTiersModal" data-id="1" data-name="2">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                            <td></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Confirmation de suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cet élément ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'ajout -->
<div class="modal fade" id="addTiersModal" tabindex="-1" role="dialog" aria-labelledby="addTiersModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTiersModalLabel">Ajouter un Unité</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addTiersForm" method="post" action="ajoutEtatTiers" autocomplete="off">
                    <div class="form-group">
                        <label for="tiersName">Nom du Unité</label>
                        <input type="text" class="form-control" id="tiersName" name="nomEtat" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary" form="addTiersForm">Ajouter</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editTiersModal" tabindex="-1" role="dialog" aria-labelledby="editTiersModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTiersModalLabel">Modifier le Unité Tiers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editTiersForm" action="updateEtatTiers" method="post" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="idEtat">
                    <div class="form-group">
                        <label for="edit-etattiers" class="col-form-label">Unité Tiers:</label>
                        <input type="text" class="form-control" id="edit-etattiers" name="nomEtat">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        let deleteButton;
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                deleteButton = document.getElementById('confirmDeleteButton');
                deleteButton.setAttribute('data-id', id);
            });
        });

        document.getElementById('confirmDeleteButton').addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            window.location.href = 'deleteEtatTiers?idEtat=' + id;
        });

        $('#editTiersModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var etattiers = button.data('name');

            var modal = $(this);
            modal.find('.modal-body #edit-id').val(id);
            modal.find('.modal-body #edit-etattiers').val(etattiers);
        });
    });
</script>

@include('CRM.footer')

