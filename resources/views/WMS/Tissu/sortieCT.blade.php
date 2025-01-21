@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">
    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card col-12">
            <div class="card-header d-flex justify-content-between align-items-center entete">
                <h3 class="entete">NOUVELLE ENTREE DE CHAINE ET TRAME</h3>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="{{ route('CRM.nouveauDemande') }}" method="post"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="form-group row">
                            <div class="col-6">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Date entrée </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="date" class="form-control" name="dateentre" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">date facturation </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="date" class="form-control" name="datefacturation" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Utilisation</label>
                                    </div>
                                    <div class="col-12">
                                        <select class="form-control" name="idutilisationwms" required>
                                            <option value="">Production</option>
                                            <option value="0">coupe type</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Numéro BC</label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="nom_modele">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Numero Bon de livraison </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="theme">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">LaizePl </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="number" name="laizepl" class="form-control" placeholder="LaizePl"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Quantite reçue </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="number" name="qterecu" class="form-control"
                                            placeholder="Quantite reçue" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Unité de mesure </label>
                                    </div>
                                    <div class="col-12">
                                        <select class="form-control" name="idUniteMesureMatierePremiere" required>
                                            <option value="">m</option>
                                            <option value="0">inch</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Nombre de rouleau </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="number" name="nbrouleau" class="form-control"
                                            placeholder="nombre de rouleau" required>

                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Nombre de lot </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="number" name="nblot" class="form-control"
                                            placeholder="nombre de rouleau" required>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-6">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Désignation du tissu</label>
                                    </div>
                                    <div class="col-12">
                                        <input type="number" name="nblot" class="form-control"
                                            placeholder="désignation" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Couleur </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="number" name="nblot" class="form-control"
                                            placeholder="couleur du tissu" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{-- <div class="col-6">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Requête client </label>
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control requete" name="requeteClient" rows="4" cols="50"></textarea>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Commentaire</label>
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control requete" name="commentaireMerch" rows="4" cols="50"></textarea>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Image</label>
                                    </div>
                                    <div class="col-12">
                                        <input type="file" class="form-control" name="photo_commande">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Ajouter</button>
                            </div>
                        </div>


                        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('CRM.footer')
