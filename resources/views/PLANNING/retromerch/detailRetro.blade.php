@include('CRM.header')
@include('CRM.sidebar')
<style>
    .button-group {
        margin-top: -10px;
        margin-right: 20px;
        display: flex;
        justify-content: flex-end;
        /* Aligne les éléments à droite */
        gap: 10px;
        /* Espace entre les boutons */
    }

    h2 {
        font-size: 22px;
        margin: 20px 0;
        text-align: center;
        color: #333;
    }

    .containerss {
        display: flex;
        flex-wrap: wrap;
        /* Permet aux éléments de passer à la ligne suivante si nécessaire */
        gap: 10px;
        /* Espace entre les sections */
        padding: 0 20px;
        justify-content: space-between;
        /* Aligne les éléments horizontalement */
    }

    .section1 {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 30px;
        width: calc(25% - 10px);
        /* Ajuste la largeur pour quatre sections par ligne */
        background-color: #fff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        /* Inclut le padding et la bordure dans la largeur totale */
    }

    /* Dégradés spécifiques pour chaque section */
    .section1:nth-of-type(1) {
        background: linear-gradient(135deg, #e3f2fd, #f1ffd1);
        /* Dégradé léger bleu */
    }

    .section1:nth-of-type(2) {
        background: linear-gradient(135deg, #e8f5e9, #b2f5ef);
        /* Dégradé léger vert */
    }

    .section1:nth-of-type(3) {
        background: linear-gradient(135deg, #e3f2fd, #f1ffd1);
        /* Dégradé léger bleu clair */
    }

    .section1:nth-of-type(4) {
        background: linear-gradient(135deg, #e8f5e9, #b2f5ef);
        /* Dégradé léger rose */
    }

    .section1 h3 {
        font-size: 16px;
        margin: 0 0 10px;
        color: #242424;
    }

    .header-section1 {
        display: flex;
        margin: 20px;
        gap: 10px;
    }

    .input-box {
        width: 80px;
        padding: 4px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-align: left;
        font-size: 12px;
    }

    .input-box.red {
        background-color: #f44336;
        color: #fff;
    }

    .input-box.green {
        background-color: #97da4a;
    }

    .input-box.blue {
        background-color: #5ee1f3;
    }

    .input-box.gray {
        background-color: #f5f5f5;
    }

    .field-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .field-row label {
        flex: 1;
        text-align: left;
        font-size: 12px;
    }

    .field-row input {
        flex: 1;
        text-align: right;
        font-size: 12px;
    }

    .button {
        padding: 8px 16px;
        margin: 10px;
        background-color: #e0e0e0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
    }

    .button:hover {
        background-color: #dcdcdc;
    }

    .button.primary {
        background-color: #90caf9;
        color: #fff;
    }

    .checkbox {
        margin-left: 10px;
    }

    label {
        color: #444444;
    }
    .content-body {
        background-color: #0C275E;
    }
</style>
<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('PLANNING.headerPlan')
        <div class="row">
            <div class="card" style="border-radius: 10px;width: 105%;">

                <h2>DETAILS RETRO</h2>
                <div class="row mt-3" style="display: flex; align-items: center;margin-left:100px;">
                    <div class="col-md-2 mt-1">
                        <center>
                            <img src="data:image/png;base64,{{ $demande[0]->photo_commande }}"
                                class="img-fluid rounded-start mb-5" style="margin-left: -50px;" alt="Logo"
                                width="120px" height="120px">
                        </center>
                    </div>
                    <div class="col-md-5">
                        <div class="card-body">
                            <p class="texte"><b>Date entrée :</b>
                                {{ \Carbon\Carbon::parse($demande[0]->date_entree)->format('d/m/y') }}</p>
                            <p class="texte"><b>Client :</b> {{ $demande[0]->nomtier }}</p>
                            <p class="texte"><b>Modèle :</b>{{ $demande[0]->nom_modele }}</p>
                            <p class="texte"><b>Style :</b>{{ $demande[0]->nom_style }}</p>
                            <p class="texte"><b>Thème :</b>{{ $demande[0]->theme }}</p>
                            <p class="texte"><b>Quantité prévisionnel
                                    :</b>{{ $demande[0]->qte_commande_provisoire }}</p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card-body">
                            <p class="texte">
                                <b>ETD:</b>{{ \Carbon\Carbon::parse($demande[0]->date_livraison)->format('d/m/y') }}
                            </p>
                            <p class="texte"><b>Stade :</b> {{ $demande[0]->type_stade }}</p>
                            <p class="texte"><b>Grille de taille
                                    :</b>{{ $demande[0]->taillemin }}--{{ $demande[0]->taillemax }}</p>
                            <p class="texte"><b>Taille de base :</b>{{ $demande[0]->taille_base }}</p>
                            <p class="texte"><b>Incontern :</b> {{ $demande[0]->type_incontern }}</p>
                            <p class="texte"><b>Phase :</b> {{ $demande[0]->type_phase }}</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="header-section1">
                    <div>
                        <label>Besoin OK PROD:</label>
                        <input type="text" style="text-align: center;width:110px;" class="input-box" value="{{ \Carbon\Carbon::parse($prod)->format('d/m/Y') }}" readonly>
                    </div>
                    <div>
                        <label>Retard :</label>
                        @if($retard >0)
                        <input type="text" style="text-align: center;background-color:rgb(255, 139, 139);" class="input-box" value="{{ $retard }} jours" readonly>
                        @else
                        <input type="text" style="text-align: center;background-color:rgb(139, 255, 166);" class="input-box" value="{{ $retard }} jours" readonly>
                        @endif

                    </div>
                </div>

                <div class="containerss">
                    <!-- Proto section1 -->
                    <div class="section1">
                        <h3>PROTO 1</h3>
                        @for ($i = 0; $i < 5; $i++)
                            @if ($result[$i]->resultat_etat != 0)
                                <div class="field-row">
                                    <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " readonly>
                                </div>
                            @endif
                            @if(!empty($result[$i]->micro_realisation))
                                    <div class="field-row">
                                        <label>{{ $result[$i]->etape_designation }}:</label>
                                            <input type="text" class="input-box " style="background-color: rgb(139, 255, 166);"
                                            value=" {{ \Carbon\Carbon::parse($result[$i]->micro_realisation)->format('d/m/Y') }}"
                                            readonly>
                                    </div>
                                @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul<$today)
                                    <div class="field-row">
                                        <label>{{ $result[$i]->etape_designation }}:</label>
                                            <input type="text" class="input-box " style="background-color: rgb(255, 139, 139);"
                                            value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                            readonly>
                                    </div>
                                @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul>=$today)
                                    <div class="field-row">
                                        <label>{{ $result[$i]->etape_designation }}:</label>
                                            <input type="text" class="input-box "
                                            value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                            readonly>
                                    </div>
                            @endif
                        @endfor

                        <h3>PROTO 2 <input type="checkbox" class="checkbox" data-id="{{ $result[5]->id_etape }}" data-demande="{{ $idDemande }}"
                                checked></h3>
                        @for ($i = 5; $i < 10; $i++)
                            @if ($result[$i]->resultat_etat != 0)
                                <div class="field-row">
                                    <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " readonly>
                                </div>
                            @else
                                @if(!empty($result[$i]->micro_realisation))
                                <div class="field-row">
                                    <label>{{ $result[$i]->etape_designation }}:</label>
                                        <input type="text" class="input-box " style="background-color: rgb(139, 255, 166);"
                                        value=" {{ \Carbon\Carbon::parse($result[$i]->micro_realisation)->format('d/m/Y') }}"
                                        readonly>
                                </div>
                            @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul<$today)
                                <div class="field-row">
                                    <label>{{ $result[$i]->etape_designation }}:</label>
                                        <input type="text" class="input-box " style="background-color: rgb(255, 139, 139);"
                                        value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                        readonly>
                                </div>
                            @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul>=$today)
                                <div class="field-row">
                                    <label>{{ $result[$i]->etape_designation }}:</label>
                                        <input type="text" class="input-box "
                                        value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                        readonly>
                                </div>
                            @endif
                            @endif
                        @endfor
                    </div>

                    <!-- TDS section1 -->
                    <div class="section1">
                        <h3>TDS 1 <input type="checkbox" class="checkbox" data-id="{{ $result[10]->id_etape }}" data-demande="{{ $idDemande }}"
                                checked></h3>
                        @for ($i = 10; $i < 15; $i++)
                            @if ($result[$i]->resultat_etat != 0)
                                <div class="field-row">
                                    <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " readonly>
                                </div>
                            @else
                            @if(!empty($result[$i]->micro_realisation))
                            <div class="field-row">
                                <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " style="background-color: rgb(139, 255, 166);"
                                    value=" {{ \Carbon\Carbon::parse($result[$i]->micro_realisation)->format('d/m/Y') }}"
                                    readonly>
                            </div>
                        @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul<$today)
                            <div class="field-row">
                                <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " style="background-color: rgb(255, 139, 139);"
                                    value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                    readonly>
                            </div>
                        @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul>=$today)
                            <div class="field-row">
                                <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box "
                                    value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                    readonly>
                            </div>
                    @endif
                            @endif
                        @endfor

                        <h3>TDS 2 <input type="checkbox" class="checkbox" data-id="{{ $result[15]->id_etape }}" data-demande="{{ $idDemande }}"
                                checked></h3>
                        @for ($i = 15; $i < 20; $i++)
                            @if ($result[$i]->resultat_etat != 0)
                                <div class="field-row">
                                    <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " readonly>
                                </div>
                            @else
                            @if(!empty($result[$i]->micro_realisation))
                            <div class="field-row">
                                <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " style="background-color: rgb(139, 255, 166);"
                                    value=" {{ \Carbon\Carbon::parse($result[$i]->micro_realisation)->format('d/m/Y') }}"
                                    readonly>
                            </div>
                        @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul<$today)
                            <div class="field-row">
                                <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " style="background-color: rgb(255, 139, 139);"
                                    value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                    readonly>
                            </div>
                        @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul>=$today)
                            <div class="field-row">
                                <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box "
                                    value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                    readonly>
                            </div>
                    @endif
                            @endif
                        @endfor
                    </div>

                    <!-- PPS section1 -->
                    <div class="section1">
                        <h3>PPS 1 </h3>
                        @for ($i = 20; $i < 25; $i++)
                            @if ($result[$i]->resultat_etat != 0)
                                <div class="field-row">
                                    <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " readonly>
                                </div>
                            @else
                            @if(!empty($result[$i]->micro_realisation))
                            <div class="field-row">
                                <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " style="background-color: rgb(139, 255, 166);"
                                    value=" {{ \Carbon\Carbon::parse($result[$i]->micro_realisation)->format('d/m/Y') }}"
                                    readonly>
                            </div>
                        @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul<$today)
                            <div class="field-row">
                                <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " style="background-color: rgb(255, 139, 139);"
                                    value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                    readonly>
                            </div>
                        @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul>=$today)
                            <div class="field-row">
                                <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box "
                                    value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                    readonly>
                            </div>
                    @endif
                            @endif
                        @endfor

                        <h3>PPS 2<input type="checkbox" class="checkbox" data-id="{{ $result[25]->id_etape }}" data-demande="{{ $idDemande }}"
                                checked></h3>
                        @for ($i = 25; $i < 30; $i++)
                            @if ($result[$i]->resultat_etat != 0)
                                <div class="field-row">
                                    <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " readonly>
                                </div>
                            @else
                            @if(!empty($result[$i]->micro_realisation))
                            <div class="field-row">
                                <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " style="background-color: rgb(139, 255, 166);"
                                    value=" {{ \Carbon\Carbon::parse($result[$i]->micro_realisation)->format('d/m/Y') }}"
                                    readonly>
                            </div>
                        @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul<$today)
                            <div class="field-row">
                                <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " style="background-color: rgb(255, 139, 139);"
                                    value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                    readonly>
                            </div>
                        @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul>=$today)
                            <div class="field-row">
                                <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box "
                                    value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                    readonly>
                            </div>
                    @endif
                            @endif
                        @endfor
                    </div>

                    <!-- Autres section1 -->
                    <div class="section1">
                        <h3>AUTRES</h3>
                        @for ($i = 30; $i < 33; $i++)
                        @if(!empty($result[$i]->micro_realisation))
                        <div class="field-row">
                            <label>{{ $result[$i]->etape_designation }}:</label>
                                <input type="text" class="input-box " style="background-color: rgb(139, 255, 166);"
                                value=" {{ \Carbon\Carbon::parse($result[$i]->micro_realisation)->format('d/m/Y') }}"
                                readonly>
                        </div>
                        @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul<$today)
                            <div class="field-row">
                                <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box " style="background-color: rgb(255, 139, 139);"
                                    value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                    readonly>
                            </div>
                        @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul>=$today)
                            <div class="field-row">
                                <label>{{ $result[$i]->etape_designation }}:</label>
                                    <input type="text" class="input-box "
                                    value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                    readonly>
                            </div>
                        @endif
                            @endfor
                        <br>
                        @for ($i = 34; $i < 38; $i++)
                            @if(!empty($result[$i]->micro_realisation))
                                    <div class="field-row">
                                        <label>{{ $result[$i]->etape_designation }}:</label>
                                            <input type="text" class="input-box " style="background-color: rgb(139, 255, 166);"
                                            value=" {{ \Carbon\Carbon::parse($result[$i]->micro_realisation)->format('d/m/Y') }}"
                                            readonly>
                                    </div>
                                @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul<$today)
                                    <div class="field-row">
                                        <label>{{ $result[$i]->etape_designation }}:</label>
                                            <input type="text" class="input-box " style="background-color: rgb(255, 139, 139);"
                                            value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                            readonly>
                                    </div>
                                @elseif(empty($result[$i]->micro_realisation) && $result[$i]->datecalcul>=$today)
                                    <div class="field-row">
                                        <label>{{ $result[$i]->etape_designation }}:</label>
                                            <input type="text" class="input-box "
                                            value=" {{ \Carbon\Carbon::parse($result[$i]->datecalcul)->format('d/m/Y') }}"
                                            readonly>
                                    </div>
                            @endif
                        @endfor
                    </div>
                </div>
                <br>
                {{-- <div class="button-group">
                    <form action="" method="get">
                        <button type="submit" class="btn btn-info">Retour</button>
                    </form>
                    <form action='' method='POST'>
                        @csrf
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </form>
                </div> --}}
                <br>
            </div>
        </div>
    </div>
</div>
<!--**********************************
            Content body end
        ***********************************-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Charger l'état des cases à cocher depuis localStorage
        $('.checkbox').each(function() {
            const id = $(this).data('id');
            const checked = localStorage.getItem(`checkbox-${id}`) === 'true';
            $(this).prop('checked', checked);
        });

        // Détecter les changements de l'état des checkboxes
        $('.checkbox').on('change', function() {
            const id = $(this).data('id');
            const idDemande = $(this).data('demande');
            const isChecked = $(this).is(':checked');


            // Sauvegarder l'état dans localStorage
            localStorage.setItem(`checkbox-${id}`, isChecked);

            // Envoyer une requête AJAX pour mettre à jour l'état dans la base de données
            $.ajax({
                url: '/update-etat',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    idDemande: idDemande,
                    checked: isChecked
                },
                success: function(response) {
                    // Optionnel : Vous pouvez afficher un message ou mettre à jour d'autres parties de la page ici
                    window.location
                .reload(); // Décommenter si vous souhaitez recharger la page après la mise à jour
                },
                error: function(xhr, status, error) {
                    console.error('Erreur:', error);
                }
            });
        });
    });
</script>


@include('CRM.footer')
