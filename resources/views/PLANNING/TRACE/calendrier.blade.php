@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">
    <div class="container-fluid">
        @include('PLANNING.headerPlan')
        <div class="row">
            <div class="card col-12">
                <div class="card-header">
                    <h2 class="card-title titre">PLANNING Trace</h2>
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
                        <img id="modalImage">
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