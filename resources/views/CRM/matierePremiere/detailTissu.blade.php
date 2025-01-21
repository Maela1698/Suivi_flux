@include('CRM.header')
@include('CRM.sidebar')
<title>DetailTissu</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .form-control {
        border: 1px solid #b5b5b5;
    }

    label {
        color: #767575;
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div class="row">

            <div class="col-md-12">
                <div class="card col-12 carte">
                    <div class="justify-content-center align-items-center entete">
                        <h3 class="entete mt-3">DETAILS TISSU </h3>
                        <center>
                            <h2>{{ $listeTissu[0]->type_tissus }}</h2>
                        </center>
                    </div>

                    <div class="card-body">
                        <div class="card mb-2">
                            <div class="row g-0">
                                <div class="col-md-2 mt-2">
                                    <center>
                                        <img src="data:image/png;base64,{{ $listeTissu[0]->photo }}"
                                            class="img-fluid rounded-start mb-5" alt="Logo" width="200px"
                                            height="200px">
                                    </center>
                                </div>
                                <div class="col-md-5">
                                    <div class="card-body">
                                        <p class="texte"><b>Categorie :</b> {{ $listeTissu[0]->categorie }} </p>
                                        <p class="texte"><b>Designation :</b> {{ $listeTissu[0]->designation }} </p>
                                        <p class="texte"><b>Reference :</b> {{ $listeTissu[0]->reference }} </p>
                                        <p class="texte"><b>Couleur :</b> {{ $listeTissu[0]->couleur }}</p>
                                        <p class="texte"><b>Composition :</b> {{ $listeTissu[0]->composition_tissus }}
                                        </p>
                                        <p class="texte"><b>Grammage :</b> {{ $listeTissu[0]->grammage }} g</p>
                                        <p class="texte"><b>Laize utile :</b> {{ $listeTissu[0]->laize_utile }} cm</p>
                                        <p class="texte"><b>Quantite :</b> {{ number_format( $listeTissu[0]->quantite, 3, '.', ' ') }}
                                            {{ $listeTissu[0]->unite_mesure }}</p>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="card-body">
                                        <p class="texte"><b>Classe :</b> {{ $listeTissu[0]->classe }}</p>
                                        <p class="texte"><b>Famille : </b>{{ $listeTissu[0]->famille_tissus }}
                                        </p>
                                        <p class="texte"><b>Prix unitaire :</b> {{ $listeTissu[0]->prix_unitaire }}
                                            {{ $listeTissu[0]->unite }}</p>
                                        <p class="texte"><b>Fret :</b> {{ $listeTissu[0]->frais }}
                                            {{ $listeTissu[0]->unite }}</p>
                                        <p class="texte"><b>Retrait lavage :</b>
                                            L:{{ $listeTissu[0]->l_retrait_lavage }}%
                                            W:{{ $listeTissu[0]->w_retrait_lavage }}%</p>
                                        <p class="texte"><b>Retrait teinture :</b>
                                            L:{{ $listeTissu[0]->l_retrait_teinture }}%
                                            W:{{ $listeTissu[0]->w_retrait_teinture }}%</p>
                                        <p class="texte"><b>Fiche technique :</b>
                                            @if (!empty($listeTissu[0]->fiche_technique))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $listeTissu[0]->fiche_technique }}', event)">
                                                    {{ $listeTissu[0]->nom_fiche_technique }}
                                                </a>
                                            @else
                                                <span>Aucune fiche technique disponible</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                            </div>


                        </div>

                    </div>



                    <div class="form-group row">
                        <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                            <form action="{{ route('CRM.listeMatierePremiere') }}" method="get">
                                @csrf
                                <input type="hidden" value="{{ $listeTissu[0]->id_demande_client }}"
                                    name="id_demande_client">
                                <button type="submit" class="btn btn-info mr-3">Voir liste</button>
                            </form>

                            <form action='{{ route('CRM.formModifTissu') }}' method='GET'>
                                <input type='hidden' name='idTissu' value="{{ $listeTissu[0]->id }}">
                                <button type="submit" class="btn btn-warning mr-3">Modifier</button>
                            </form>


                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#confirmDeleteModal" data-id="{{ $listeTissu[0]->id }}">
                                Supprimer
                            </button>


                        </div>
                    </div>

                </div>
            </div>


            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteLabel">Confirmation de suppression</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Voulez-vous vraiment supprimer ce tissu ?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('CRM.deleteTissu') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_tissus" id="idTissu">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
</div>
@include('CRM.parametre')

<!--**********************************
        modal start
***********************************-->





<!--**********************************
        javascript start
***********************************-->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#confirmDeleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Bouton qui déclenche le modal
            var idTissu = button.data('id'); // Extraire l'information de data-id

            var modal = $(this);
            modal.find('.modal-footer #idTissu').val(idTissu); // Passer l'ID au champ caché
            modal.find('.modal-body #tissuIdDisplay').text(idTissu); // Afficher l'ID dans le modal
        });
    });
</script>



<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
