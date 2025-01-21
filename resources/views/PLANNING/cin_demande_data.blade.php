<div class="card mb-2">
    <div class="row g-0">
        <div class="col-md-2 mt-2">
            <center>
                <img src=" asset('storage/photos_commandes/' . photo_commande)" class="img-fluid rounded-start mb-5" alt="Logo" width="200px" height="200px">
            </center>
        </div>
        <div class="col-md-5">
            <div class="card-body">
                <p class="texte"><b>SMV Prod :</b>  {{$deets1[0]->smv_prod}}</p>
                <p class="texte"><b>SMV Finition :</b>  {{$deets1[0]->smv_finition}}</p>
                <p class="texte"><b>Date entrée :</b>{{$deets1[0]->podate}}</p>
                <p class="texte"><b>ETD (Estimated Time Departure) :</b> {{$deets1[0]->etdrevise}}  </p>
                <p class="texte"><b>Nom du client :</b> {{$deets1[0]->nom_client}} </p>
                <p class="texte"><b>Saison :</b> {{$deets1[0]->type_saison}}   </p>
                <p class="texte"><b>Incontern :</b> {{$deets1[0]->type_incontern}}</p>
                <p class="texte"><b>Phase :</b> {{$deets1[0]->type_phase}}</p>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card-body">
                <p class="texte"><b>Stade :</b> {{$deets1[0]->type_stade}}  </p>
                <p class="texte"><b>Nom du modèle :</b> {{$deets1[0]->nom_modele}}  </p>
                <p class="texte"><b>Thème :</b> {{$deets1[0]->theme}}  </p>
                <p class="texte"><b>Style :</b> {{$deets1[0]->nom_style}} </p>
                <p class="texte"><b>Quantité prévisionnelle :</b> {{$deets1[0]->qte}}  pièces</p>
                <p class="texte"><b>Grille de taille :</b> {{$deets1[0]->taillemin}}--{{$deets1[0]->taillemax}}</p>
                <p class="texte"><b>Taille de base :</b> {{$deets1[0]->taille_base}}  </p>
            </div>
        </div>
    </div>
    <br>
</div>


