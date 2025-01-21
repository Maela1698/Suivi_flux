<style>
    .entete {
        color: #7571f9; /* Ajuster la couleur du texte si n�cessaire */
        background-color: white;
    }
    .carte {
        color: white; /* Ajuster la couleur du texte si n�cessaire */
        background-color: white;
    }
    .texte {
        color: black;
    }
    .table {
        color: black;
    }
    .qte{
        height: 50px;
        width: 100px;
    }
    .checkbox-container {
        display: flex;
        flex-wrap: wrap;
    }
    .checkbox-item {
        flex: 0 0 19%; /* R�partir en quatre colonnes */
        margin: 1%; /* Espacement entre les checkboxes */
        box-sizing: border-box; /* Inclure les marges dans la taille totale */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        display: flex;
        align-items: center;
        color: black;
    }
    .checkbox-item input[type="checkbox"] {
        margin-right: 10px; /* Espacement entre le checkbox et le texte */
    }
    .checkbox-item label {
        margin: 0; /* R�initialiser les marges du label */
    }
    .checkbox-item:hover {
        background-color: #e6f7ff;
        border-color: #007bff;
    }
    .requete{
        height:  100px;
    }

</style>
<style>
    .custom-tooltip .tooltip-inner {
        background-color: #f8d7da; /* Couleur de fond */
        color: #721c24; /* Couleur du texte */
        font-size: 16px; /* Taille du texte */
        padding: 10px; /* Espacement */
    }
    .custom-tooltip .arrow::before {
        border-top-color: #f8d7da; /* Couleur de la fl�che */
    }
</style>

@include('CRM.header')
@include('CRM.sidebar')

<!--**********************************
        Content body start
