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
                    <h3 class="entete">Data Print :  DEMANDE CLIENT</h3>
                </div>
                <div class="card-body">
                    @include('Planning.cin_demande_data')


                    <div class="card-body">
                        <div class="form-validation">
                            <form class="form-valide" action="{{ route('LRP.createDataPrint') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <input type="hidden" name="qteprev"  class="form-control" value="{{$deets[0]->qte}}">
                                <div class="form-group row">
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="mon_prod" class="texte"><b>Minutes Produit</b></label>
                                            </div>
                                            <div class="col-12">
                                                {{-- requis --}}
                                                <input type="text" name="min_prod" id="min_prod" class="form-control" value="{{$minute_prod[0]->min_prod}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="smv" class="texte"><b>SMV</b></label>
                                            </div>
                                            <div class="col-12">
                                                {{-- requis --}}
                                                <input type="text" name="smv" id="smv" class="form-control" value="{{$deets[0]->prix_print}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="capacite_j" class="texte"><b>Capacite</b></label>
                                            </div>
                                            <div class="col-12">
                                                {{-- requis --}}
                                                <input type="text" name="capacite_j" id="capacite_j" class="form-control" value="{{$capacite_print[0]->capacite_print}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="besoin_loading" class="texte"><b>Besoin Loading</b></label>
                                            </div>
                                            <div class="col-12">
                                                {{-- requis --}}
                                                <input type="text" name="capacite_j" id="capacite_j" class="form-control" value="{{ $capacite_j }}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label for="temps_print" class="texte"><b>Temps Print</b></label>
                                            </div>
                                            <div class="col-12">
                                                {{-- requis --}}
                                                <input type="text" name="temps_print" id="temps_print" class="form-control" value="{{$details[0]->tempsprint ?? 0 }}">
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
                                                <input type="text" name="nb_j_prod" id="nb_j_prod" class="form-control" value="{{ $nb_j_prod_print}}" >
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
                                                <input type="text" id="" class="form-control" value={{$deets[0]->mois_date_max  ?? 'Pas encore disponible'}} >
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Inline Proposée</b> <span style="color:red">*</span></b></label>
                                            </div>
                                            <div class="col-12">
                                                {{-- cette value peut-être insérée ou gardée comme ci-dessous --}}
                                                <input type="date" name="inlinep" id="inlinep" class="form-control" value={{$inlinep_print}}>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                {{-- non requis --}}
                                                <label class="col-form-label texte" ><b>Inline Réelle</b> <span style="color:red">*</span></b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="date" name="inliner" id="inliner" class="form-control" value={{$details[0]->inline  ?? ''}}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" >Outline </label>
                                            </div>
                                            <div class="col-12">
                                                 <input type="date" name="outline" id="outline" class="form-control" value={{$outline_print}}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Heure Supplémentaire</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="heuresup" id="heuresup" class="form-control" value={{$details[0]->heuresup  ?? 0}}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Efficience</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input name="effectif" class="form-control" value="{{$deets[0]->efficience}}"><p>%</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte" ><b>Effectif</b></label>
                                            </div>
                                            <div class="col-12">
                                                <input name="effectif" class="form-control" value="{{$deets[0]->effectif}}"><p>pers</p>
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
                                    <div class="row no-gutters">
                                        <div class="col-lg-12">
                                            <label class="col-form-label texte" ><b>Commentaire</b></label>
                                        </div>
                                        <div class="col-12">
                                            <textarea name="commentaire" id="commentaire" class="form-control">{{$details[0]->commentaire ?? 'none' }}</textarea>
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
                <h5 class="modal-title" id="confirmUpdateModalLabel">Modifier ce Data Print</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('LRP.updateDataPrint') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $details[0]->id ?? 'none' }}">
                    <div class="form-group row">
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label for="mon_prod" class="texte"><b>Min Prod</b></label>
                                </div>
                                <div class="col-12">
                                    {{-- requis --}}
                                    <input type="text" name="min_prod" id="min_prod" class="form-control" value="{{$minute_prod[0]->min_prod}}" >
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label for="smv" class="texte"><b>SMV</b></label>
                                </div>
                                <div class="col-12">
                                    {{-- requis --}}
                                    <input type="text" name="smv" id="smv" class="form-control" value="{{$deets[0]->smv_prod}}" >
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
                                    <input type="text" name="capacite_j" id="capacite_j" class="form-control" value="{{$capacite_print[0]->capacite_print}}" >
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label for="besoin_loading" class="texte"><b>Bes L..</b></label>
                                </div>
                                <div class="col-12">
                                    {{-- requis --}}
                                    <input type="text" name="capacite_j" id="capacite_j" class="form-control" value="{{number_format($capacite_j, 2, '.', ' ')}}" >

                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label for="temps_print" class="texte"><b>Temps Print</b></label>
                                </div>
                                <div class="col-12">
                                    {{-- requis --}}
                                    <input type="text" name="temps_print" id="temps_print" class="form-control" value="{{$details[0]->tempsprint ?? 0}}">
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
                                    <input type="text" name="nb_j_prod" id="nb_j_prod" class="form-control" value="{{number_format($nb_j_prod_print, 2, '.', ' ')}}" >
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

                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Inline Proposée</b> <span style="color:red">*</span></b></label>
                                </div>
                                <div class="col-12">
                                    {{-- cette value peut-être insérée ou gardée comme ci-dessous --}}
                                    <input type="date" name="inlinep" id="inlinep" class="form-control" value={{$inlinep_print}}>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    {{-- non requis --}}
                                    <label class="col-form-label texte" ><b>Inline Réelle</b> <span style="color:red">*</span></b></label>
                                </div>
                                <div class="col-12">
                                    <input type="date" name="inliner" id="inliner" class="form-control" value={{$details[0]->inline  ?? ''}}>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" >Outline </label>
                                </div>
                                <div class="col-12">
                                     <input type="date" name="outline" id="outline" class="form-control" value={{$outline_print}}>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Heure Sup</b></label>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="heuresup" id="heuresup" class="form-control" value={{$details[0]->heuresup  ?? 0}}>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Efficience</b></label>
                                </div>
                                <div class="col-12">
                                    <input name="efficience" class="form-control" value={{$deets[0]->efficience}}>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte" ><b>Effectif</b></label>
                                </div>
                                <div class="col-12">
                                    <input name="effectif" class="form-control" value={{$deets[0]->effectif}}>
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
                        <div class="row no-gutters">
                            <div class="col-lg-12">
                                <label class="col-form-label texte" ><b>Commentaire</b></label>
                            </div>
                            <div class="col-12">
                                <textarea name="commentaire" id="commentaire" class="form-control">{{$details[0]->commentaire ?? 'none' }}</textarea>
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

<!--**********************************
        javascript start
***********************************-->

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')

