@include('CRM.header')
@include('CRM.sidebar')
@include('STYLE.PLANNING.PPM.styleCalendarPPM')
<div class="content-body">
    <div class="container-fluid">
        @include('PLANNING.headerPlan')
        <div class="row">
            <div class="card col-12">
                <div class="card-header">
                    <h4 class="card-title">PLANNING PPMeeting</h4>
                    <form action="{{ route('LRP.listeDemandeForPpmeeting') }}" method="get">
                        @csrf
                        <button type="btn" class="btn btn-success">Listes</button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="stat-widget-two card-body">
                                    <div class="stat-content">
                                        <div class="stat-text">Taux d'achevement</div>
                                        <div class="stat-digit"> <i class="fa fa-usd"></i>75%</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary w-75" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="stat-widget-two card-body">
                                    <div class="stat-content">
                                        <div class="stat-text">Taux de retard</div>
                                        <div class="stat-digit"> <i class="fa fa-usd"></i>15%</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-warning w-50" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="stat-widget-two card-body">
                                    <div class="stat-content">
                                        <div class="stat-text">Taux a temps</div>
                                        <div class="stat-digit"> <i class="fa fa-usd"></i>43%</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger w-65" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /# card -->
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="stat-widget-two card-body">
                                    <div class="stat-content">
                                        <div class="stat-text">Taux d'absence</div>
                                        <div class="stat-digit"> <i class="fa fa-usd"></i>56%</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success w-85" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                    </div>
                    <div id="calendar"></div>
                </div>
            </div>
            <!--card col-12-->
        </div>
        <!--row-->
    </div>
    <!--container-fluid-->
</div>
@vite(['resources/js/fullCalendar/ppMeeting.js'])
@include('CRM.footer')
