@include('CRM.header')
@include('CRM.sidebar')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        /* page-break-inside: avoid; */
    }

    th,
    td {
        word-wrap: break-word;
        max-width: 100px;
        /* Adjust as needed */
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="content-body">
    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card col-12">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">RAPPORT INSPECTION TISSU</p>
            </div>
            <div class="card-body" id="sdcpdf">
                <div class="container">
                    <h1 class="text-center text-black-100 mb-4">Rapport d'Inspection Tissu</h1>

                    <div class="section mb-4">
                        <div class="bg-facebook text-center text-white p-2 mb-3">Informations Générales</div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Date D'Entrée:</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->dateentree }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Saison:</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->saison }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Catégorie:</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->categorie }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">N° Tissu:</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->id }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Classe:</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->classe }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Désignation:</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->des_tissu }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Famille:</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->famille_tissus }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Référence:</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->reftissu }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Fournisseur:</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->fournisseur }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Composition:</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->composition }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Modèle:</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->modele }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Couleur:</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->couleur }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">N° BL:</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->numerobl }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="section mb-4">
                        <div class="bg-facebook text-white p-2 mb-3 text-center">Inspection Tissu</div>
                        <table class="table table-bordered" style="color: black;">
                            <thead class="table" style="color: black;">
                                <tr>
                                    <th>Qté CDE BC</th>
                                    <th>Qté Reçu PL</th>
                                    <th>Laize BC (cm)</th>
                                    <th>Laize Reçu (cm)</th>
                                    <th>Laize Utilisable (cm)</th>
                                    <th>Rouleaux Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ rtrim(rtrim(number_format($historyEntree->qtecommande, 2), '0'), '.') }} m
                                    </td>
                                    <td>{{ rtrim(rtrim(number_format($historyEntree->qterecu, 2), '0'), '.') }} m</td>
                                    <td>{{ rtrim(rtrim(number_format($historyEntree->laize, 2), '0'), '.') }}</td>
                                    <td>{{ rtrim(rtrim(number_format($inspectionTissuRapport->laizerecumin, 2), '0'), '.') . '/' . rtrim(rtrim(number_format($inspectionTissuRapport->laizerecumax, 2), '0'), '.') }}
                                    </td>
                                    <td>{{ rtrim(rtrim(number_format($inspectionTissuRapport->laizeutilisable_min, 2), '0'), '.') }}
                                    </td>
                                    <td>{{ $inspectionTissuRapport->nbrouleau }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="section mb-4">
                        <div class="bg-facebook text-white p-2 mb-3 text-center">Grammage</div>
                        <table class="table table-bordered" style="color: black;">
                            <thead class="table" style="color: black;">
                                <tr>
                                    <th>Grammage</th>
                                    <th>Tolérance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ rtrim(rtrim(number_format($fabricInspection->grammage ?? 0, 2), '0'), '.') }}
                                    </td>
                                    <td>{{ rtrim(rtrim(number_format($fabricInspection->tolerance ?? 0, 2), '0'), '.') ?? 'Not set' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered" style="color: black;">
                            <thead class="table" style="color: black;">
                                <tr>
                                    <th>ROLL #</th>
                                    <th>Weight sur PL</th>
                                    <th>Après vérification GM2</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grammageTissuRapport as $grammageTissuRapports)
                                    <tr>
                                        <td>{{ $grammageTissuRapports->reference }}</td>
                                        <td>{{ rtrim(rtrim(number_format($grammageTissuRapports->poids ?? 0, 2), '0'), '.') }}
                                        </td>
                                        <td>{{ rtrim(rtrim(number_format($grammageTissuRapports->weight_real ?? 0, 2), '0'), '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="section mb-4" style="page-break-inside: avoid;">
                        <div class="bg-facebook text-white p-2 mb-3 text-center" style="width: 100%;">Inspection 100%
                        </div>
                        <table class="table table-bordered" style="width: 100%; table-layout: fixed;color: black">
                            <thead class="table" style="color: black;">
                                <tr>
                                    <th rowspan="2">ROLL N°</th>
                                    <th colspan="4" style="text-align: center">QTE EN m</th>
                                    <th rowspan="2">LAIZE UTILISABLE APRÈS REPOS</th>
                                    <th colspan="1" style="text-align: center">TTL DEFAUTS/RLX</th>
                                    <th colspan="1" style="text-align: center">TTL</th>
                                    <th colspan="2" style="text-align: center">POIDS</th>
                                    <th rowspan="2">DEFECT PER 100 SQ</th>
                                    <th rowspan="2">TOTAL DEFECTS 100 MTS LINEAR</th>
                                    <th rowspan="2">OBSERVAT°</th>
                                    <th rowspan="2">LOT</th>
                                </tr>
                                <tr>
                                    <th>RECU PL(m)</th>
                                    <th>POUR INSPECT°</th>
                                    <th>REEL APRÈS INSPECT°</th>
                                    <th>ÉCART</th>
                                    <th>DFP/PTS</th>
                                    <th>DMP/PTS</th>
                                    <th>POIDS NET</th>
                                    <th>POIDS REEL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inspection100Rapport as $inspection100Rapports)
                                    <tr>
                                        <td>{{ $inspection100Rapports->reference }}</td>
                                        <td>{{ rtrim(rtrim(number_format($inspection100Rapports->metrage ?? 0, 2), '0'), '.') }}
                                        </td>
                                        <td>{{ rtrim(rtrim(number_format($inspection100Rapports->longueurinspect ?? 0, 2), '0'), '.') }}
                                        </td>
                                        <td>{{ rtrim(rtrim(number_format($inspection100Rapports->metragereel ?? 0, 2), '0'), '.') }}
                                        </td>
                                        <td>{{ rtrim(rtrim(number_format($inspection100Rapports->ecart ?? 0, 2), '0'), '.') }}
                                        </td>
                                        <td>{{ rtrim(rtrim(number_format($inspection100Rapports->laizeutilisable ?? 0, 2), '0'), '.') }}
                                        </td>
                                        <td>{{ $inspection100Rapports->defectpoint }}</td>
                                        <td
                                            class="{{ $inspection100Rapports->total_defect_per_100 >= 30 ? 'bg-danger text-white' : ($inspection100Rapports->total_defect_per_100 == $inspection100Rapport->max('total_defect_per_100') ? 'bg-warning text-white' : '') }}">
                                            {{ $inspection100Rapports->demeritpoint }}</td>
                                        <td>{{ number_format($inspection100Rapports->weight_net ?? 0, 2) }}</td>
                                        <td>{{ number_format($inspection100Rapports->weight_real ?? 0, 2) }}</td>
                                        <td>{{ rtrim(rtrim(number_format($inspection100Rapports->defect_per_100 ?? 0, 2), '0'), '.') }}%
                                        </td>
                                        <td
                                            class="{{ $inspection100Rapports->total_defect_per_100 >= 30 ? 'bg-danger text-white' : ($inspection100Rapports->total_defect_per_100 == $inspection100Rapport->max('total_defect_per_100') ? 'bg-warning text-white' : '') }}">
                                            {{ rtrim(rtrim(number_format($inspection100Rapports->total_defect_per_100 ?? 0, 2), '0'), '.') }}%
                                        </td>
                                        <td>{{ $inspection100Rapports->observation }}</td>
                                        <td>{{ $inspection100Rapports->lot }}</td>
                                    </tr>
                                @endforeach
                                <tr style="background-color: lightslategray">
                                    <td>TOTAL</td>
                                    <td>{{ rtrim(rtrim(number_format($totalInspection100->tot_metrage ?? 0, 2), '0'), '.') }}
                                    </td>
                                    <td>{{ rtrim(rtrim(number_format($totalInspection100->tot_longueurinspect ?? 0, 2), '0'), '.') }}
                                    </td>
                                    <td>{{ rtrim(rtrim(number_format($totalInspection100->tot_metragereel ?? 0, 2), '0'), '.') }}
                                    </td>
                                    <td>{{ rtrim(rtrim(number_format($totalInspection100->tot_ecart ?? 0, 2), '0'), '.') }}
                                    </td>
                                    <td></td>
                                    <td>{{ rtrim(rtrim(number_format($totalInspection100->tot_defectpoint ?? 0, 2), '0'), '.') }}
                                    </td>
                                    <td>{{ rtrim(rtrim(number_format($totalInspection100->tot_demeritpoint ?? 0, 2), '0'), '.') }}
                                    </td>
                                    <td>{{ rtrim(rtrim(number_format($totalInspection100->tot_weight_net ?? 0, 2), '0'), '.') }}
                                    </td>
                                    <td>{{ rtrim(rtrim(number_format($totalInspection100->tot_weight_real ?? 0, 2), '0'), '.') }}
                                    </td>
                                    <td></td>
                                    <td>{{ rtrim(rtrim(number_format($totalInspection100->tot_defect_per_100 ?? 0, 2), '0'), '.') }}%
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: center" colspan="2">
                                        {{ rtrim(rtrim(number_format($totalInspection100->total_ecart_poids ?? 0, 2), '0'), '.') }}
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="section mb-4" style="page-break-inside: avoid;">
                        <div class="bg-facebook text-white p-2 mb-3 text-center">DETAILS METRAGE PAR LAIZE</div>
                        <table class="table table-bordered" style="color: black;">
                            <thead style="color: black;">
                                <tr>
                                    <th colspan="{{ count($detailmetrageaizeRapport) + 1 }}"
                                        style="text-align: center">LAIZE</th>
                                    <th class="total-column">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Laize</td>
                                    @foreach ($detailmetrageaizeRapport as $detailmetrageaizeRapports)
                                        <td>{{ rtrim(rtrim(number_format($detailmetrageaizeRapports->laizeutilisable ?? 0, 2), '0'), '.') }}
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>NOMBRE DE RLX</td>
                                    @foreach ($detailmetrageaizeRapport as $detailmetrageaizeRapports)
                                        <td>{{ $detailmetrageaizeRapports->nbrouleau }}</td>
                                    @endforeach
                                    <td class="total-column">
                                        {{ rtrim(rtrim(number_format($totaleDetailMetrageLaizeRapport->tot_nbrouleau ?? 0, 2), '0'), '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>METRAGE</td>
                                    @foreach ($detailmetrageaizeRapport as $detailmetrageaizeRapports)
                                        <td>{{ rtrim(rtrim(number_format($detailmetrageaizeRapports->metrage ?? 0, 2), '0'), '.') }}
                                        </td>
                                    @endforeach
                                    <td class="total-column">
                                        {{ rtrim(rtrim(number_format($totaleDetailMetrageLaizeRapport->tot_metrage ?? 0, 2), '0'), '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>SURFACE</td>
                                    @foreach ($detailmetrageaizeRapport as $detailmetrageaizeRapports)
                                        <td>{{ rtrim(rtrim(number_format($detailmetrageaizeRapports->surface ?? 0, 2), '0'), '.') }}
                                        </td>
                                    @endforeach
                                    <td class="total-column">
                                        {{ rtrim(rtrim(number_format($totaleDetailMetrageLaizeRapport->tot_surface ?? 0, 2), '0'), '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered" style="color: black;">
                            <thead style="color: black;">
                                <tr>
                                    <th colspan="{{ count($detailmetrageLotRapport) + 1 }}"
                                        style="text-align: center">
                                        LOT
                                    </th>
                                    <th class="total-column">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>LOT</td>
                                    @foreach ($detailmetrageLotRapport as $detailmetrageLotRapports)
                                        <td>{{ $detailmetrageLotRapports->lot }}</td>
                                    @endforeach
                                    <td class="total-column"></td>
                                </tr>
                                <tr>
                                    <td>Avant inspection</td>
                                    @foreach ($detailmetrageLotRapport as $detailmetrageLotRapports)
                                        <td>{{ $detailmetrageLotRapports->metrage }}</td>
                                    @endforeach
                                    <td class="total-column">
                                        {{ $totaleDetailMetrageLotRapport->tot_metrage }}</td>
                                </tr>
                                <tr>
                                    <td>Après inspection</td>
                                    @foreach ($detailmetrageLotRapport as $detailmetrageLotRapports)
                                        <td>{{ rtrim(rtrim(number_format($detailmetrageLotRapports->metragereel ?? 0, 2), '0'), '.') }}
                                        </td>
                                    @endforeach
                                    <td class="total-column">
                                        {{ rtrim(rtrim(number_format($totaleDetailMetrageLotRapport->tot_metragereel ?? 0, 2), '0'), '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="section mb-4" style="page-break-inside: avoid;">
                        <div class="bg-facebook text-white p-2 mb-3 text-center">Résultats après inspection</div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Defaut Majeur</label>
                                <div class="form-control">{{ $resultatInspection->defaut_majeur }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Defaut Mineur</label>
                                <div class="form-control">{{ $resultatInspection->defaut_mineur }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Identité tissu</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->des_tissu . ' ' . $historyEntree->reftissu . ' ' . $historyEntree->couleur }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Modèle</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $historyEntree->modele }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Nombre de lot</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ rtrim(rtrim(number_format($historyEntree->nblot ?? 0, 2), '0'), '.') }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Quantité réel à réclamer</label>
                                <div class="form-control {{ $historyEntree->qte_reclamer > 0 ? 'bg-danger' : '' }} "
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ rtrim(rtrim(number_format($resultatInspection->qte_reclamer ?? 0, 2), '0'), '.') }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Sens</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $resultatInspection->sens == 0 ? 'A SENS' : 'N/A' }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Endroit tissu</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $resultatInspection->endroit }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Envers tissu</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $resultatInspection->envers }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Ecart angulaire</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ rtrim(rtrim(number_format($resultatInspection->ecart_angulaire ?? 0, 2), '0'), '.') }}%
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Conformite</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $resultatInspection->conformite == 0 ? 'OK VALIDATION' : 'VALIDATION DENIER' }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Resultat d'elongation/retraction</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    L:{{ rtrim(rtrim(number_format($resultatInspection->longueurelong == 0 ? $resultatInspection->longueuretrait : $resultatInspection->longueurelong ?? 0, 2), '0'), '.') }}
                                    W:{{ rtrim(rtrim(number_format($resultatInspection->laizeelong == 0 ? $resultatInspection->laizeretrait : $resultatInspection->laizeelong ?? 0, 2), '0'), '.') }}
                                    {{ $resultatInspection->type_deformation }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">SMS/SME</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $resultatInspection->sms_sme == 0 ? 'ACCEPTABLE' : 'NON ACCEPTABLE' }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Nuance</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $resultatInspection->nuance == 0 ? 'NON ATTEINT' : 'ATTEINT' }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Resultat disgorgement à sec</label>
                                <div
                                    class="form-control"style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $resultatInspection->disgorgement_dry }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Resultat disgorgement mouiller</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $resultatInspection->disgorgement_wet }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Temps de relaxation</label>
                                <div class="form-control"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $resultatInspection->temps_relaxation }}</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Resulat inspection</label>
                                <div class="form-control {{ $resultatInspection->resultat_inspection == 0 ? 'bg-success' : 'bg-danger' }} text-white"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;{{ $resultatInspection->resultat_inspection == 0 ? '' : '' }}">
                                    {{ $resultatInspection->resultat_inspection == 0 ? 'ACCEPTABLE' : 'NON ACCEPTABLE' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section mb-4">
                        <textarea class="form-control" name="commentaire"></textarea>
                    </div>
                </div>
            </div>
            <div class="footer text-end mt-4">
                <button type="submit" onclick="exportToPDF()" class="btn btn-success"
                    style="height: 35px;">Telecharger</button>
            </div>
        </div>
    </div>
</div>
@include('CRM.footer')
<script>
    function exportToPDF() {
        const element = document.getElementById("sdcpdf");

        const options = {
            filename: 'Rapport-qualité-{{ $historyEntree->des_tissu . '-' . $historyEntree->reftissu . '-' . $historyEntree->dateentree }}.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2,
                useCORS: true, // Enable cross-origin resource sharing
                logging: true // Enable logging for debugging
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4', // Format A4 pour l'exportation
                orientation: 'portrait'
            }
        };

        html2pdf().set(options).from(element).save();
    }
</script>
