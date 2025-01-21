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
            <div class="card-header d-flex justify-content-center align-items-center entete">
                <h3 class="entete">CREER SDC</h3>
            </div>

            <div class="card-body">
                @if (count($lastsdc) != 0)
                    <div class="form-validation">
                        <form class="form-valide" action="{{ route('CRM.modifSdc') }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label" style="color: black;">Stade:
                                                {{ $demande[0]->type_stade }} </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label" style="color: gray;">Date d'envoie client
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="date" class="form-control" name="dateEnvoie"
                                                value="{{ $lastsdc[0]->date_envoie }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table table" style="background-color: lightgrey;">
                                <thead>
                                    <tr>
                                        <th scope="col" style="color: black;">Taille</th>
                                        <th scope="col" style="color: black;">Quantite CLient</th>
                                        <th scope="col" style="color: black;">Keep</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detail as $dt)
                                        <tr>
                                            <th scope="row" style="color: black;">{{ $dt->unite_taille }}</th>
                                            <td><input type='number'
                                                    style="width: 100%; box-sizing: border-box; padding: 4px;border: none;"
                                                    name="quantiteclient[]" value="{{ $dt->qte_client }}"></td>
                                            <td><input type='number'
                                                    style="width: 100%; box-sizing: border-box; padding: 4px;border: none;"
                                                    name="keep[]" value="{{ $dt->keep }}"></td>
                                            <input type="hidden" name="id_unite_taille_dc[]"
                                                value="{{ $dt->id_unite_taille_dc }}">
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <br>
                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                    <a href="{{ route('CRM.sdc') }}" class="btn btn-info mr-3">Retour</a>
                                    <button type="submit" class="btn btn-success mr-3"
                                        style="margin-left: 15px">Enregistrer</button>

                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <p class="texte">Ce demande n'a pas encore de SDC</p>
                    <form action="{{ route('CRM.sdc') }}" method="get">
                       <p> <button type="submit" class="btn btn-info mt-3">Retour</button></p>
                    </form>
                @endif

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

<script>
    document.getElementById('settings-icon').addEventListener('mouseover', function() {
        document.getElementById('settings-menu').style.display = 'block';
    });

    document.getElementById('settings-menu').addEventListener('mouseleave', function() {
        document.getElementById('settings-menu').style.display = 'none';
    });
</script>



@include('CRM.footer')
