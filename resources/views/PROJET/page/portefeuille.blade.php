@include('PROJET.page.header')
@include('CRM.sidebar')
@include('PROJET.STYLE.stylePortefeuille')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Portefeuilles</h4>
                    <p class="mb-0">Your business dashboard template</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Bootstrap</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-briefcase text-success border-success"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Nombre</div>
                            <div class="stat-digit">5</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-check text-primary border-primary"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Acheve</div>
                            <div class="stat-digit">40%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-clipboard text-warning border-warning"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">En cours</div>
                            <div class="stat-digit">60%</div>
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
                        <h4 class="card-title mb-0">Filtre</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form>
                                <div class="form-row row gy-2">
                                    <div class="col-12 col-lg-3">
                                        <label>Chef</label>
                                        <input class="form-control" list="liste_chefs" id="chefInput">
                                        <datalist id="liste_chefs">
                                            <option data-id="">Santatra</option>
                                            <option data-id="">Kanto</option>
                                            <option data-id="">Notia</option>
                                        </datalist>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <label>Date debut</label>
                                        <input class="form-control" id="dateDebut" type="text" name="dateDebut">
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <label>Date fin</label>
                                        <input class="form-control" id="dateFin" type="text" name="dateFin">
                                    </div>
                                    <div class="col-12 col-lg-2">
                                        <label>Etat</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-12 col-lg-1 d-flex align-items-lg-end mt-2 mt-lg-0">
                                        <button type="button" class="btn btn-primary w-100">Filtrer</button>
                                    </div>
                                </div>
                            </form>
                        </div>                        
                    </div>
                </div>
                <!-- /# card -->
            </div>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Liste des Portefeuilles</h4>
                        <button type="button" class="btn btn-success">Ajouter</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Titre</th>
                                        <th>Chef</th>
                                        <th>Equipe</th>
                                        <th>Programmes</th>
                                        <th>Projets</th>
                                        <th>Debut</th>
                                        <th>Fin</th>
                                        <th>Avancement</th>
                                        <th>Etat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>PR0001</th>
                                        <td>ERP</td>
                                        <td>Santatra RANDRIANAHERY</td>
                                        <td>6</td>
                                        <td>5</td>
                                        <td>12</td>
                                        <td>12/05/2025</td>
                                        <td>03/08/2025</td>
                                        <td>12%</td>
                                        <td><span class="badge badge-primary">En cours</span></td>
                                    </tr>
                                    <tr>
                                        <th>PR0002</th>
                                        <td>CRM</td>
                                        <td>Notia Niavo</td>
                                        <td>4</td>
                                        <td>2</td>
                                        <td>8</td>
                                        <td>12/05/2025</td>
                                        <td>03/08/2025</td>
                                        <td>67%</td>
                                        <td><span class="badge badge-success">Acheve</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /# card -->
            </div>
        </div>
        <!-- row -->

    </div>
</div>
@include('PROJET.JS.jsPortefeuille')
@include('CRM.footer')