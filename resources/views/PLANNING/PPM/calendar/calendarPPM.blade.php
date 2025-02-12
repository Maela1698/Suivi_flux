@include('CRM.header')
@include('CRM.sidebar')
@include('STYLE.PLANNING.PPM.styleCalendarPPM')
<div class="content-body">
    <div class="container-fluid">
        @include('PLANNING.headerPlan')
        <div class="row">
            <div class="card col-12">
                <div class="card-header">
                    <h2 class="card-title titre">PLANNING PPMeeting</h2>
                    <form action="{{ route('LRP.listeDemandeForPpmeeting') }}" method="get">
                        @csrf
                        <button type="btn" class="btn btn-success">Listes</button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg">
                            <div class="card">
                                <div class="stat-widget-one card-body">
                                    <div class="stat-icon d-inline-block">
                                        <i class="ti-calendar text-success border-success"></i>
                                    </div>
                                    <div class="stat-content d-inline-block">
                                        <div class="stat-text">PPM</div>
                                        <div class="stat-digit"><span class="nb-ppm">...</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="card">
                                <div class="stat-widget-one card-body">
                                    <div class="stat-icon d-inline-block">
                                        <i class="ti-money text-success border-success"></i>
                                    </div>
                                    <div class="stat-content d-inline-block">
                                        <div class="stat-text">Profit</div>
                                        <div class="stat-digit">1,012</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="card">
                                <div class="stat-widget-one card-body">
                                    <div class="stat-icon d-inline-block">
                                        <i class="ti-user text-primary border-primary"></i>
                                    </div>
                                    <div class="stat-content d-inline-block">
                                        <div class="stat-text">Customer</div>
                                        <div class="stat-digit">961</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="card">
                                <div class="stat-widget-one card-body">
                                    <div class="stat-icon d-inline-block">
                                        <i class="ti-layout-grid2 text-pink border-pink"></i>
                                    </div>
                                    <div class="stat-content d-inline-block">
                                        <div class="stat-text">Projects</div>
                                        <div class="stat-digit">770</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="card">
                                <div class="stat-widget-one card-body">
                                    <div class="stat-icon d-inline-block">
                                        <i class="ti-link text-danger border-danger"></i>
                                    </div>
                                    <div class="stat-content d-inline-block">
                                        <div class="stat-text">Referral</div>
                                        <div class="stat-digit">2,781</div>
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
<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eventModalLabel">Détails du ppmeeting</h5>
        </div>
        <div class="modal-body">
            <div class="cin-content">
                <img id="modalImage">
                <div class="cin-details" id="cin_details"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
</div>
@vite(['resources/js/fullCalendar/ppMeeting.js'])
@include('CRM.footer')
