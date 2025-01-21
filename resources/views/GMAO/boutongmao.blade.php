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
<div class="col-md-1 fixed-top-right">
    <div class="d-flex flex-column align-items-end">
        <!-- Icône Paramètres -->
        <div class="settings-icon" id="settings-icon">
            <i class="fas fa-cog"></i>
        </div>

        <!-- Carte avec les boutons -->
        <div class="card p-2 custom-card" id="settings-menu">

            <a href="{{route('GMAO.accueilgmao')}}">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Liste Data">
                    <i class="fa-solid fa-house"></i>Accueil
                </button>
            </a>
            <form action="" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Pièces">
                    <i class="fas fa-box-open"></i>Pièces
                </button>
            </form>

            <a href="{{route('GMAO.showajoutpiece')}}">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Add Pièces">
                <i class="fas fa-plus"></i> Ajouter une/des Pièces
                </button>
            </a>

            <form action="" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Interventions">
                    <i class="fas fa-tools"></i> Interventions
                </button>
            </form>

            <form action="" method="get">
                <button type="submit" class="btn btn-light mb-2" data-toggle="tooltip" title="Planification">
                    <i class="fa-solid fa-list"></i></i> Planification
                </button>
            </form>

            {{-- <div class="col-sm-4"> --}}

            {{-- </div> --}}
        </div>
    </div>
</div>
<script>
    document.getElementById('settings-icon').addEventListener('click', function() {
        var menu = document.getElementById('settings-menu');
        // Vérifiez si le menu est déjà affiché
        if (menu.style.display === "block") {
            menu.style.display = "none"; // Masque le menu
        } else {
            menu.style.display = "block"; // Affiche le menu
        }
    });
</script>
