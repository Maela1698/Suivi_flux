@include('CRM.header')
@include('CRM.sidebar')
<title>OrdreFabrication</title>

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

    .donnee {}
</style>
<script>
    function exportToPDF() {

        const element = document.getElementById("sdcpdf");

        // Options de configuration pour html2pdf
        const options = {
            filename: 'OF_{{ $demande[0]->nomtier }}_{{ $demande[0]->nom_modele }}.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };


        // Utilisez html2pdf pour exporter l'élément en PDF
        html2pdf().set(options).from(element).save();
        console.log('bonjour');
    }
</script>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div class="row">
            <div id="sdcpdf" class="card col-12 mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-8" style="color: black; font-size:11px">
                                    <u>OF n:</u> </br>
                                    <u>CLIENT:</u> {{ $demande[0]->nomtier }}</br>
                                    <u>SAISON:</u> {{ $demande[0]->type_saison }}</br>
                                    <u>MODELE:</u> {{ $demande[0]->nom_modele }}</br>
                                    <u>COLORIS:</u> </br>
                                    <u>SUPPORT:</u> </br>
                                    <u>QTE TOTALE:</u>{{ $demande[0]->qte_commande_provisoire }}
                                </div>
                                <div class="col-4 d-flex justify-content-end" style="color: black">
                                    <img src="data:image/png;base64,{{ $demande[0]->photo_commande }}"
                                        class="img-fluid rounded-start mb-5" alt="Logo" width="70px"
                                        height="70px">
                                </div>

                            </div>

                            <table border="1" style="color: black; font-size:11px" class="donnee">
                                <thead>
                                    <tr style="text-align:center;">
                                        <th rowspan="2" style="  width: 250px;">CODE BARRE
                                        </th>
                                        <th rowspan="2" style="  width: 200px;">COLORIS</th>
                                        <th colspan="{{ count($tailleDemande) + 2 }}" style="  width: 800px;">
                                            QTE/COLORIS</th>

                                    </tr>
                                    <tr style="text-align:center; height:20px">
                                        <td colspan="{{ count($tailleDemande) + 2 }}"></td>

                                    </tr>
                                    <tr style="text-align:center;">
                                        <td></td>
                                        <td></td>
                                        <td style="min-width: 40px; border: none; border-top: none; border-left: none;">
                                            TAILLE
                                        </td>
                                        @for ($de = 0; $de < count($tailleDemande); $de++)
                                            <th style=" width: 10px;">{{ $tailleDemande[$de]->unite_taille }}</th>
                                        @endfor
                                        <th style=" width: 10px;">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="text-align:center;">

                                        <td style="  width: 60px;border: none; border-top: none; border-left: none;">
                                        </td>
                                        <td style="border: none; border-top: none; border-left: none;"></td>
                                        <td></td>
                                        @for ($de1 = 0; $de1 < count($tailleDemande); $de1++)
                                            <td>{{ $tailleDemande[$de1]->quantite }}</td>
                                        @endfor
                                        <td>{{ $demande[0]->qte_commande_provisoire }}</td>

                                    </tr>
                                    <tr style="text-align:center;">
                                        <td style="  width: 60px;border: none; border-top: none; border-left: none;">
                                        </td>
                                        <td style=" width: 50px;border: none; border-top: none; "></td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;">0</td>
                                    </tr>
                                    <tr style="text-align:center;">
                                        <td style="  width: 60px;border: none; border-top: none; border-left: none;">
                                        </td>
                                        <td style=" width: 50px;border-top: none;"></td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;"></td>
                                        <td style=" width: 50px;">0</td>
                                    </tr>
                                    <tr style="text-align:center;">
                                        <td style="  width: 60px;border: none; border-top: none; border-left: none;">

                                        </td>
                                        <th>TOTAL</th>
                                        <td></td>
                                        @for ($de2 = 0; $de2 < count($tailleDemande); $de2++)
                                            <th>{{ $tailleDemande[$de2]->quantite }}</th>
                                        @endfor
                                        <th>{{ $demande[0]->qte_commande_provisoire }}</th>
                                    </tr>

                                </tbody>
                            </table>


                            <table border="1" style="color: black;  font-size:11px;" class="donnee mt-4">
                                <tr>
                                    <th style="  width: 250px;text-align:center;">DESIGNATION</th>
                                    <th style="  width: 200px;text-align:center;">COL</th>
                                    <th style="  width: 100px;text-align:center;">REF</th>
                                    <th style="  width: 100px;text-align:center;">C.U</th>
                                    <th style="  width: 100px;text-align:center;">QTE</th>
                                    <th style="  width: 100px;text-align:center;">BESOIN</th>
                                    <th style="  width: 100px;text-align:center;">UNITE</th>
                                    <th style="  width: 100px;text-align:center;">FRNS</th>
                                    <th style="  width: 100px;text-align:center;">BESOIN</th>
                                    <th rowspan="2" style="  width: 100px;text-align:center;">EMPLACEMENT
                                    </th>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align:center;">E15382</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align:center;">3%</td>
                                </tr>
                                @for ($t = 0; $t < count($tissu); $t++)
                                    <tr>
                                        <td>{{ $tissu[$t]->type_tissus }}_{{ $tissu[$t]->designation }}</td>
                                        <td style="text-align:center;">{{ $tissu[$t]->couleur }}</td>
                                        <td style="text-align:center;">{{ $tissu[$t]->reference }}</td>
                                        <td style="text-align:center;">{{ $tissu[$t]->conso_tissus }}</td>
                                        <td style="text-align:center;">{{ $demande[0]->qte_commande_provisoire }}</td>
                                        <td style="text-align:center;">{{ $tissu[$t]->quantite }}</td>
                                        <td style="text-align:center;">{{ $tissu[$t]->unite_mesure }}</td>
                                        <td style="text-align:center;">{{ $tissu[$t]->couleur }}</td>
                                        <td style="text-align:center;">{{ $tissu[$t]->quantite }}</td>
                                        <td style="text-align:center;"></td>
                                    </tr>
                                @endfor
                                @for ($cP = 0; $cP < count($accessoire); $cP++)
                                    <tr>
                                        <td>{{ $accessoire[$cP]->type_accessoire }}_{{ $accessoire[$cP]->designation }}</td>
                                        <td style="text-align:center;">{{ $accessoire[$cP]->couleur }}</td>
                                        <td style="text-align:center;">{{ $accessoire[$cP]->reference }}</td>
                                        <td style="text-align:center;">{{ $accessoire[$cP]->conso_accessoire }}
                                        </td>
                                        <td style="text-align:center;">{{ $demande[0]->qte_commande_provisoire }}</td>
                                        <td style="text-align:center;">{{ $accessoire[$cP]->quantite }}</td>
                                        <td style="text-align:center;">{{ $accessoire[$cP]->unite_mesure }}</td>
                                        <td style="text-align:center;">{{ $accessoire[$cP]->couleur }}</td>
                                        <td style="text-align:center;">
                                            {{ ($accessoire[$cP]->quantite * 103) / 100 }}</td>
                                        <td style="text-align:center;"></td>
                                    </tr>
                                @endfor









                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <button type="submit" onclick="exportToPDF()" class="btn btn-success mr-3">Telecharger</button>
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
@include('CRM.parametre')
<!--**********************************
    Content body end
***********************************-->
@include('CRM.footer')
