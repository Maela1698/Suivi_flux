@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">
    <div class="container-fluid">
        <div class="row" style="margin-top:-50px;">
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-1 card-small"
                    style="border-radius: 28px 3px 28px 3px; background: linear-gradient(to right, #3a7bd5, #3a6073);">
                    <div class="card-body mb-5" style="margin-top: -10px; margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">Nbr Réclamation</h3>
                        <div class="d-inline-block mb-5">
                            <h2 class="text-white">{{ number_format($nombres, 0, ',', ' ') }}
                            </h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-exclamation-circle"
                                style="color: white;font-size:25px;"></i></span>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 28px 3px 28px 3px; background: linear-gradient(to right, #e13a4e, #556770)">
                    <div class="card-body mb-5" style="margin-top: -10px; margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">Valeur Réclamé</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ number_format($valeurreclame, 0, ',', ' ') }}€</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-coins"
                                style="color: white;font-size:25px;"></i></span>

                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-4 card-small"
                    style="border-radius: 28px 3px 28px 3px; background: linear-gradient(to right, #16a085, #f4d03f)">
                    <div class="card-body mb-5" style="margin-top: -10px; margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">Valeur Compensé</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ number_format($compense, 0, ',', ' ') }}€</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-handshake"
                                style="color: white;font-size:25px;"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 28px 3px 28px 3px; background: linear-gradient(135deg, #B48EAD 0%, #5E81AC 100%);">
                    <div class="card-body mb-5" style="margin-top: -10px; margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">Reste à Réclamé</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ number_format($reste, 0, ',', ' ') }}€</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-hourglass-half"
                                style="color: white;font-size:25px;"></i></span>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12" style="margin-top: -15px">
            <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                <div class="card-header text-center" style="display: flex; justify-content: space-between;">
                    <h3 class="entete">VUE GRAPHIQUE RECLAMATION FOURNISSEUR</h3>
                    <form action="/detailreclamation" method="get">
                        @csrf
                        <button class="btn btn-info" style="margin-right: 15px;">Retour</button>
                    </form>
                </div>
                <br>
                <div class="card-body" style="margin-top: -40px;">
                    <form action="{{ route('CRM.nouvelleBc') }}" method="get">
                        @csrf
                        <div class="recherche" style="display: flex; align-items: center;">
                            <div class="col-auto my-1">
                                <label class="mr-sm-2" for="inlineFormInput">Fournisseur</label>
                                <div class="input-group">
                                    <input type="text" id="nomSaison" class="form-control" placeholder="Fournisseur">
                                    <input type="hidden" id="idSaison" name="idSaison">
                                    <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;">
                                    </ul>
                                </div>
                            </div>
                            <div class="col-auto my-1">
                                <label class="mr-sm-2" for="inlineFormInput">Date Réclamation</label>
                                <div class="input-group" id="date-range">
                                    <input type="date" class="form-control" name="startEmmission">
                                    <span class="input-group-addon b-0 text-white"
                                        style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                    <input type="date" class="form-control" name="endEmmission">
                                </div>
                            </div>
                            <div class="col-auto my-1">
                                <label class="mr-sm-2" for="inlineFormInput">Date Relance</label>
                                <div class="input-group" id="date-range">
                                    <input type="date" class="form-control" name="startDeadline">
                                    <span class="input-group-addon b-0 text-white"
                                        style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                    <input type="date" class="form-control" name="endDeadline">
                                </div>
                            </div>
                            <div class="col-auto my-1" style="flex-grow: 1;">
                                <label class="mr-sm-2" for="inlineFormInput"
                                    style="color: transparent;">Search</label>
                                <input type="submit" style="background-color: rgb(51, 208, 51);width:100px;"
                                    class="form-control mr-sm-2" id="inlineFormInput" value="Filtrer">
                            </div>
                        </div>
                    </form>

                    <div style="margin-left: 15px; margin-top:10px;">
                        <button class="btn btn-secondary" id="parPrixBtn" style="display: none">Par Prix</button>
                        <button class="btn btn-primary" id="parNbrReclamationBtn" style="display: none">Par Nbr Réclamation</button>
                    </div>
                        <!-- Graphique pour le Prix -->
                        <canvas id="myPriceChart" style="width: 100%; height: {{ $nombrefournisseur[0]->nbrfournisseur+1 }}00px;margin-top:-15px;"></canvas>

                        <!-- Graphique pour le Nombre de Réclamations -->
                        <canvas id="myNbrReclamationChart"
                            style="width: 1170px; height: {{ $nombrefournisseur[0]->nbrfournisseur+1 }}00px;margin-top:-15px; display: none;"></canvas>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('parPrixBtn').addEventListener('click', function() {
        // Afficher le graphique Par Prix et masquer l'autre
        document.getElementById('myPriceChart').style.display = 'block';
        document.getElementById('myNbrReclamationChart').style.display = 'none';
        document.getElementById('parPrixBtn').style.display = 'none';
        document.getElementById('parNbrReclamationBtn').style.display = 'block';
    });

    document.getElementById('parNbrReclamationBtn').addEventListener('click', function() {
        // Afficher le graphique Par Nbr Réclamation et masquer l'autre
        document.getElementById('myPriceChart').style.display = 'none';
        document.getElementById('myNbrReclamationChart').style.display = 'block';
        document.getElementById('parNbrReclamationBtn').style.display = 'none';
        document.getElementById('parPrixBtn').style.display = 'block';
    });

    const ctxPrice = document.getElementById('myPriceChart').getContext('2d');

    new Chart(ctxPrice, {
        type: 'bar',
        data: {
            labels: @json($prix->pluck('nomtier')),
            datasets: [{
                    label: 'Valeur réclamée',
                    data: @json($prix->pluck('total_valeurreclame')),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Reste à réclamer',
                    data: @json($prix->pluck('total_reste')),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Valeur compensée',
                    data: @json($prix->pluck('total_valeurcompense')),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: {
                    display: true
                },
                title: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            let label = tooltipItem.dataset.label || '';
                            let value = tooltipItem.raw + '€';
                            return label + ': ' + value;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + '€';
                        }
                    }
                }
            }
        }
    });

    const ctxNbrReclamation = document.getElementById('myNbrReclamationChart').getContext('2d');

    new Chart(ctxNbrReclamation, {
        type: 'bar',
        data: {
            labels: @json($nombre->pluck('nomtier')),
            datasets: [{
                    label: 'Valeur réclamée',
                    data: @json($nombre->pluck('total_valeurreclame')),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Reste à réclamer',
                    data: @json($nombre->pluck('total_reste')),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Valeur compensée',
                    data: @json($nombre->pluck('total_valeurcompense')),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: {
                    display: true
                },
                title: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            let label = tooltipItem.dataset.label || '';
                            let value = tooltipItem.raw + '€';
                            return label + ': ' + value;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + '€';
                        }
                    }
                }
            }
        }
    });
</script>

@include('CRM.footer')
