@include('CRM.header')
@include('CRM.sidebar')
<title>KPI</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .progress {
        background-color: #e9ecef;
        border-radius: 0.25rem;
        overflow: hidden;
        height: 1rem;
        width: 100%;
    }

    .progress-bar {
        height: 100%;
        line-height: 1rem;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        background-color: #007bff;
        transition: width 0.6s ease;
    }

    .progress-text {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        height: 100%;
        padding-right: 0.02rem;
        /* Space between the text and the progress bar */
    }

    .progress-container {
        display: flex;
        align-items: center;
    }

    .card1 {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.card1-body {
    flex: 1;
}

.card2 {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.card2-body {
    flex: 1;
}

  #suggestionsListSaison {
    max-height: 200px;
    overflow-y: auto;
    color: #767575;
    z-index: 5000;
    position: absolute;
    /* Permet de positionner l'élément par rapport à son conteneur */
    background-color: #fff;
    border: 1px solid #ccc;
    width: 100%;
    /* Assure que la largeur de la liste correspond à celle du champ */
    top: 100%;
    /* Place la liste juste en dessous du champ */
    left: 0;
    /* Aligne la liste avec le champ */
}

  #suggestionsListTiers {
    max-height: 200px;
    overflow-y: auto;
    color: #767575;
    z-index: 5000;
    position: absolute;
    /* Permet de positionner l'élément par rapport à son conteneur */
    background-color: #fff;
    border: 1px solid #ccc;
    width: 100%;
    /* Assure que la largeur de la liste correspond à celle du champ */
    top: 100%;
    /* Place la liste juste en dessous du champ */
    left: 0;
    /* Aligne la liste avec le champ */
}
</style>
<script>
    // Function to update all progress bars
    function updateProgressBars() {
        const progressBars = document.querySelectorAll('.progress-bar');

        progressBars.forEach(progressBar => {
            const value = parseFloat(progressBar.getAttribute('data-value'));
            const max = parseFloat(progressBar.getAttribute('data-max'));
            const percentage = (value / max) * 100;
            console.log(percentage);
            // Update the progress bar width and aria attributes
            progressBar.style.width = percentage + '%';
            progressBar.setAttribute('aria-valuenow', value);
            progressBar.setAttribute('aria-valuemax', max);
            progressBar.textContent = value + '%'; // Display rounded percentage
        });
    }

    document.addEventListener('DOMContentLoaded', updateProgressBars);


</script>


