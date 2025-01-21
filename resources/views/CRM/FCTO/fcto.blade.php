@include('CRM.header')
@include('CRM.sidebar')
<title>FCTO</title>

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

    .donnee{

    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div class="row">
            <button type="submit" onclick="exportToPDF()" class="btn btn-success mr-3">Ajout matelas</button>
            <div class="card col-12 mt-2">

                <div class="card-header ">
                    <p>
                    <h4 class="entete">FICHE DE COUPE</h4>
                    </p>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="row">
                                <div class="col-5">
                                    <table border="1" style="color: black">
                                        <tr>
                                            <td
                                                style="   width: 60px;  border: none;  border-top: none; border-left: none;">
                                            </td>
                                            <td style=" min-width: 90px; ">CLIENT:</td>
                                            <td style=" min-width: 105px; ">{{ $demande[0]->nomtier }}</td>
                                        </tr>
                                        <tr>
                                            <td
                                                style="border: none;  border: none;  border-top: none; border-left: none; ">
                                            </td>
                                            <td>MODELE:</td>
                                            <td>{{ $demande[0]->nom_modele }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-1">
                                </div>

                                <div class="col-1">
                                </div>
                                <div class="col-5">
                                    <table border="1" style="color: black">
                                        <tr>
                                            <td>{{ $tissu[0]->type_tissus }}:</td>
                                            <td>
                                                {{ $tissu[0]->reference }}/{{ $tissu[0]->designation }}/{{ $tissu[0]->couleur }}</br>
                                                {{ $tissu[0]->grammage }}g/{{ $tissu[0]->composition_tissus }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Lavage:</td>
                                            <td>PAS DE LAVAGE</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <table border="1" style="color: black" class="donnee">
                                <thead>
                                    <tr>
                                        <th style="  width: 60px;border: none; border-top: none; border-left: none;">
                                        </th>
                                        <th rowspan="2">DESTINATION</th>
                                        <th colspan="{{ count($tailleDemande) }}">REPARTITION PAR TAILLE</th>
                                        <th>0</th>
                                        <th></th>
                                        <th style="border: none; border-top: none; border-left: none;"></th>
                                        <th style="border: none; border-top: none; border-left: none;"></th>
                                        <th style="border: none; border-top: none; border-left: none;"></th>
                                        <th style="border: none; border-top: none; border-left: none;"></th>

                                    </tr>
                                    <tr>
                                        <td style="min-width: 40px; border: none; border-top: none; border-left: none;">
                                        </td>
                                        @for ($de = 0; $de < count($tailleDemande); $de++)
                                            <th style=" width: 10px;">{{ $tailleDemande[$de]->unite_taille }}</th>
                                        @endfor
                                        <th style=" width: 10px;">TOTAL</th>
                                        <th style=" width: 10px;">%</th>
                                        <th style="  width: 10px; border: none; border-top: none; border-left: none;">
                                        </th>
                                        <th style="  width: 10px; border: none; border-top: none; border-left: none;">
                                        </th>
                                        <th style="  width: 10px; border: none; border-top: none; border-left: none;">
                                        </th>
                                        <th style="  width: 10px; border: none; border-top: none; border-left: none;">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="  width: 60px;border: none; border-top: none; border-left: none;">
                                        </td>
                                        <td></td>
                                        @for ($de1 = 0; $de1 < count($tailleDemande); $de1++)
                                            <td>{{ $tailleDemande[$de1]->quantite }}</td>
                                        @endfor
                                        <td>{{ $demande[0]->qte_commande_provisoire }}</td>
                                        <td></td>
                                        <td style="  width: 60px;border: none; border-top: none; border-left: none;">
                                        </td>
                                        <td style="  width: 60px;border: none; border-top: none; border-left: none;">
                                        </td>
                                        <td style="  width: 60px;border: none; border-top: none; border-left: none;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="  width: 60px;border: none; border-top: none; border-left: none;">
                                        </td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;"></td>
                                        <td>0</td>
                                        <td style="  width: 50px;border: none; border-top: none; border-left: none;">
                                        </td>
                                        <td style="  width: 50px;border: none; border-top: none; border-left: none;">
                                        </td>
                                        <td style="  width: 50px;border: none; border-top: none; border-left: none;">
                                        </td>
                                        <td style="  width: 50px;border: none; border-top: none; border-left: none;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="  width: 60px;border: none; border-top: none; border-left: none;">
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>0</td>
                                        <td style="border: none; border-top: none; border-left: none;"></td>
                                        <td style="border: none; border-top: none; border-left: none;"></td>
                                        <td style="border: none; border-top: none; border-left: none;"></td>
                                        <td style="border: none; border-top: none; border-left: none;"></td>
                                    </tr>
                                    <tr>
                                        <td style="  width: 60px;border: none; border-top: none; border-left: none;">
                                        </td>
                                        <td>TOTAL BC</td>
                                        @for ($de2 = 0; $de2 < count($tailleDemande); $de2++)
                                            <td>{{ $tailleDemande[$de2]->quantite }}</td>
                                        @endfor
                                        <td>{{ $demande[0]->qte_commande_provisoire }}</td>
                                        <td>100%</td>
                                        <td style="border: none; border-top: none; border-left: none;"></td>
                                        <td style="border: none; border-top: none; border-left: none;"></td>
                                        <td style="border: none; border-top: none; border-left: none;"></td>
                                        <td style="border: none; border-top: none; border-left: none;"></td>
                                    </tr>
                                    <tr>
                                        <td style="  width: 60px;border: none; border-top: none; border-left: none;">
                                        </td>
                                        <td>Merch/Acc</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>4093.2</td>
                                        <td>102.33%</td>
                                        <td style="border: none; border-top: none; border-left: none;"></td>
                                        <td style="border: none; border-top: none; border-left: none;"></td>
                                        <td style="border: none; border-top: none; border-left: none;"></td>
                                        <td style="border: none; border-top: none; border-left: none;"></td>
                                    </tr>
                                    <tr>
                                        <th style=" width: 50px; font-size: 10px;">N Matelas <br>recoupe</th>
                                        <th>Plis coupe</th>
                                        <th colspan="{{ count($tailleDemande) }}">RATIOS</th>
                                        <th style="font-size: 10px;">Longueur matelas</th>
                                        <th style="font-size: 10px;">Total mètre</th>
                                        <th style="font-size: 10px;">Nb de pièces</th>
                                        <th style="font-size: 10px;">LONGUEUR REELLE TRACE</th>
                                        <th style="font-size: 10px;">METRAGE TOTAL</th>
                                    </tr>
                                    <tr>
                                        <th>1</th>

                                        <th>198</th>
                                        @for ($de3 = 0; $de3 < count($tailleDemande); $de3++)
                                            <td>{{ $tailleDemande[$de3]->quantite }}</td>
                                        @endfor
                                        <th>12.90</th>
                                        <th>2554.20</th>
                                        <th></th>
                                        <th></th>
                                        <th>0</th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="font-size: 10px;">PCES COUPEES</td>
                                        <td>0</td>
                                        <td>396</td>
                                        <td>396</td>
                                        <td>396</td>
                                        <td>396</td>
                                        <td>396</td>
                                        <td></td>
                                        <td></td>
                                        <td>1980</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="font-size: 10px;">RAC</td>
                                        <td>449</td>
                                        <td>94</td>
                                        <td>396</td>
                                        <td>396</td>
                                        <td>396</td>
                                        <td>396</td>
                                        <td></td>
                                        <td></td>
                                        <td>2113</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>


                        </div>

                        {{--  droite  --}}
                        <div class="col-3">
                            {{--  droite 1  --}}
                            <div class="col-12">
                                <table border="1" style="color: black">
                                    <thead>
                                        <tr>
                                            <th>Remplissage automatique</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Image</td>
                                            <td>
                                                <table border="1" width="100%">
                                                    <tr>
                                                        <td>A remplir par les merch</td>
                                                    </tr>
                                                    <tr>
                                                        <td>A remplir par mag</td>
                                                    </tr>
                                                    <tr>
                                                        <td>A remplir par Bodo</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{--  droite 2  --}}
                            <div class="col-12" style="margin-top: 150px;">
                                <table border="1" style="color: black">
                                    <tr>
                                        <td>Tissu principal</td>
                                        <td>WOVEN 100% COT VOILE</td>
                                    </tr>
                                    <tr>
                                        <td>Besoin OF</td>
                                        <td>1546</td>
                                    </tr>
                                    <tr>
                                        <td>Laize commandée</td>
                                        <td>1456</td>
                                    </tr>
                                    <tr>
                                        <td>Qté Commandée/m</td>
                                        <td>56799</td>
                                    </tr>
                                    <tr>
                                        <td>Qté reçue/m</td>
                                        <td>56799</td>
                                    </tr>
                                    <tr>
                                        <td>Laize moy reçue/m</td>
                                        <td>56799</td>
                                    </tr>
                                    <tr>
                                        <td>% reçu / BC</td>
                                        <td>56799</td>
                                    </tr>
                                    <tr>
                                        <td>% reçu /besoin OF</td>
                                        <td>56799</td>
                                    </tr>
                                    <tr>
                                        <td>Qté utilisée</td>
                                        <td>56799</td>
                                    </tr>
                                    <tr>
                                        <td>Qté théo restante</td>
                                        <td>56799</td>
                                    </tr>
                                    <tr>
                                        <td>Qté réelle en stock</td>
                                        <td>56799</td>
                                    </tr>
                                    <tr>
                                        <td>Ecart théo/réelle</td>
                                        <td>56799</td>
                                    </tr>
                                    <tr>
                                        <td>Qualité: Pass/Fail</td>
                                        <td>PASS</td>
                                    </tr>

                                </table>
                            </div>

                            {{--  droite 3  --}}
                            <div class="col-12" style="margin-top: 20px;">
                                <table border="1" style="color: black">
                                    <tr>
                                        <td colspan="2" style="width: 190px;">VISELINE</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 190px;">Cotation</td>
                                        <td style="width: 190px;">Réelle</td>
                                    </tr>
                                    <tr>
                                        <td>0</td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>

                            {{--  droite 4  --}}
                            <div class="col-12" style="margin-top: 20px;">
                                <table border="1" style="color: black">
                                    <tr>
                                        <td colspan="2" style="width: 190px;">Efficience Placement</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 190px;">Commande</td>
                                        <td style="width: 190px;">Production</td>
                                    </tr>
                                    <tr>
                                        <td>0</td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>

                            {{--  droite 5  --}}
                            <div class="col-12" style="margin-top: 20px;">
                                <table border="1" style="color: black">
                                    <tr>
                                        <td colspan="2" style="width: 190px;">Conso Appurée</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 190px;">0</td>
                                        <td style="width: 190px;"></td>
                                    </tr>
                                </table>
                            </div>

                            {{--  droite 6  --}}
                            <div class="col-12" style="margin-top: 20px;">
                                <table border="1" style="color: black">
                                    <tr>
                                        <td colspan="2" style="width: 190px; height: 200px">A faire valider par Mr
                                            Meraj et à justifier si les</br>
                                            consommations sont supérieures à la cotation:
                                        </td>
                                    </tr>
                                </table>
                            </div>
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

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