***********************************-->

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')

        <div class="col-md-11">
            <div class="card col-12 carte" style="margin-left: 50px;">
                <div class="card-header d-flex justify-content-between align-items-center entete">
                    <h3 class="entete">Data Lavage/Blanchiment/Teinture:  DEMANDE CLIENT</h3>
                </div>
                <div class="card-body">
                    @include('Planning.cin_demande_data')

                    <div class="card-body">
                        <div class="form-validation">
                            <form class="form-valide" action="{{ route('LRP.createDataLbt') }}" method="post" autocomplete="off">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-2">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Lavage</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="checkbox" name="lavage" id="lavage" value="lavage"
                                                {{ in_array('lavage', $valeursajoutees) ? 'checked' : '' }}>
                                                {{-- value="lavage" --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Blanchiment</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="checkbox" name="blanchiment" id="blanchiment" value="blanchiment"
                                                {{ in_array('blanchiment', $valeursajoutees) ? 'checked' : '' }}>
                                                {{-- value="blanchiment" --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Teinture</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="checkbox" name="teinture" id="teinture" value="teinture"
                                                {{ in_array('teinture', $valeursajoutees) ? 'checked' : '' }}>
                                                {{-- value="teinture" --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="poids" class="texte"><b>Poids <span><small style="color:#6c757d">modifiable <em>(kg)</em></small></span></b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="poids" id="poids" class="form-control" value="{{$poids[0]->poids ?? 0}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="heure" class="texte"><b>Heure</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="heure" id="heure" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="poids_total" class="texte"><b>Poids Total</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="poids_total" id="poids_total" class="form-control" value="{{$poids[0]->poids_total ?? 0}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="besoin_loading" class="texte"><b>Besoin en Loading</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="besoin_loading" id="besoin_loading" class="form-control" value="{{number_format($capacite_j, 2, '.', ' ')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="capacite_lbt" class="texte"><b>Capacite <span><small style="color:#6c757d">modifiable <em>(kg)</em></small></span></b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="capacite_lbt" id="capacite_lbt" class="form-control" value="93">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="col-12">
                                            <label class="col-form-label texte" ><b>Liste Machine</b></label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="idlistemachine">
                                                <option value="">Sélectionner une machine</option>
                                                @foreach($listemachine as $p)
                                                    <option value="{{ $p->id }}" {{ (isset($details[0]) && $details[0]->idlistemachine == $p->id) ? 'selected' : '' }}>
                                                        code : {{ $p->codemachine }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="nb_j_prod" class="texte"><b>NB J Prod</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="nb_j_prod" id="nb_j_prod" class="form-control" value="{{$nb_j_prod}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Mois</b></label>
                                            </div>
                                                                                        <div class="col-12">
                                                <input type="text" id="" class="form-control" value="{{$deets[0]->mois_date_max ?? ''}}" disabled>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row">

                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Inline Proposée</b> <span style="color:red">*</span></b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="date" name="inlinep" id="inlinep" class="form-control" value={{$inlinep}} >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Inline Réelle</b> <span style="color:red">*</span></b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="date" name="inliner" id="inliner" class="form-control" value={{$details[0]->inline ?? ''}}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Outline</b> <span style="color:red">*</span></b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="date" name="outline" id="outline" class="form-control" value="{{$outline ?? 0}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Heure Grmt</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="heuregrmt" id="heuregrmt" class="form-control" value="{{$heuregrmt[0]->heuregrmt ?? 0}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Heure Supplémentaire</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="heuresupp" id="heuresupp" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Efficience</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input class="form-text text-muted" name="efficience" id="efficience" value="{{$deets[0]->efficience ?? 0}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte"><b>Férie</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="checkbox" name="ferie" id="ferie" value="100"
                                                {{ in_array('100', $selectedValues) ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte"><b>Samedi</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="checkbox" name="samedi" id="samedi" value="400"
                                                            {{ in_array('400', $selectedValues) ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte"><b>Dimanche</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="checkbox" name="dimanche" id="dimanche" value="100"
                                                {{ in_array('200', $selectedValues) ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte"><b>Shift Nuit</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="checkbox" name="shift" id="shift" value="100"
                                                {{ in_array('300', $selectedValues) ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="row no-gutters">
                                        <div class="col-lg-12">
                                            <label class="col-form-label texte" ><b>Commentaire</b></label>
                                        </div>
                                        <div class="col-12">
                                            <textarea name="commentaire" id="commentaire" class="form-control">{{$details[0]->commentaire ?? 0 }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="row no-gutters">
                                        <div class="col-lg-12">
                                            <input type="hidden" name="demande_client_id" id="demande_client_id" value="{{$deets[0]->demande_client_id ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col-lg-12">
                                            <input type="hidden" name="numerocommande" id="numerocommande" value="{{$deets[0]->numerocommande ?? ''}}">
                                        </div>
                                    </div>
                                </div>

                                @if (!isset($details[0]->id))
                                <input type="hidden" name="id" value="{{ $details[0]->id ?? '' }}">
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success">Ajouter</button>
                                    </div>
                                </div>
                            @endif

                            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        </form>
                        @if (isset($details[0]->id))
                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#confirmUpdateModal">Modifier</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

<!--**********************************
        modal start
***********************************-->
<div class="modal fade custom-modal" id="confirmUpdateModal" tabindex="-1" aria-labelledby="confirmUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmUpdateModalLabel">Modifier ce Data Prod</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('LRP.updateDataLbt') }}" method="POST" id="updateForm">
                    @csrf
                    <input type="hidden" name="id" value="{{ $details[0]->id ?? '' }}">
                    <div class="form-group row">
                        <div class="col-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Lavage</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="lavage" id="lavage" value="lavage"
                                                {{ in_array('lavage', $valeursajoutees) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Blanchiment</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="blanchiment" id="blanchiment" value="blanchiment"
                                                {{ in_array('blanchiment', $valeursajoutees) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Teinture</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="teinture" id="teinture" value="teinture"
                                                {{ in_array('teinture', $valeursajoutees) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label for="poids" class="texte"><b>Poids <span><small style="color:#6c757d">modifiable <em>(kg)</em></small></span></b></label>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="poids" id="poids" class="form-control" value="{{$poids[0]->poids ?? 0}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label for="heure" class="texte"><b>Heure</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="heure" id="heure" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label for="poids_total" class="texte"><b>Poids Total</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="poids_total" id="poids_total" class="form-control" value="{{$poids[0]->poids_total ?? 0}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label for="besoin_loading" class="texte"><b>Besoin en Loading</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="besoin_loading" id="besoin_loading" class="form-control" value="{{number_format($capacite_j, 2, '.', ' ')}}>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label for="capacite_lbt" class="texte"><b>Capacite <span><small style="color:#6c757d">modifiable <em>(kg)</em></small></span></b></label>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="capacite_lbt" id="capacite_lbt" class="form-control" value="93">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="col-12">
                                <label class="col-form-label texte" ><b>Liste Machine</b></label>
                            </div>
                            <div class="col-12">
                                <select class="form-control" name="idlistemachine">
                                    <option value="">Sélectionner une machine</option>
                                    @foreach($listemachine as $p)
                                        <option value="{{ $p->id }}" {{ (isset($details[0]) && $details[0]->idlistemachine == $p->id) ? 'selected' : '' }}>
                                            code : {{ $p->codemachine }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label for="nb_j_prod" class="texte"><b>NB J Prod</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="nb_j_prod" id="nb_j_prod" class="form-control" value="{{$nb_j_prod}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Mois</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="" class="form-control" value="{{$deets[0]->mois_date_max ?? 'Pas encore disponible'}}" disabled>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group row">

                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Inline Proposée</b> <span style="color:red">*</span></b></label>
                                </div>
                                <div class="col-12">
                                    <input type="date" name="inlinep" id="inlinep" class="form-control" value={{$inlinep}} >
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Inline Réelle</b> <span style="color:red">*</span></b></label>
                                </div>
                                <div class="col-12">
                                    <input type="date" name="inliner" id="inliner" class="form-control" value={{$details[0]->inline ?? ''}}>                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Outline</b> <span style="color:red">*</span></b></label>
                                </div>
                                <div class="col-12">
                                    <input type="date" name="outline" id="outline" class="form-control" value="{{$outline ?? 0}}">
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="form-group row">
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Heure Grmt</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="heuregrmt" id="heuregrmt" class="form-control" value="{{$heuregrmt[0]->heuregrmt ?? 0}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Heure Supplémentaire</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="heuresupp" id="heuresupp" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Efficience</b></label>
                                </div>
                                <div class="col-12">
                                    <input class="form-text text-muted" name="efficience" id="efficience" value="{{$deets[0]->efficience ?? 0}}">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte"><b>Férie</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="ferie" id="ferie" value="100"
                                                {{ in_array('100', $selectedValues) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte"><b>Samedi</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="samedi" id="samedi" value="400"
                                                {{ in_array('400', $selectedValues) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte"><b>Dimanche</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="dimanche" id="dimanche" value="100"
                                                {{ in_array('200', $selectedValues) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte"><b>Shift Nuit</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="shift" id="shift" value="100"
                                                {{ in_array('300', $selectedValues) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="row no-gutters">
                            <div class="col-lg-12">
                                <label class="col-form-label texte" ><b>Commentaire</b></label>
                            </div>
                            <div class="col-12">
                                <textarea name="commentaire" id="commentaire" class="form-control">{{$details[0]->commentaire ?? 0 }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="row no-gutters">
                            <div class="col-lg-12">
                                <input type="hidden" name="demande_client_id" id="demande_client_id" value="{{$deets[0]->demande_client_id ?? ''}}">
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-12">
                                <input type="hidden" name="numerocommande" id="numerocommande" value="{{$deets[0]->numerocommande ?? ''}}">
                            </div>
                        </div>
                    </div>

            </div>
            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary" id="confirmDeleteButton" onclick="submitForm()">Modifier</button>
            </div>
        </form>
        </div>
    </div>
</div>

@include('Planning.boutons')
<!--**********************************
        modal end
***********************************-->
{{-- @include('CRM.parametre') --}}


<!--**********************************
        javascript start
***********************************-->





<script>
    document.getElementById('settings-icon').addEventListener('mouseover', function() {
    document.getElementById('settings-menu').style.display = 'block';
    });

    document.getElementById('settings-menu').addEventListener('mouseleave', function() {
        document.getElementById('settings-menu').style.display = 'none';
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>

    function submitForm() {
    document.querySelector('#confirmUpdateModal form').submit();
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    // Quand le poids change, on lance l'ajax pour récupérer la quantité
    $('#poids').on('input', function() {
        var poids = parseFloat($(this).val()); // Récupère la valeur du champ poids
        var demande_client_id = $('#demande_client_id').val(); // ID du client

        // Vérifier que le poids est un nombre
        if (!isNaN(poids) && demande_client_id) {
            // Requête AJAX pour récupérer la quantité (qte)
            $.ajax({
                url: '/get-qte/' + demande_client_id, // URL de la requête
                type: 'GET',
                success: function(response) {
                    // Si la requête est un succès, on récupère la quantité
                    var qte = parseFloat(response.qte);

                    // Calcul du poids total
                    if (!isNaN(qte)) {
                        var poids_total = poids * qte;
                        // On met à jour le champ du poids total
                        $('#poids_total').val(poids_total.toFixed(2)); // 2 chiffres après la virgule
                    } else {
                        // S'il n'y a pas de quantité, on efface le champ
                        $('#poids_total').val('');
                    }
                },
                error: function() {
                    console.log('Erreur lors de la récupération de la quantité.');
                }
            });
        } else {
            // Si le poids n'est pas un nombre, on efface le champ
            $('#poids_total').val('');
        }
    });
});
</script>

<!--**********************************
        javascript start
***********************************-->

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')