<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')

        <form action="{{ route('DEV.rechercheSuiviConso') }}" method="post" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-3">
                    <div class="input-group">
                        <input type="text" id="nomTiers" name="nomTiers" class="form-control" placeholder="Nom Client"
                            value="">
                        <input type="hidden" id="idTiers" name="idTiers" value="">
                        <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                        </ul>
                    </div>
                </div>

                <div class="col-3">
                    <div class="input-group">
                        <input type="text" id="nomSaison" name="nomSaison" class="form-control" placeholder="Saison"
                            value="">
                        <input type="hidden" id="idSaison" name="idSaison" value="">
                        <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;">
                        </ul>
                    </div>
                </div>

                <div class="col-3">
                    <div class="input-group">
                        <input type="text" id="nomSaison" name="nomSaison" class="form-control" placeholder="Merch"
                            value="">
                    </div>
                </div>
                <div class="col-3">
                    <div class="col-3 d-flex justify-content-end">
                        <button class="btn btn-success" style="width: 100px">Filtrer</button>
                    </div>
                </div>
            </div>
        </form>


        <div class="row mt-3">
            <div class="col-10">
                <div class="row">

                    <div class="col-6">
                        <div class="card card1">
                            <div class="card-header">
                                <h4 class="card-title">TAUX CONFIRM PAR CLIENT (0 à {{ number_format($pourcentageConfirmeClient, 0) }}%)</h4>
                            </div>
                            <div class="card-body">
                                <div class="progress-content py-2">
                                    @for ($tC=0; $tC<count($tauxConfirmeClient); $tC++)
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="progress-text  justify-content-end">{{ $tauxConfirmeClient[$tC]->nomtier }}</div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="current-progressbar">
                                                <div class="progress">
                                                    <div class="progress-bar" data-value="{{ number_format($tauxConfirmeClient[$tC]->pourcentage, 2) }}" data-max="{{ $pourcentageConfirmeClient }}"
                                                        role="progressbar" aria-valuenow="{{ number_format($tauxConfirmeClient[$tC]->pourcentage, 2) }}" aria-valuemin="0"
                                                        aria-valuemax="{{ $pourcentageConfirmeClient }}">
                                                        <span style="position: absolute; width: 100%; text-align: center; color: black;">
                                                            {{ number_format($tauxConfirmeClient[$tC]->pourcentage, 2) }}%
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endfor


                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="card card1">
                            <div class="card-header">
                                <h4 class="card-title">TAUX CONVERSION PAR CLIENT(0 à {{ $pourcentage }}%)</h4>
                            </div>
                            <div class="card-body">
                                <div class="progress-content py-2">
                                    @for ($i=0; $i<count($tauxConversionClient); $i++)
                                    <div class="row" style="color: black;">
                                        <div class="col-lg-4">
                                            <div class="progress-text justify-content-end">{{ $tauxConversionClient[$i]->nomtier }}</div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="current-progressbar">
                                                <div class="progress">
                                                    <div class="progress-bar" data-value="{{ number_format($tauxConversionClient[$i]->pourcentage, 2) }}" data-max="{{ $pourcentage }}"
                                                        role="progressbar" aria-valuenow="{{ number_format($tauxConversionClient[$i]->pourcentage, 2) }}" aria-valuemin="0"
                                                        aria-valuemax="{{ $pourcentage }}" style="position: relative;">
                                                        <span style="position: absolute; width: 100%; text-align: center; color: black;">
                                                            {{ number_format($tauxConversionClient[$i]->pourcentage, 2) }}%
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endfor


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--  deuxieme ligne  --}}
                <div class="row mt-3">

                    <div class="col-6">
                        <div class="card card2">
                            <div class="card-header">
                                <h4 class="card-title">TAUX CONFIRME par MERCH</h4>
                            </div>
                            <div class="card-body">
                                <div class="progress-content py-2">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="progress-text  justify-content-end">Mobile</div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="current-progressbar">
                                                <div class="progress">
                                                    <div class="progress-bar" data-value="250" data-max="500"
                                                        role="progressbar" aria-valuenow="250" aria-valuemin="0"
                                                        aria-valuemax="500">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Add more progress bars as needed -->
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="progress-text">Tablet</div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="current-progressbar">
                                                <div class="progress">
                                                    <div class="progress-bar" data-value="200" data-max="500"
                                                        role="progressbar" aria-valuenow="200" aria-valuemin="0"
                                                        aria-valuemax="500">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="progress-text">Tablet</div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="current-progressbar">
                                                <div class="progress">
                                                    <div class="progress-bar" data-value="207.32" data-max="500"
                                                        role="progressbar" aria-valuenow="207.32" aria-valuemin="0"
                                                        aria-valuemax="500">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="card card2">
                            <div class="card-header">
                                <h4 class="card-title">TAUX CONVERSION PAR MERCH</h4>
                            </div>
                            <div class="card-body">
                                <div class="progress-content py-2">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="progress-text  justify-content-end">Mobile</div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="current-progressbar">
                                                <div class="progress">
                                                    <div class="progress-bar" data-value="250" data-max="500"
                                                        role="progressbar" aria-valuenow="250" aria-valuemin="0"
                                                        aria-valuemax="500">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Add more progress bars as needed -->
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="progress-text">Tablet</div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="current-progressbar">
                                                <div class="progress">
                                                    <div class="progress-bar" data-value="200" data-max="500"
                                                        role="progressbar" aria-valuenow="200" aria-valuemin="0"
                                                        aria-valuemax="500">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" col-2 ml-auto">
                <div class="card shadow-sm" style="width: 12rem; border-radius: 10px;">
                    <div class="card-body d-flex justify-content-between align-items-center p-3">
                        <div>
                            <h4 class="mb-0" style="color: #28a745;">{{ $nbCommandeV }}</h4>
                            <p class="mb-0" style="color: #6c757d;">NB CMD CONF</p>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"
                                stroke="#e74c3c" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2v10l6 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm" style="width: 12rem; border-radius: 10px;">
                    <div class="card-body d-flex justify-content-between align-items-center p-3">
                        <div>
                            <h4 class="mb-0" style="color: #28a745;">{{ $nbQteCommandeV }}</h4>
                            <p class="mb-0" style="color: #6c757d;">QTE CONF</p>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"
                                stroke="#e74c3c" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2v10l6 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm" style="width: 12rem; border-radius: 10px;">
                    <div class="card-body d-flex justify-content-between align-items-center p-3">
                        <div>
                            <h4 class="mb-0" style="color: #28a745;">{{ number_format($tauxConfirmeGeneral, 2) }} %</h4>
                            <p class="mb-0" style="color: #6c757d;">TAUX CONF</p>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"
                                stroke="#e74c3c" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2v10l6 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm" style="width: 12rem; border-radius: 10px;">
                    <div class="card-body d-flex justify-content-between align-items-center p-3">
                        <div>
                            <h4 class="mb-0" style="color: #28a745;">{{ number_format($tauxConversion, 2) }} %</h4>
                            <p class="mb-0" style="color: #6c757d;">TAUX CONVERSION</p>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"
                                stroke="#e74c3c" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2v10l6 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>


