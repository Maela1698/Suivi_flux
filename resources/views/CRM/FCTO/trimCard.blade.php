@include('CRM.header')
@include('CRM.sidebar')
<title>Trim Card</title>

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
<script>
    function exportToPDF() {

        const element = document.getElementById("sdcpdf");

        // Options de configuration pour html2pdf
        const options = {
            filename: 'Trim_card_{{ $demande[0]->nomtier }}_{{ $demande[0]->nom_modele }}_{{ $demande[0]->type_stade }}.pdf',
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
                orientation: 'landscape'
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
            <div id="sdcpdf" class="card col-12">
                <div class="card-header d-flex justify-content-center align-items-center entete mt-0">
                    <h3 class="entete">TRIM CARD-PRODUCTION</h3>
                </div>

                <div class="row mt-0 mr-3">
                    <div class="col-3" style="color: #000">
                        Client: {{ $demande[0]->nomtier }}<br>
                        Saison: {{ $demande[0]->type_saison }}<br>
                        Modele: {{ $demande[0]->nom_modele }}
                    </div>
                    <div class="col-6 d-flex justify-content-center">
                        <div class="card" style="border: 2px solid #000;width: 500px; height: 50px;">
                            <center><span style="color: black; font-size:20px">REF COMMANDE
                                    {{ $demande[0]->nom_modele }}</span></center>
                        </div>
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <div class="card" style="border: 2px solid #000;width: 200px; height: 50px;">
                            <span style="color: black; font-size:13px">Visa merch</span>
                        </div>

                    </div>
                </div>


                <div class="card-body mt-0">
                    <div style="display: flex; flex-wrap: wrap;" class="mt-0">
                        @for ($t = 0; $t < count($tissu); $t++)
                            <table border="1"
                                style="margin: 0; padding: 0; border-spacing: 0; color:#000; width: 20%;">
                                <tr
                                    style="width: 119px; height: 40px; word-wrap: break-word; word-break: break-all; white-space: normal;">
                                    <td style="width: 50%;">B:{{ $tissu[$t]->quantite }}</td>
                                    <td style="width: 50%;">R:</td>
                                </tr>
                                <tbody>
                                    <tr>
                                        <td colspan="2"
                                            style="height: 119px; vertical-align: top; text-align: center; font-size: 12px;">
                                            -{{ $tissu[$t]->type_tissus }}( {{ $tissu[$t]->unite_mesure }})/{{ $tissu[$t]->designation }}
                                            <br>
                                            -{{ $tissu[$t]->reference }}
                                            <br>
                                            -{{ $tissu[$t]->composition_tissus }}/{{ $tissu[$t]->grammage }}g
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endfor

                        @for ($a = 0; $a < count($accessoire); $a++)
                            <table border="1"
                                style="margin: 0; padding: 0; border-spacing: 0; color:#000; width: 20%;">

                                <tr
                                    style="width: 119px; height: 40px; word-wrap: break-word; word-break: break-all; white-space: normal;">
                                    <td style="width: 50%;">B:{{ ($accessoire[$a]->quantite * 103) / 100 }}
                                    </td>
                                    <td style="width: 50%;">R:</td>
                                </tr>
                                <tbody>
                                    <tr>
                                        <td colspan="2"
                                            style="height: 119px; vertical-align: top; text-align: center; font-size: 12px;">
                                            -{{ $accessoire[$a]->type_accessoire }}({{ $accessoire[$a]->unite_mesure }})/{{ $accessoire[$a]->designation }}
                                            </br>
                                            -{{ $accessoire[$a]->reference }}
                                            </br>
                                            -{{ $accessoire[$a]->famille_accessoire }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" onclick="exportToPDF()" class="btn btn-success mr-3">Telecharger</button>
    </div>
</div>


<!--**********************************
        modal start
***********************************-->



@include('CRM.parametre')

<!--**********************************
        javascript start
***********************************-->

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
