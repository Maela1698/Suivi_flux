@include('PROJET.page.header')
@include('CRM.sidebar')
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Liste des Portefeuilles</h4>
                        <button type="button" class="btn btn-success">Ajouter</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>1</th>
                                        <td>Kolor Tea Shirt For Man</td>
                                        <td><span class="badge badge-primary">Sale</span>
                                        </td>
                                        <td>January 22</td>
                                        <td class="color-primary">$21.56</td>
                                    </tr>
                                    <tr>
                                        <th>2</th>
                                        <td>Kolor Tea Shirt For Women</td>
                                        <td><span class="badge badge-success">Tax</span>
                                        </td>
                                        <td>January 30</td>
                                        <td class="color-success">$55.32</td>
                                    </tr>
                                    <tr>
                                        <th>3</th>
                                        <td>Blue Backpack For Baby</td>
                                        <td><span class="badge badge-danger">Extended</span>
                                        </td>
                                        <td>January 25</td>
                                        <td class="color-danger">$14.85</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /# card -->
            </div>
        </div>
    </div>
</div>
@include('CRM.footer')