<!--**********************************
        modal start
***********************************-->


<!--**********************************
        javascript start
***********************************-->


{{--  saison  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomSaison = document.getElementById('nomSaison');
        var idSaison = document.getElementById('idSaison');
        var suggestionsList = document.getElementById('suggestionsListSaison');

        nomSaison.addEventListener('input', function() {
            var query = nomSaison.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('recherche-saison') }}?nomSaison=' + encodeURIComponent(query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function(saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.type_saison;
                            li.addEventListener('click', function() {
                                nomSaison.value = saison.type_saison;
                                idSaison.value = saison.id;
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(li);
                        });
                        suggestionsList.style.display = 'block';
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                }
            };
            xhr.send();
        });

        document.addEventListener('click', function(event) {
            if (!nomSaison.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

{{--  tiers  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomTiers = document.getElementById('nomTiers');
        var idTiers = document.getElementById('idTiers');
        var suggestionsListTiers = document.getElementById('suggestionsListTiers');

        nomTiers.addEventListener('input', function() {
            var query = nomTiers.value;

            if (query.length < 1) {
                suggestionsListTiers.style.display = 'none';
                return;
            }

            var xhr1 = new XMLHttpRequest();
            xhr1.open('GET', '{{ route('recherche-tiers-demande') }}?nomTiers=' + encodeURIComponent(
                query), true);
            xhr1.onload = function() {
                if (xhr1.status === 200) {
                    var tiers = JSON.parse(xhr1.responseText);
                    suggestionsListTiers.innerHTML = '';
                    if (tiers.length > 0) {
                        tiers.forEach(function(tier) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = tier.nomtier;
                            li.addEventListener('click', function() {
                                nomTiers.value = tier.nomtier;
                                idTiers.value = tier.id;
                                suggestionsListTiers.style.display = 'none';
                            });
                            suggestionsListTiers.appendChild(li);
                        });
                        suggestionsListTiers.style.display = 'block';
                    } else {
                        suggestionsListTiers.style.display = 'none';
                    }
                }
            };
            xhr1.send();
        });

        document.addEventListener('click', function(event) {
            if (!nomTiers.contains(event.target) && !suggestionsListTiers.contains(event.target)) {
                suggestionsListTiers.style.display = 'none';
            }
        });
    });
</script>


<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
