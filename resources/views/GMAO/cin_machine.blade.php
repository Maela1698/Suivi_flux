<div class="col-10 mx-auto">
    <div class="card mb-2">
        <div class="row g-0">
            <div class="col-md-2 mt-4">
                <center>
                    @if ($details_machine[0]->photo)
                        <img src="data:image/png;base64;{{ $details_machine[0]->photo }}"  style="width: 190px; height: 250px;"/>
                    @else
                        <span>No Image</span>
                    @endif
                </center>
            </div>
            <div class="col-md-5">
                <div class="card-body">
                    <h3 style="color:#2638a2"><b>Marque:</b>{{$details_machine[0]->marque}} </h3>
                    <p class="texte"><b>Type </b>
                        @if($details_machine[0]->proprietee == 100)
                        <span class="badge badge-primary">Propriétée</span>
                        @else
                        <span class="badge badge-warning">Emprunt</span>
                        @endif
                    </p>
                    <p class="texte"><b>Code : </b>{{$details_machine[0]->codemachine}}  </p>
                    <p class="texte"><b>Catégorie : </b>{{$details_machine[0]->categorie}}</p>
                    <p class="texte"><b>Prix Unitaire : </b>{{$details_machine[0]->prixu}}</p>
                    <p class="texte"><b>Référence : </b> {{$details_machine[0]->reference}} </p>
                     @if($details_machine[0]->proprietee == 200)
                    <p class="texte"><b>Prix Prestation</b> {{$details_machine[0]->cout_prestation}} €</p>
                    @endif
                    {{-- <p class="texte"><b>Phase : </b></p> --}}
                    <p class="texte"><b>Capacite : </b> {{$details_machine[0]->capacite}}  </p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card-body">
                    <p class="texte"><b>Date Entrée:</b> {{$details_machine[0]->dateentreemachine}}  </p>
                    @if($details_machine[0]->proprietee == 200)
                    <p class="texte"><b>Date Sortie:</b>  {{$details_machine[0]->datefincontrat}} </p>
                    @endif
                </div>
            </div>
        </div>
        <br>
    </div>
</div>
