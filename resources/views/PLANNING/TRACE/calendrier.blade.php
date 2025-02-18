@include('CRM.header')
@include('CRM.sidebar')
@include('STYLE.PLANNING.PPM.styleCalendarPPM')
<div class="content-body">
    <div class="container-fluid">
        @include('PLANNING.headerPlan')
        <div class="row">
            <div class="card col-12">
                <div class="card-header">
                    <h2 class="card-title titre">PLANNING Trace</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg">
                            <div class="card">
                                <div class="stat-widget-one card-body ppm">
                                    <div class="stat-icon d-inline-block">
                                        <i class="fas fa-calendar text-success border-success"></i>
                                    </div>
                                    <div class="stat-content d-inline-block">
                                        <div class="stat-text ppm-color">PPM</div>
                                        <div class="stat-digit ppm-color"><span class="nb-trace">...</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="card">
                                <div class="stat-widget-one card-body achevement">
                                    <div class="stat-icon d-inline-block">
                                        <i class="fas fa-check-circle text-achevement border-achevement"></i>
                                    </div>
                                    <div class="stat-content d-inline-block">
                                        <div class="stat-text achevement-color">Complétion</div>
                                        <div class="stat-digit achevement-color"><span class="taux-achevement">...</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="card">
                                <div class="stat-widget-one card-body retard">
                                    <div class="stat-icon d-inline-block">
                                        <i class="fas fa-clock text-retard border-retard"></i>
                                    </div>
                                    <div class="stat-content d-inline-block">
                                        <div class="stat-text retard-color">Retard</div>
                                        <div class="stat-digit retard-color">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="card">
                                <div class="stat-widget-one card-body temps">
                                    <div class="stat-icon d-inline-block">
                                        <i class="fas fa-hourglass-start text-temps border-temps"></i>
                                    </div>
                                    <div class="stat-content d-inline-block">
                                        <div class="stat-text temps-color">A temps</div>
                                        <div class="stat-digit temps-color">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="card">
                                <div class="stat-widget-one card-body abs">
                                    <div class="stat-icon d-inline-block">
                                        <i class="fas fa-user-slash text-abs border-abs"></i>
                                    </div>
                                    <div class="stat-content d-inline-block">
                                        <div class="stat-text abs-color">Abscence</div>
                                        <div class="stat-digit abs-color">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

<!--Modal-->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateStatusForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Détails</h5>
                    <div class="form-check ml-auto">
                        <input type="checkbox" class="form-check-input" name="checkbox">
                        <label class="form-check-label" for="termineCheckbox">Terminé</label>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="cin-content">
                        <div class="cin-details" id="cin_details"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="enregistrerBtn">Modifier</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@vite(['resources/js/fullCalendar/trace.js'])
@include('CRM.footer')