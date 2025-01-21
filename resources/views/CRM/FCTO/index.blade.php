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
@include('CRM.header')
@include('CRM.sidebar')

<div class="content-body">
    <div class="container-fluid mt-3">
        @include('CRM.headerCrm')
        <div class="card col-12 carte">
            <div class="justify-content-center align-items-center entete">
                <h3 class="entete mt-3">ENVOIE ECHANTILLON </h3>
                <center>

                </center>
            </div>

            <div class="card-body">


                <table border="1">
                    <thead>
                        <tr>
                            <th>ID Unité Taille</th>
                            @foreach($consoAccessoires->groupBy('id_unite_taille') as $idUniteTaille => $accessoiresGroup)
                                <th colspan="2">{{ $idUniteTaille }}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th></th>
                            @foreach($consoAccessoires->groupBy('id_unite_taille') as $idUniteTaille => $accessoiresGroup)
                                <th>ID Accessoire</th>
                                <th>Conso Accessoire</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consoAccessoires->groupBy('id_unite_taille') as $idUniteTaille => $accessoiresGroup)
                            @foreach($accessoiresGroup->groupBy('id_accessoire') as $idAccessoire => $group)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $accessoiresGroup->count() }}">{{ $idUniteTaille }}</td>
                                    @endif
                                    @foreach($group as $accessoire)
                                        @if($loop->first)
                                            <td>{{ $idAccessoire }}</td>
                                            <td>{{ $accessoire->conso_accessoire }}</td>
                                        @endif
                                        <!-- Les autres lignes pour le même id_unite_taille -->
                                        @if(!$loop->first)
                                            <tr>
                                                <td>{{ $idAccessoire }}</td>
                                                <td>{{ $accessoire->conso_accessoire }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>


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
@include('CRM.parametre')



@include('CRM.footer')
