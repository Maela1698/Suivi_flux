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
        @include('PLANNING.headerPlan')

        <div class="col-md-11">
            <div class="card col-12 carte" style="margin-left: 50px;">
                <div class="card-header d-flex justify-content-between align-items-center entete">
                    <h3 class="entete">Data Prod :  DEMANDE CLIENT</h3>
                </div>
                <div class="card-body">
                    @include('Planning.cin_demande_data')
                    <div class="card-body">
                        <div class="form-validation">
                            <form class="form-valide" action="{{ route('LRP.createDataProd') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf

                                <div class="form-group row">
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="mon_prod" class="texte"><b>Minutes Produit</b></label>
                                            </div>
                                            <div class="col-12">
                                                {{-- requis --}}
                                                <input type="text" name="min_prod" id="min_prod" class="form-control" value="{{$minute_prod[0]->min_prod}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="capacite_j" class="texte"><b>Capacite</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="capacite_j" id="capacite_j" class="form-control" value="{{number_format($capacite_j, 2, '.','')}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="qte_coupe" class="texte"><b>% Qte Coupe</b></label>
                                            </div>
                                            <div class="col-12">
                                                {{-- requis --}}
                                                <input type="text" name="qte_coupe" id="qte_coupe" class="form-control" value="{{$details[0]->qte_coupe ?? 0}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="nb_j_prod" class="texte"><b>NB JOURS PROD</b></label>
                                            </div>
                                            <div class="col-12">
                                                {{-- requis --}}

                                                <input type="text" name="nb_j_prod" id="nb_j_prod" class="form-control" value="{{ number_format(ceil($nb_j_prod), 0, '.', ' ') }}">
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
                                                {{-- requis --}}
                                                <input type="text" id="" class="form-control" value="{{$deets[0]->mois_date_max ?? 'Pas encore disponible'}}" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte"><b>Affectation Chaîne</b></label>
                                            </div>
                                            <div class="col-12">
                                                <select class="form-control" name="chaine" id="chaine">
                                                    <option value="">Sélectionner une chaîne</option>
                                                    @foreach($chaine as $p)
                                                        <option value="{{ $p->id_chaine }}" {{ (isset($details[0]) && $details[0]->id_chaine == $p->id_chaine) ? 'selected' : '' }}>{{ $p->designation }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3" id="prochaine_dispo_block" style="display:none;">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte"><b>Next Chaine dispo</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="date" name="prochaine_dispo" id="prochaine_dispo" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Inline Proposée </b></label>
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


                                    {{--  --}}


                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte"><b>Outline </b></label>
                                            </div>
                                            <div class="col-12">
                                                 <input type="date" name="outline" id="outline" class="form-control" value={{$outline}}>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Heure Supplémentaire</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="heuresup" id="heuresup" class="form-control" value={{$details[0]->heuresup ?? 0}}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Efficience</b></label>
                                            </div>
                                            <div class="col-12">
                                                {{-- RETRO PLANNING --}}
                                                <input type="hidden" name="efficience" value="{{$deets[0]->efficience}}">
                                                <input type="hidden" name="qteprev" value="{{$deets1[0]->qte}}">
                                                <input type="hidden" name="smv_prod" value="{{$deets1[0]->smv_prod}}">
                                                <p class="form-text text-muted">{{$deets[0]->efficience}} %</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Effectif</b></label>
                                            </div>
                                            <div class="col-12">
                                                {{-- RETRO PLANNING --}}
                                                <input type="hidden" name="effectif" value="{{$deets[0]->effectif}}">
                                                <p class="form-text text-muted">{{$deets[0]->effectif}} prs</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-2">
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
                                    <div class="col-2">
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
                                    <div class="col-2">
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
                                    <div class="col-2">
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
                                            <input type="hidden" name="demande_client_id" id="demande_client_id" value="{{$deets[0]->demande_client_id}}">
                                        </div>
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col-lg-12">
                                            <input type="hidden" name="numerocommande" id="numerocommande" value="{{$deets[0]->numerocommande}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                        <input type="hidden" name="id_dataprod" id="id_dataprod" value="{{$details[0]->id ?? ''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="row no-gutters">
                                        <div class="col-lg-12">
                                            <label class="col-form-label texte" ><b>Commentaire</b></label>
                                        </div>
                                        <div class="col-12">
                                            <textarea name="commentaire" id="commentaire" class="form-control">{{$details[0]->commentaire ?? 0}}</textarea>
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
<!-- Modal -->
<div class="modal fade custom-modal" id="confirmUpdateModal" tabindex="-1" aria-labelledby="confirmUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmUpdateModalLabel">Modifier ce Data Prod</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('LRP.updateDataProd') }}" method="POST" id="updateForm">
                    @csrf
                    <input type="hidden" name="id" value="{{ $details[0]->id ?? '' }}">

                    <div class="form-group row">
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label for="min_prod" class="texte"><b>Min Pro</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="min_prod" id="min_prod" class="form-control" value="{{$minute_prod[0]->min_prod}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label for="capacite_j" class="texte"><b>Capacite</b></label>
                                </div>
                                <div class="col-12">
                                    {{-- requis --}}
                                    <input type="text" name="capacite_j" id="capacite_j" class="form-control" value="{{number_format($capacite_j, 2, '.','')}}" >
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label for="qte_coupe" class="texte"><b>% Qte Coupe</b></label>
                                </div>
                                <div class="col-12">
                                    {{-- requis --}}
                                    <input type="text" name="qte_coupe" id="qte_coupe" class="form-control" value="{{$details[0]->qte_coupe ?? 0}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label for="nb_j_prod" class="texte"><b>NBJ PROD</b></label>
                                </div>
                                <div class="col-12">
                                    {{-- requis --}}
                                    <input type="text" name="nb_j_prod" id="nb_j_prod" class="form-control" value="{{ number_format(ceil($nb_j_prod), 0, '.', ' ') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Mois</b></label>
                                </div>
                                <div class="col-12">
                                    {{-- requis --}}
                                    <input type="text" id="" class="form-control" value="{{$deets[0]->mois_date_max ?? 'Pas encore disponible'}}" >
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Chaîne</b></label>
                                </div>
                                <div class="col-12">
                                    <select class="form-control" name="chaine" id="chaine2" >
                                        <option value="">Sélectionner une chaîne</option>
                                        @foreach($chaine as $p)
                                        <option  value="{{ $p->id_chaine }}" {{ (isset($details[0]) && $details[0]->id_chaine == $p->id_chaine) ? 'selected' : '' }}>
                                            {{ $p->designation }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-4" id="prochaine_dispo_block2" style="display:none;">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte"><b>Prochaine date Chaine dispo</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="date" name="prochaine_dispo2" id="prochaine_dispo2" class="form-control" readonly>
                                </div>
                            </div>
                        </div> --}}


                        <div class="col-4" id="prochaine_dispo_block2" style="display:none;">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte"><b>Next Chaine dispo</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="date" name="prochaine_dispo2" id="prochaine_dispo2" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Inline Proposée</b></label>
                                </div>
                                <div class="col-12">
                                    {{-- <input type="date" name="inlinep" id="inlinep" class="form-control" placeholder="inline proposée" value="{{$deets[0]->disponibilite_vrai}}"> --}}
                                    <input type="date" name="inlinep" id="inlinep" class="form-control" value={{$inlinep}}>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    {{-- non requis --}}
                                    <label class="col-form-label texte" ><b>Inline Réelle</b> <span style="color:red">*</span></label>
                                </div>
                                <div class="col-12">
                                    <input type="date" name="inliner" id="inliner" class="form-control" placeholder="inline réelle" value={{$details[0]->inline ?? ''}}>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Outline </b> <span style="color:red">*</span></label>
                                </div>
                                <div class="col-12">
                                    <input type="date" name="outline" id="outline" class="form-control" value={{$outline}}
                                    >
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="form-group row">
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Heure Supp</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="heuresup" id="heuresup" class="form-control" value={{$details[0]->heuresup ?? 0}}>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Efficience</b></label>
                                </div>
                                <div class="col-12">
                                    <p class="form-text text-muted">{{$deets[0]->efficience}} nb %</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Effectif</b></label>
                                </div>
                                <div class="col-12">
                                    <p class="form-text text-muted">{{$deets[0]->effectif}} prs</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-4">
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
                        <div class="col-4">
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
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte"><b>Dimanche</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="dimanche" id="dimanche" value="200"
                                                           {{ in_array('200', $selectedValues) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte"><b>Shift Nuit</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="shift" id="shift" value="300"
                                                           {{ in_array('300', $selectedValues) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                        <div class="row no-gutters">
                            <div class="col-lg-12">
                                <label class="col-form-label texte" ><b>Commentaire</b></label>
                            </div>
                            <div class="col-12">
                                <textarea name="commentaire" id="commentaire" class="form-control">{{$details[0]->commentaire ?? 0}}</textarea>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="row no-gutters">
                            <div class="col-lg-12">
                                <input type="hidden" name="demande_client_id" id="demande_client_id" value="{{$deets[0]->demande_client_id}}">
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-12">
                                <input type="hidden" name="numerocommande" id="numerocommande" value="{{$deets[0]->numerocommande}}">
                            </div>
                        </div>
                    </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary" id="confirmDeleteButton" onclick="submitForm()">Modifier</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!--**********************************
        modal end
***********************************-->
{{-- @include('CRM.parametre') --}}


<!--**********************************
        javascript start
***********************************-->

@include('Planning.boutons')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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



{{-- prochaine dispo 1 --}}
<script>
    // $(document).ready(function() {
    //     $('#chaine').change(function() {
    //         var id_chaine = $(this).val();

    //         if (id_chaine) {
    //             $('#prochaine_dispo_block').show();

    //             $.ajax({
    //                 url: '/getProchaineDispo',
    //                 type: 'GET',
    //                 data: {idchaine: id_chaine},
    //                 success: function(response) {
    //                     if (response) {
    //                         $('#prochaine_dispo').val(response);
    //                     } else {
    //                         $('#prochaine_dispo').val('');
    //                     }
    //                 },
    //                 error: function(xhr, status, error) {
    //                     console.error('Erreur AJAX : ' + error);
    //                 }
    //             });
    //         } else {
    //             $('#prochaine_dispo_block').hide();
    //             $('#prochaine_dispo').val('');
    //         }
    //     });
    // });
    $(document).ready(function() {
    $('#chaine').change(function() {
        var id_chaine = $(this).val();

        if (id_chaine) {
            $('#prochaine_dispo_block').show();

            $.ajax({
                url: '/getProchaineDispo',
                type: 'GET',
                data: { id_chaine: id_chaine },
                success: function(response) {
                    $('#prochaine_dispo').val(response.prochaine_dispo);
                },
                error: function() {
                    alert('Erreur lors de la récupération de la prochaine date disponible.');
                }
            });
        } else {
            $('#prochaine_dispo_block').hide();  // Cache le champ si aucune chaîne n'est sélectionnée
        }
    });
});
</script>
{{-- prochiane dispo 1 --}}



{{-- prochaine dispo 2 --}}
<script>
 $(document).ready(function() {
    $('#chaine2').change(function() {
        var id_chaine = $(this).val();

        if (id_chaine) {
            $('#prochaine_dispo_block2').show();

            $.ajax({
                url: '/getProchaineDispo',
                type: 'GET',
                data: { id_chaine: id_chaine },
                success: function(response) {
                    $('#prochaine_dispo2').val(response.prochaine_dispo);
                },
                error: function() {
                    alert('Erreur lors de la récupération de la prochaine date disponible.');
                }
            });
        } else {
            $('#prochaine_dispo_block2').hide();
        }
    });
});
</script>
{{-- prochiane dispo 2 --}}


<!--**********************************
        javascript start
***********************************-->

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')

