@include('CRM.header')
@include('CRM.sidebar')
@include('STYLE.MES.styleFicheDemandeConfirme')

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('MES.headerMES')

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title grand-titre">FICHE DEMANDE CONFIRMÉ</h4>
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="data:image/png;base64,{{ $demandeConfirme->photo_commande }}" alt="Photo du commande" class="img-fluid-cin rounded shadow-sm" style="max-height: 200px;">
                            </div>
                            <div class="col-md-8">
                                <h5 class="card-title text-primary">Détails Demande</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li><strong>Date entrée :</strong> {{ $demandeConfirme->date_entree }}</li>
                                            <li><strong>Client :</strong> {{ $demandeConfirme->nomtier }}</li>
                                            <li><strong>Période :</strong> {{ $demandeConfirme->periode }}</li>
                                            <li><strong>Modèle :</strong> {{ $demandeConfirme->nom_modele }}</li>
                                            <li><strong>Désignation :</strong> {{ $demandeConfirme->nom_style }}</li>
                                            <li><strong>Thème :</strong> {{ $demandeConfirme->theme }}</li>
                                            <li><strong>Quantité prévisionnel :</strong> {{ $demandeConfirme->qte_commande_provisoire }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li><strong>ETD :</strong>  --</li>
                                            <li><strong>Stade :</strong> {{ $demandeConfirme->type_stade }}</li>
                                            <li><strong>Grille de taille :</strong> {{ $demandeConfirme->taillemin }} -- {{ $demandeConfirme->taillemax }}</li>
                                            <li><strong>Taille de base :</strong> {{ $demandeConfirme->taille_base }}</li>
                                            <li><strong>Inconterm :</strong> {{ $demandeConfirme->type_incontern }}</li>
                                            <li><strong>Phase :</strong> {{ $demandeConfirme->type_phase }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title petit-titre">LISTE COMMANDES (NUM OF)</h4>
                    </div>
                    <div class="card-body">
                        @if($listeOF->isEmpty())
                            <div class="alert alert-warning">
                                <strong>Aucun OF disponible</strong>
                            </div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-hover table-responsive-sm hover-table">
                                <thead>
                                    <tr>
                                        <th>RECAP_ID</th>
                                        <th>CLIENT</th>
                                        <th>STYLE</th>
                                        <th>NUM COMMANDE</th>
                                        <th>DESIGNATION</th>
                                        <th>QUANTITÉ OF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listeOF as $OF)
                                        <tr class="trigger-modal" data-toggle="modal" data-target=".bd-example-modal-lg" 
                                            data-recap-id = "{{ $OF->recap_id }}"
                                            data-numerocommande = "{{ $OF->numerocommande }}"
                                        >
                                            <td>{{ $OF->recap_id }}</td>
                                            <td>{{ $OF->nomtier }}</td>
                                            <td>{{ $OF->nom_modele }}</td>
                                            <td>{{ $OF->numerocommande }}</td>
                                            <td>{{ $OF->nom_style }}</td>
                                            <td>{{ $OF->qteof }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ENVOYE VERS LE SUIVI FLUX</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <form action="{{ route('MES.suivreFlux')}}" method="post">
                @csrf
            <div class="modal-body">
            <div class="row">
                <div class="col-4">
                    <input type="text" name="couleur" class="form-control" placeholder="Couleur" required>
                </div>
            </div>
                
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-responsive-sm">
                        <thead>
                            <tr>
                                <th>CLIENT</th>
                                <th>STYLE</th>
                                <th>NUM COMMANDE</th>
                                <th>DESIGNATION</th>
                                <th>SIZE</th>
                                <th>QUANTITÉ</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="modal-destination-body">
                            <tr class="modal-tr">
                                <td>ORCHESTRA</td>
                                <td>--</td>
                                <td>CALFAN</td>
                                <td>5091072</td>
                                <td>ROBE+BANDEAU</td>
                                <td>3 MOIS</td>
                                <td>389</td>
                                <td>
                                    <div class="basic-form">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" value="" disabled>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btn-suivre-flux" disabled>Suivre Flux</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.trigger-modal', function () {
            let recapId = $(this).data('recap-id'); 
            let numerocommande = $(this).data('numerocommande'); 
            let modalBody = $('#modal-destination-body'); 

            // Vider les anciennes données du modal
            modalBody.empty();

            // Appeler l'API pour récupérer les destinations
            $.ajax({
                url: `/mes-destinations-of/${recapId}/${numerocommande}`, 
                method: 'GET',
                success: function (response) {
                    // Ajouter les données dynamiquement
                    response.forEach(destination => {
                        modalBody.append(`
                            <tr class="${destination.istracked ? 'modal-tr' : ''}">
                                <td>${destination.nomtier}</td>
                                <input type="hidden" value="${destination.numerocommande}" name="numerocommande[${destination.id_destination}]">
                                <input type="hidden" value="${destination.unitetailleid}" name="uniteTaille[${destination.id_destination}]">
                                <input type="hidden" value="${destination.qteof}" name="qteof[${destination.id_destination}]">
                                <input type="hidden" value="${destination.iddemandeclient}" name="iddemandeclient[${destination.id_destination}]">
                                <input type="hidden" value="${destination.id_destination}" name="id_destination[${destination.id_destination}]">

                                <td>${destination.nom_modele}</td>
                                <td>${destination.numerocommande}</td>
                                <td>${destination.nom_style}</td>
                                <td>${destination.unite_taille}</td>
                                <td>${destination.qteof}</td>
                                <td>
                                    <div class="basic-form">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input 
                                                        type="checkbox" 
                                                        class="form-check-input modal-checkbox" 
                                                        value="${destination.id_destination}" 
                                                        name="${destination.istracked ? '' : 'checkbox[]'}" 
                                                        ${destination.istracked ? 'disabled' : ''}
                                                    >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `);
                    });

                    // Activer/désactiver le bouton après chargement des données
                    toggleButton(); 
                },
                error: function () {
                    modalBody.append('<tr><td colspan="8">Aucune donnée disponible.</td></tr>');
                }
            });
        });

        // Gestionnaire d'événements pour activer/désactiver le bouton
        $(document).on('change', '.modal-checkbox', function () {
            toggleButton();
        });

        // Fonction pour activer ou désactiver le bouton en fonction des cases cochées
        function toggleButton() {
            let button = $('#btn-suivre-flux');
            if ($('#modal-destination-body input[type="checkbox"]:checked').length > 0) {
                button.prop('disabled', false); // Activer le bouton
            } else {
                button.prop('disabled', true); // Désactiver le bouton
            }
        }

        // Initialiser le bouton en désactivé au chargement de la page
        toggleButton();
    });
</script>
<script>
    $(document).ready(function () {
        // Sélectionnez toutes les cases à cocher dans le modal
        const checkboxes = $('#modal-destination-body input[type="checkbox"]');
        const button = $('#btn-suivre-flux');

        // Fonction pour vérifier si au moins une case est cochée
        function toggleButton() {
            if (checkboxes.is(':checked')) {
                button.prop('disabled', false); // Activer le bouton
            } else {
                button.prop('disabled', true); // Désactiver le bouton
            }
        }

        // Événement déclenché lors du clic sur une case à cocher
        checkboxes.on('change', function () {
            toggleButton();
        });

        // Appel initial pour s'assurer que le bouton est désactivé au chargement
        toggleButton();                                         
    });
</script>

@include('CRM.footer')