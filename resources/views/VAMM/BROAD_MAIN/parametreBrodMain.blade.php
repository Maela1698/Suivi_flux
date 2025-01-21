<style>
    .fixed-top-right {
        position: fixed;
        top: 0;
        right: 0;
        margin-top: 136px;
        /* Optionnel, pour donner un petit espace par rapport au bord */
        margin-right: 10px;
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

            <!-- Detail -->
            <form action="{{ route('BRODMAIN.detailDemandeBrodMain') }}" method="get">
                @if (session('idDemandeBrodMain'))
                    <input type="hidden" name="idDemande" value="{{ session('idDemandeBrodMain') }}">
                @endif
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Detail">
                    <i class="fas fa-info-circle"></i> Detail
                </button>
            </form>


            <!-- Bouton Matière Première -->
            <form action="{{ route('BRODMAIN.listeConsoFil') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Matière Première">
                    <i class="fas fa-box-open"></i>ConsoFil
                </button>
            </form>

            <!-- Bouton SDC -->
            <form action="{{ route('SERIGRAPHIE.listeMpSer') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Matiere premiere">
                    <i class="fas fa-tasks"></i> MP
                </button>
            </form>

            <!-- Bouton FDC -->
            <form action="{{ route('SERIGRAPHIE.sdcApercueSer') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="FDC">
                    <i class="fas fa-check-double"></i> SDC
                </button>
            </form>

            <!-- Bouton SMV -->
            <form action="{{ route('SERIGRAPHIE.smvApercue') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Fiche de coupe">
                    <i class="fas fa-stopwatch"></i> SMV
                </button>
            </form>

            <!-- Bouton PRI -->
            <form action="{{ route('SERIGRAPHIE.echantillonApercuSer') }}" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="PRI">
                    <i class="fas fa-money-bill-wave"></i> E.E
                </button>
            </form>


        </div>
    </div>
</div>

<script>
    document.getElementById('settings-icon').addEventListener('mouseover', function() {
        document.getElementById('settings-menu').style.display = 'block';
    });

    document.getElementById('settings-menu').addEventListener('mouseleave', function() {
        document.getElementById('settings-menu').style.display = 'none';
    });
</script>
