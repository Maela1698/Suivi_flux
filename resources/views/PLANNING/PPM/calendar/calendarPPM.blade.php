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
