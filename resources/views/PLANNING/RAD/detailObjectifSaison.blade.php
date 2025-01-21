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
        margin-right: 10px; /* Adjust spacing as needed */
    }
    .form-inline .form-group {
        margin-right: 5px; /* Reduce the margin between form fields */
    }
    .form-inline .form-control {
        padding-left: 5px; /* Adjust padding if needed */
        padding-right: 5px; /* Adjust padding if needed */
    }
    .form-group.mb-2, .form-group.mx-sm-1.mb-2 {
        margin-bottom: 0; /* Remove bottom margin to bring elements closer */
    }
    .form-inline .form-control-plaintext {
        margin-right: 5px; /* Reduce space after "Stade" label */
    }
    .form-inline select, .form-inline button {
        margin-left: 5px; /* Reduce space before select and button */
    }
</style>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

@include('CRM.header')
@include('CRM.sidebar')

<div class="content-body">
    <div class="container-fluid mt-3">
        @include('CRM.headerCrm')
        <div class="card col-12 carte">
            <div class="card-header d-flex justify-content-center align-items-center entete">
                <h3 class="entete">Detail Objectif Saison</h3>
            </div>

            <div class="card-body">
                <div class="row mt-3" style="display: flex; align-items: center;">
                    <div class="col-2">
                    </div>
                    @foreach ($detailObjectif as $obj)
                    <div class="col-5">
                        <p class="texte"><b>Merch :</b> {{ $obj->merchsenior ?? '0' }}</p>
                        <p class="texte"><b>Saison :</b> {{ $obj->type_saison ?? '0' }}</p>
                        <p class="texte"><b>Client:</b>{{ $obj->nomtier ?? '0' }}</p>

                    </div>
                    <div class="col-5">
                        <p class="texte"><b>Nombre de Commandes :</b> {{ $obj->nb_commandes ? number_format($obj->nb_commandes,0,' ',' ') : '0' }}</p>
                        <p class="texte"><b>Target :</b>{{ $obj->targetsaison ? number_format($obj->targetsaison,0,' ',' ') : '0' }} pièces</p>
                        <p class="texte"><b>Qté Confirmé :</b>{{ $obj->total_qte_confirmee ? number_format($obj->total_qte_confirmee,0,' ',' '): '0' }} pièces</p>
                        <p class="texte"><b>Qté En-cours Nego :</b>{{ $obj->total_qte_encours_nego ? number_format($obj->total_qte_encours_nego,0,' ',' '): '0' }} pièces</p>
                        <p class="texte"><b>Taux Confirmé :</b>{{ $obj->tauxconfirmation ? number_format($obj->tauxconfirmation, 2) : '0' }} %</p>
                    </div>
                    @endforeach
                </div>


                {{-- bouton pour afficher le modal --}}
                        {{-- <form action="{{ route('LRP.updateObjectifSaison')}}" method='POST'>
                            @csrf
                            <input type="hidden" name="id_obj" value="{{ $obj->id_obj ?? '0' }}">
                            <button type="submit" class="btn btn-warning">Modifier</button>
                        </form> --}}

                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                            Modifier
                        </button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmSupprimerModal">
                                Supprimer
                            </button>
                            <a href="/LRP/objectifSaison">
                            <button type="button" class="btn btn-info btn-sm">
                                Retour
                            </button>
                        </a>
                        </form>
                    </div>
                </div>
                <br>
                <br>
            </div>
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
{{-- petit engrenage --}}
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

            <!-- Bouton Modification -->
            <div class="form-group row">
                <form action="{{ route('CRM.bc') }}" method="get">
                    <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Bon de Commande">
                        <i class="fas fa-file-alt"></i> B.C
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--**********************************
        modal start
***********************************-->
<!-- Modal -->
<div class="modal fade custom-modal" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Modifier Objectif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('LRP.updateObjectifSaison') }}" method="POST" id="updateForm">
                    @csrf
                    <input type="hidden" name="id_obj" value="{{ $obj->id_obj }}">
                    <input type="hidden" name="id_tiers" value="{{ $obj->id_tier }}">
                    <input type="hidden" name="id_saison" value="{{ $obj->idsaison }}">

                    <div class="mb-3">
                        <label for="targetsaison" class="form-label">Target Saison</label>
                        <input type="number" class="form-control" id="targetsaison" name="targetsaison" value="{{ $obj->targetsaison }}">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary" id="confirmDeleteButton" onclick="submitForm()">Modifier</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmUpdateModal" tabindex="-1" aria-labelledby="confirmUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmUpdateModalLabel">Confirmation de la mise à jour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir modifier cet objectif saison ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmUpdateButton">Confirmer la modification</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade custom-modal" id="confirmSupprimerModal" tabindex="-1" aria-labelledby="confirmSupprimerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmSupprimerModalLabel">Supprimer Objectif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cet objectif saison ?
            </div>
            <form action="{{ route('LRP.deleteObjectifSaison') }}" method="POST" id="updateForm">
                @csrf
                <input type="hidden" name="id_obj" value="{{ $obj->id_obj }}">
            </form>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="confirmDeleteButton" onclick="submitForm()">Supprimer</button>
            </div>
        </div>
    </div>
</div>
<!--**********************************
        modal end
***********************************-->


<script>
    document.getElementById('settings-icon').addEventListener('mouseover', function() {
    document.getElementById('settings-menu').style.display = 'block';
    });

    document.getElementById('settings-menu').addEventListener('mouseleave', function() {
        document.getElementById('settings-menu').style.display = 'none';
    });
</script>

<script>
    function submitForm() {
    document.getElementById('updateForm').submit();
}
    function submitForm() {
    document.querySelector('#confirmDeleteModal form').submit();
}

function submitForm() {
    document.querySelector('#confirmSupprimerModal form').submit();
}

document.getElementById('confirmUpdateButton').addEventListener('click', function () {
    document.querySelector('form').submit();
});
</script>


@include('CRM.footer')
