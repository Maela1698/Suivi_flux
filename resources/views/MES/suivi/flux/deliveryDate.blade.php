<div class="col-left">
    <h3 class="title"><strong>DELIVERY DATE</strong></h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>STYLE</th>
                    <th>OF</th>
                    <th>SIZE</th>
                    <th>COLOR</th>
                    <th>CONFIRMÉ</th>
                    <th>LIVRAISON</th>
                    <th>STADE</th>
                    <th>JOUR RESTANT</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($suivi); $i++)
                    <tr class="{{ $suivi[$i]->diff_date['jourJ'] ? 'jourJ' : ''}}">
                        <td>{{ $suivi[$i]->nom_modele }}</td>
                        <td>{{ $suivi[$i]->numero_commande }}</td>
                        <td>{{ $suivi[$i]->unite_taille }}</td>
                        <td>{{ $suivi[$i]->couleur }}</td>
                        <td>{{ $suivi[$i]->date_livraison_confirme }}</td>
                        <td>{{ $suivi[$i]->ex_factory }}</td>
                        @if($suivi[$i]->diff_date['etat'] == 1 && $suivi[$i]->diff_date['diff'] <= 3)
                            <td class="progress-td">
                                <div class="progress">
                                    <div class="progress-bar bg-danger progress-animated" style="width: {{ $suivi[$i]->pourcentage }}%; height:6px;" role="progressbar">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </td>
                            <td>J - {{ $suivi[$i]->diff_date['diff'] }}</td>
                        @elseif($suivi[$i]->diff_date['etat'] == 1 && $suivi[$i]->diff_date['diff'] > 3)
                            <td class="progress-td">
                                <div class="progress">
                                    <div class="progress-bar bg-success progress-animated" style="width: {{ $suivi[$i]->pourcentage }}%; height:6px;" role="progressbar">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </td>
                            <td>J - {{ $suivi[$i]->diff_date['diff'] }}</td>
                        @elseif($suivi[$i]->diff_date['etat'] == 0 && ($suivi[$i]->diff_date['diff'] != 0) )
                            <td class="progress-td">
                                <div class="progress">
                                    <div class="progress-bar bg-danger progress-animated" style="width: {{ $suivi[$i]->pourcentage }}%; height:6px;" role="progressbar">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </td>
                            <td>J + {{ $suivi[$i]->diff_date['diff'] }}</td>
                        @elseif($suivi[$i]->diff_date['diff'] == 0)
                            <td class="progress-td">
                                <div class="progress">
                                    <div class="progress-bar bg-danger progress-animated" style="width: {{ $suivi[$i]->pourcentage }}%; height:6px;" role="progressbar">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </td>
                            <td>Jour J</td>
                        @endif
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>