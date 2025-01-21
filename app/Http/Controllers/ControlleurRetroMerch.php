<?php

namespace App\Http\Controllers;

use App\Models\BmcPlanning;
use App\Models\BmPlanning;
use App\Models\DataMacro;
use App\Models\DataPro;
use App\Models\Date_Micro_Modifier;
use App\Models\DemandeClient;
use App\Models\EtapeRetro;
use App\Models\Lavage;
use App\Models\OkProdInitial;
use App\Models\RecapCommande;
use App\Models\ResultatCalculRetro;
use App\Models\Destination;
use App\Models\FiltreDemande;
use App\Models\RetroMerch;
use App\Models\MicroMerchDev;
use App\Models\PrintPlanning;
use App\Models\RetroPlanning;
use App\Models\Saison;
use App\Models\Smv;
use App\Models\StadeDemandeClient;
use App\Models\V_retro_merch;
use App\Models\ValeurAjoute;
use App\Models\VRecapMasterPlan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;

class ControlleurRetroMerch extends Controller
{
    public function retro(Request $request)
    {

        $retro = DB::table(DB::raw('(SELECT *, ROW_NUMBER() OVER (PARTITION BY id_demande_client ORDER BY demande_id DESC) AS rn FROM v_micro_merch WHERE demande_etat = 0 AND id_etat=1 ORDER BY id_demande_client DESC) AS ranked_retro_merch'));
        $hasFilters = false;
        $nomTiers = null;
        if ($request->idTiers ) {
            $retro->where('id_tiers', $request->input('idTiers'));
            $nomTiers = V_retro_merch::where('id_tiers',$request->idTiers)->pluck('nomtier')->first();
            $hasFilters = true;
        }
        $nomStyle = null;
        if ($request->idStyle ) {
            $retro->where('id_style', $request->input('idStyle'));
            $nomStyle = V_retro_merch::where('id_style',$request->idStyle)->pluck('nom_style')->first();
            $hasFilters = true;
        }
        if ($request->stade) {
            $retro->where('id_stade', $request->input('stade'));
            $hasFilters = true;
        }
        $nomSaison = null;
        if ($request->idSaison) {
            $retro->where('id_saison', $request->input('idSaison'));
            $nomSaison = Saison::where('id',$request->idSaison)->pluck('type_saison')->first();
            $hasFilters = true;
        }
        if ($request->modele) {
            $retro->where('nom_modele', 'ILIKE', '%' . $request->input('modele') . '%');
            $hasFilters = true;
        }
        if ($request->start && $request->end) {
            $retro->whereBetween('demande_date_entree', [$request->input('start'), $request->input('end')]);
            $hasFilters = true;
        }
        if ($request->etatretro) {

            if ($request->input('etatretro') == 1) {
                // Récupère les filtres avant la boucle
                $filtre = DB::table('v_filtre_dispo')->get();

                // Initialise un tableau pour stocker tous les ids avec micro_realisation null
                $all_ids_with_null_micro_realisation = collect();

                foreach ($filtre as $f) {
                    $id_etapes = array_diff((array) $f->id_etape, [31,36]);
                    // Récupère les ids des demandes ayant micro_realisation null pour chaque id_demande_client et id_etape
                    $ids_with_null_micro_realisation = DB::table('v_micro_merch')
                        ->select('demande_id')
                        ->where('id_demande_client', $f->id_demande_client) // Filtrer sur les id_demande_client
                        ->where('id_etape',$id_etapes)
                        ->whereNull('micro_realisation') // Vérifie que micro_realisation est null
                        ->pluck('demande_id'); // Récupère les id_demande

                    // Ajoute les résultats à la collection principale
                    $all_ids_with_null_micro_realisation = $all_ids_with_null_micro_realisation->merge($ids_with_null_micro_realisation);
                }

                // Appliquer la condition à $retro si des ids ont été trouvés
                if (!$all_ids_with_null_micro_realisation->isEmpty()) {
                    $retro->whereIn('demande_id', $all_ids_with_null_micro_realisation);
                }
                $hasFilters = true;
            }

            if ($request->input('etatretro') == 2) {
                // Récupère les filtres avant la boucle
                $filtre = DB::table('v_filtre_envoie_sdc')->get();

                // Initialise un tableau pour stocker tous les ids avec micro_realisation null
                $all_ids_with_null_micro_realisation = collect();

                foreach ($filtre as $f) {
                    $id_etapes = array_diff((array) $f->id_etape, [32,37]);
                    // Récupère les ids des demandes ayant micro_realisation null pour chaque id_demande_client et id_etape
                    $ids_with_null_micro_realisation = DB::table('v_micro_merch')
                        ->select('demande_id')
                        ->where('id_demande_client', $f->id_demande_client) // Filtrer sur les id_demande_client
                        ->where('id_etape',$id_etapes)
                        ->whereNull('micro_realisation') // Vérifie que micro_realisation est null
                        ->pluck('demande_id'); // Récupère les id_demande

                    // Ajoute les résultats à la collection principale
                    $all_ids_with_null_micro_realisation = $all_ids_with_null_micro_realisation->merge($ids_with_null_micro_realisation);
                }
                // Appliquer la condition à $retro si des ids ont été trouvés
                if (!$all_ids_with_null_micro_realisation->isEmpty()) {
                    $retro->whereIn('demande_id', $all_ids_with_null_micro_realisation);
                }
                $hasFilters = true;
            }

            if ($request->input('etatretro') == 3) {
                // Récupère les filtres avant la boucle
                $filtre = DB::table('v_filtre_retard')->get();

                // Initialise un tableau pour stocker tous les ids avec micro_realisation null
                $all_ids_with_null_micro_realisation = collect();

                foreach ($filtre as $f) {
                    // Récupère les ids des demandes ayant micro_realisation null pour chaque id_demande_client et id_etape
                    $ids_with_null_micro_realisation = DB::table('v_micro_merch')
                        ->select('demande_id')
                        ->where('id_demande_client', $f->id_demande_client) // Filtrer sur les id_demande_client
                         // Vérifie que micro_realisation est null
                        ->pluck('demande_id'); // Récupère les id_demande

                    // Ajoute les résultats à la collection principale
                    $all_ids_with_null_micro_realisation = $all_ids_with_null_micro_realisation->merge($ids_with_null_micro_realisation);
                }

                // Appliquer la condition à $retro si des ids ont été trouvés
                if (!$all_ids_with_null_micro_realisation->isEmpty()) {
                    $retro->whereIn('demande_id', $all_ids_with_null_micro_realisation);
                }
                $hasFilters = true;
            }

            if ($request->input('etatretro') == 4) {
                // Récupère les filtres avant la boucle
                $filtre = DB::table('v_filtre_ok_prod')->get();

                // Initialise un tableau pour stocker tous les ids avec micro_realisation null
                $all_ids_with_null_micro_realisation = collect();

                foreach ($filtre as $f) {
                    $id_etapes = array_diff((array) $f->id_etape, [3,8,13,18,23,28,38]);
                    // Récupère les ids des demandes ayant micro_realisation null pour chaque id_demande_client et id_etape
                    $ids_with_null_micro_realisation = DB::table('v_micro_merch')
                        ->select('demande_id')
                        ->where('id_demande_client', $f->id_demande_client) // Filtrer sur les id_demande_client
                        ->where('id_etape',$id_etapes)
                        ->whereNull('micro_realisation') // Vérifie que micro_realisation est null
                        ->pluck('demande_id'); // Récupère les id_demande
                    // Ajoute les résultats à la collection principale
                    $all_ids_with_null_micro_realisation = $all_ids_with_null_micro_realisation->merge($ids_with_null_micro_realisation);
                }
                // Appliquer la condition à $retro si des ids ont été trouvés
                if (!$all_ids_with_null_micro_realisation->isEmpty()) {
                    $retro->whereIn('demande_id', $all_ids_with_null_micro_realisation);
                }
                $hasFilters = true;
            }
        }

        if (!$hasFilters) {
            $retro->limit(100);
        }

        $nondispo = RetroMerch::getMpNonDispoKpi();
        $retard = RetroMerch::getRetardKpi();
        $envoiesdc = RetroMerch::getEnvoiSdcKpi();
        $okprod = RetroMerch::getOkProdKpi();
        $demandes = $retro->where('rn', 1)->get();
        $etatretro = RetroMerch::getEtatRetroMerch();
        $stade = StadeDemandeClient::all();
        return view('PLANNING.retromerch.retro',compact('demandes','etatretro','stade','nondispo','envoiesdc','okprod','retard'));
    }
    public function micro(Request $request)
    {
        $demandes = MicroMerchDev::getAllListeDemandeNego();
        $total =0;
        $totalreelle =0;

        foreach ($demandes as $demande) {
            $idDemande = $demande->id;
                ResultatCalculRetro::CalculeAllDate($idDemande);
                $ok = ResultatCalculRetro::where('id_etape', 33)
                    ->where('id_demande_client', $idDemande)
                    ->value('date_fin_prevue');
                // Sauvegarder la date pour id_etape = 33
                OkProdInitial::updateOrCreate(
                    ['id_demande_client' => $idDemande],
                    ['date_initial' => $ok]
                );
        }

        $anne = MicroMerchDev::getAnne();
        $parametre = MicroMerchDev::getAllParametre();
        if($parametre->isEmpty()){
            foreach ($anne as $a){
                MicroMerchDev::insertAnne($a->annee);
            }
        }

        // $micro = DB::table('v_filtre_micro')->where('demande_etat',0)->where('id_etat',1)->orderBy('id_demande_client','desc')->orderBy('id_etape','asc');
        $micro = DB::table('v_filtre_micro')
            ->where('demande_etat', 0)
            ->where('id_etat', 1)
            ->whereIn('id_demande_client', function($query) {
            $query->select('id_demande_client')
                ->from('v_filtre_micro')
                ->groupBy('id_demande_client')
                ->orderBy('id_demande_client', 'desc')
                ->limit(20);
            })
            ->orderBy('id_demande_client', 'desc')
            ->orderBy('id_etape', 'asc');
        $hasFilters = false;
        $columns = ['nom_modele', 'nom_style', 'theme', 'nomtier', 'type_incontern','type_phase','type_saison','type_stade'];
        if ($request->search) {
            $searchTerm = $request->input('search');
            $micro->where(function($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
            $hasFilters = true;
        }

        if ($request->startdeadline && $request->enddeadline) {
            $micro->whereBetween('datecalcul', [$request->startdeadline, $request->enddeadline]);
            $hasFilters = true;
        }
        if ($request->startrealisation && $request->endrealisation) {
            $micro->whereBetween('micro_realisation', [$request->startrealisation, $request->endrealisation]);
            $hasFilters = true;
        }
        if ($request->startsemaine && $request->endsemaine) {
            $micro->where('semaine', '>=', $request->startsemaine)->where('semaine', '<=', $request->endsemaine);
            };
            $hasFilters = true;
        if ($request->annee) {
            $micro->where('annee',$request->annee);
            $hasFilters = true;
        }
        if($request->startsemaine && $request->endsemaine && $request->annee){
            $capacite = MicroMerchDev::getCapacite($request->startsemaine,$request->endsemaine,$request->annee);
            $id = MicroMerchDev::getIdDemandeByFiltre($request->startsemaine, $request->endsemaine, $request->annee);
            if(!$id->isEmpty()){
                for ($i = 0; $i < count($id); $i++) {
                    $planning = MicroMerchDev::getPlanning($id[$i]->id_demande_client); // Passer l'ID spécifique
                    $total = $planning+$total;
                }
                for ($i = 0; $i < count($id); $i++) {
                    $reelproduit = MicroMerchDev::getReelProduit($id[$i]->id_demande_client);
                    $totalreelle = $reelproduit+$totalreelle;
                }
                $charge = $total/$capacite*100;
                $chargereel = $totalreelle/$capacite*100;
                $hasFilters = true;
            }
            else{
                $capacite = 0;
                $planning = 0;
                $charge = 0;
                $chargereel = 0;
            }
        }else{
            $capacite = 0;
            $planning = 0;
            $charge = 0;
            $chargereel = 0;
        }
        if (!$hasFilters) {
            $micro->whereIn('id_demande_client', function($query) {
              $query->select('id_demande_client')
                    ->distinct()
                    ->from('v_filtre_micro')
                    ->where('id_etat',1)
                    ->orderBy('id_demande_client','desc');
            })->orderBy('id_demande_client','desc');
        }
        // Récupérer les résultats pour la demande actuelle
        $today = Carbon::now()->format('Y-m-d');
        $demandes = $micro->get();
        return view('PLANNING.retromerch.micro', compact('demandes','today','capacite','planning','total','totalreelle','charge','chargereel'));
    }
    public function detailRetro(Request $request)
    {
        // Récupérer les valeurs du formulaire
        $idDemande = $request->input('idDemande');
        $okprod = Carbon::parse($request->input('okprodinitial'));
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        ResultatCalculRetro::CalculeAllDate($idDemande);
        $okprodactuel = Carbon::parse(ResultatCalculRetro::where('id_etape', 33)
                ->where('id_demande_client', $idDemande)
                ->value('date_fin_prevue'));

            $retard = $okprod->diffInDays($okprodactuel);
            if ($retard < 0) {
                $retard = 0;
            }
        // Récupérer les résultats
        $today = Carbon::now()->format('Y-m-d');
        $mat = Carbon::parse($demande[0]->date_livraison)->subDays(60);
        $prod = Carbon::parse($mat)->addDays(14);
        $result = RetroMerch::getDonne($idDemande);

        return view('PLANNING.retromerch.detailRetro', compact('demande', 'result', 'today','retard','idDemande','prod'));
    }
    public function updateEtat(Request $request)
    {
        $id = $request->input('id');
        $idDemande = $request->input('idDemande');
        $checked = $request->input('checked');
        $checked = ($checked === 'on' || $checked === 'true') ? 0 : 1; // Convertir checked en 0 ou 1
        for ($i = $id; $i < $id + 5; $i++) {
            $item = ResultatCalculRetro::where('id_demande_client', $idDemande)
            ->where('id_etape', $i)
            ->first();
            if ($item) {
                $item->etat = $checked; // Mettre à jour l'état en fonction de la case
                $item->save();
            }
        }

        return response()->json(['id' => $id]);
    }

    public function microRealisation(Request $request){
        $idDemande = $request->input('idDemande');
        $resultat_id = $request->input('resultat_id');
        $realisation = $request->input('realisation'); // Date de réalisation
        $commentaires = $request->input('commentaires');
        ResultatCalculRetro::where('id', $resultat_id)
            ->update(['date_fin_reelle' => $realisation, 'commentaires' => $commentaires]);
        ResultatCalculRetro::CalculeAllDate($idDemande);
         return redirect()->route('PLANNING.micro');
    }
    public function recapcommande(Request $request)
    {
        $recaps = DB::table('v_general_final_recap')->where('etat',0)->where('id_etat',2)->orderBy('date_livraison','asc');
        $nomTiers = null;
        if ($request->idTiers ) {
            $recaps->where('id_tiers', $request->input('idTiers'));
            $nomTiers = FiltreDemande::where('id_tiers',$request->idTiers)->pluck('nomtier')->first();
        }
        $nomStyle = null;
        if ($request->idStyle ) {
            $recaps->where('id_style', $request->input('idStyle'));
            $nomStyle = FiltreDemande::where('id_style',$request->idStyle)->pluck('nom_style')->first();
        }
        $nomSaison = null;
        if ($request->idSaison) {
            $recaps->where('id_saison', $request->input('idSaison'));
            $nomSaison = Saison::where('id',$request->idSaison)->pluck('type_saison')->first();
        }
        if ($request->va) {
            if($request->input('va')=='lavage'){
                $recaps->whereNotNull('types_lavage');
            }
            if($request->input('va')!='lavage'){
                $recaps->where('types_valeur_ajout', 'ILIKE', '%' . $request->input('va') . '%');
            }
        }
        if ($request->etat) {
            if ($request->input('etat') == 'expedietout') {
                $recaps->where('livraison_couleur','rgb(114, 250, 114)');
            }
            if ($request->input('etat') == 'expedie') {
                $recaps->where('livraison_couleur','rgb(87, 87, 255)');
            }
            if ($request->input('etat') == 'retard') {
                $recaps->where(function ($query) {
                    $query->where(function ($subQuery) {
                        $subQuery->whereNotNull('etdrevise')
                                 ->where('etdrevise', '<', now());
                    })->orWhere(function ($subQuery) {
                        $subQuery->whereNull('etdrevise')
                                 ->where('date_livraison', '<', now());
                    });
                });
            }
        }
        if ($request->modele) {
            $recaps->where('nom_modele', 'ILIKE', '%' . $request->input('modele') . '%');
        }
        if ($request->startetdinitial && $request->endetdinitial) {
            $recaps->whereBetween('etdinitial', [$request->input('startetdinitial'), $request->input('endetdinitial')]);
        }
        if ($request->startetdreviser && $request->endetdreviser) {
            $recaps->whereBetween('etdrevise', [$request->input('startetdreviser'), $request->input('endetdreviser')]);
        }
        $recap = $recaps->get();
        $nbrcommande = count($recap);
        $qteexpedie = $recap->filter(function ($item) {
            return $item->livraison_couleur === 'rgb(114, 250, 114)' ||
                   $item->livraison_couleur === 'rgb(87, 87, 255)';
        })->sum('qteof');
        $quantite = $recap->sum('qte_commande_provisoire');
        $expedie = $recap->filter(function ($item) {
            return $item->livraison_couleur === 'rgb(114, 250, 114)' ||
                   $item->livraison_couleur === 'rgb(87, 87, 255)';
        })->count();
        $lbt = $recap->filter(function ($item) {
            return $item->types_lavage != '' ||
                   stripos($item->types_valeur_ajout, 'Blanchiment') !== false ||
                   stripos($item->types_valeur_ajout, 'Teinture') !== false;
        })->count();
        $broadmain = $recap->filter(function ($item) {
            return stripos($item->types_valeur_ajout, 'Broderie main') !== false;
        })->count();
        $broadmachine = $recap->filter(function ($item) {
            return stripos($item->types_valeur_ajout, 'Broderie machine') !== false;
        })->count();
        $serigraphie = $recap->filter(function ($item) {
            return stripos($item->types_valeur_ajout, 'Serigraphie') !== false;
        })->count();
        return view('PLANNING.recapcommande.recapCommande',compact('recap','nbrcommande','qteexpedie','quantite','expedie','lbt','broadmain','broadmachine','serigraphie'));
    }
    public function detailRecap(Request $request)
    {
        $iddemande = $request->input('idDemande');
        $idrecap = $request->input('idRecap');
        $destination = RecapCommande::getAllDestination();
        $recap = RecapCommande::where('iddemandeclient', $iddemande)->first();
        $destrecap = RecapCommande::getDestinationRecapCommandeById($idrecap);
        $cin = RecapCommande::getCin($iddemande);
        $lavage = Lavage::getAllLavageDemandeById($iddemande);
        $va = ValeurAjoute::getAllValeurDemandeById($iddemande);
        $smv = Smv::getLastSmvByIdDemande($iddemande);
        $mat = Carbon::parse($cin[0]->date_livraison)->subDays(60);
        $prod = Carbon::parse($mat)->addDays(14);
        return view('PLANNING.recapcommande.detailrecap',compact('cin','recap','destination','destrecap','lavage','va','smv','mat','prod'));
    }
    public function modifierRecapCommande(Request $request)
    {
        $iddemande = $request->input('iddemande');
        $idrecap = $request->input('id');
        $request->validate([
            'bcclient' => 'mimes:pdf|max:10000',
        ]);
        $bcclient = "";
        if ($request->hasFile('bcclient')) {
            $uploadedPDF = $request->file('bcclient');
            $bcclient = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
        }
        else{
            $bcclient = $request->input('bcclientexistant');
        }

        RecapCommande::updateOrCreate(
        ['iddemandeclient' => $iddemande],
        ['etdrevise' => $request->input('etdrevise'),
        'etdpropose' => $request->input('etdpropose'),
        'receptionbc' => $request->input('datereception'),
        'bcclient' => $bcclient
        ]
        );
        return redirect()->route('PLANNING.detailRecap',['idDemande' => $iddemande,'idRecap' =>$idrecap]);
    }
    public function modifierDestinationRecapCommande(Request $request)
    {
        $iddemande = $request->input('iddemande');
        $idrecap = $request->input('id');

        $champ1 = $request->input('champ1'); // Tableau de 'num cmd'
        $champ2 = $request->input('champ2'); // Tableau de 'etd'
        $champ3 = $request->input('champ3');// Tableau de 'quantite'
        $champ4 = $request->input('champ4'); // Tableau de 'destination'
        $champ5 = $request->input('champ5'); // Tableau de 'destination'
        $champ6 = $request->input('champ6');
        Destination::where('idrecapcommande', $idrecap)->delete();
        foreach ($champ1 as $index => $value) {
            Destination::Create(
            ['idrecapcommande' => $idrecap,
            'numerocommande' => $champ1[$index],
            'etdinitial' =>$champ2[$index],
            'datelivraisonexacte' =>$champ5[$index],
            'dateinspection' =>$champ6[$index],
            'qteof' =>$champ3[$index],
            'iddeststd' =>$champ4[$index]
            ]
            );
        }
        return redirect()->route('PLANNING.detailRecap',['idDemande' => $iddemande,'idRecap' =>$idrecap]);
    }
    public function deleteLigneDest(Request $request)
    {
        $iddemande = $request->input('iddemande');
        $idrecap = $request->input('id');
        $idDes = $request->input( 'idDes');
        Destination::where('id', $idDes)->delete();

        return redirect()->route('PLANNING.detailRecap',['idDemande' => $iddemande,'idRecap' =>$idrecap]);
    }
    public function modifierDateDeadline(Request $request)
    {
        // Récupérer les valeurs du formulaire
        $idDemande = $request->input('idDemande');
        $idresultat = $request->input('idresultat');
        $datemodifier = $request->input('deadlinemodifier');
        ResultatCalculRetro::where('id', $idresultat)
            ->update(['date_fin_prevue' => $datemodifier, 'etatupdate' => 1]);
        ResultatCalculRetro::CalculeAllDate($idDemande);
        return redirect()->route('PLANNING.micro');
    }
    public function microrealiser(Request $request)
    {
        $micro = DB::table('v_micro_merch')->whereNotNull('micro_realisation')->orderBy('id_demande_client', 'desc');
        $hasFilters = false;
        $columns = ['nom_modele', 'nom_style', 'theme', 'nomtier', 'type_incontern','type_phase','type_saison','type_stade'];
        if ($request->search) {
            $searchTerm = $request->input('search');
            $micro->where(function($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
            $hasFilters = true;
        }

        if ($request->startdeadline && $request->enddeadline) {
            $micro->whereBetween('datecalcul', [$request->startdeadline, $request->enddeadline]);
            $hasFilters = true;
        }
        if ($request->startrealisation && $request->endrealisation) {
            $micro->whereBetween('micro_realisation', [$request->startrealisation, $request->endrealisation]);
            $hasFilters = true;
        }
        if ($request->startsemaine && $request->endsemaine) {
            $micro->whereIn('id_demande_client', function($query) use ($request) {
                $query->select('id_demande_client')
                      ->distinct()
                      ->from('v_filtre_micro')
                      ->where('semaine', '>=', $request->startsemaine)
                      ->where('semaine', '<=', $request->endsemaine)
                      ->orderBy('id_demande_client', 'desc');
            });
            $hasFilters = true;
        }
        if ($request->annee) {
            $micro->where('annee',$request->annee);
            $hasFilters = true;
        }
        if (!$hasFilters) {
            $micro->whereIn('id_demande_client', function($query) {
              $query->select('id_demande_client')
                    ->distinct()
                    ->from('v_micro_merch')
                    ->where('id_etat',2)
                    ->orderBy('id_demande_client','desc')
                    ->limit(100);
            })->orderBy('id_demande_client','desc');
        }
        $donne = $micro->get();
        return view('PLANNING.retromerch.microrealiser',compact('donne'));
    }



/*-----------------------------------------------------retro planning -----------------------------------------------------*/
    public function kanban(){
        Carbon::setLocale('fr'); // Définit la langue en français

        $datedebutinline = RetroPlanning::getMinDateInline();

        if ($datedebutinline) {
            $dateDebut = Carbon::parse($datedebutinline);
            $dateFin = $dateDebut->copy()->addMonths(2);
            $dates = [];
            $charges = [];
            $currentDate = $dateDebut->copy();
            while ($currentDate <= $dateFin) {
                // Format en français : "lundi : 19-sept"
                $dates[] = $currentDate->translatedFormat('l : d-m-Y');
                $charges[] = RetroPlanning::getChargeRetroPlaningByInline($currentDate);
                $currentDate->addDay();
            }
        } else {
            $dates = []; // Si la date de début est invalide
            $charges = [];
        }
        $chaines = RetroPlanning::getAllChaine();
        $donne = RetroPlanning::getRetroPlanning();
        $datenontravail = RetroPlanning::listeDateNonTravail();
        return view('PLANNING.retroplanning.retroplanning',compact('donne','dates','chaines','datenontravail','charges'));
    }
    public function ajoutRetroPlanning(Request $request){
        //drag
        $iddemandedrag = $request->input('dragged_id');
        $jourproddrag = $request->input('dragged_jourprod');
        $idchainedrag = $request->input('dragged_idchaine');
        //drop
        $iddemandedrop = $request->input('target_id');
        $idchainedrop = $request->input('target_idchaine');
        //if vide
            //chaine
        $chaine = $request->input('chaine_id');
        $chaine_id = RetroPlanning::getIdChaineByDesignation($chaine);
            //date
        $date_colonne = $request->input('target_column_name');
        $datePart = preg_replace('/^[a-zA-Z]+ : /', '', $date_colonne);
        $formattedDate = Carbon::createFromFormat('d-m-Y', $datePart)->format('Y-m-d');

        //fonction
        $retroPlanning = RetroPlanning::getRetroPlanningByIdDemande($iddemandedrag);
        if($idchainedrop!=null){
            $datedepartdrag = RetroPlanning::getFirstDateByIdDemande( $iddemandedrop);
            $retroPlaningByChaineAvant = RetroPlanning::getRetroPlaningByIdChaine($idchainedrop);
            $currentDate = Carbon::parse($datedepartdrag);
            for ($i = 0; $i < $jourproddrag; $i++) {
                // Sauter les week-ends
                while ($currentDate->isWeekend()) {
                    $currentDate->addDay();
                }
                RetroPlanning::where('id', $retroPlanning[$i]->id)
                    ->update([
                        'inlinechacun' => $currentDate->format('Y-m-d'),
                        'id_chaine' => $idchainedrop
                    ]);
                $currentDate->addDay();
            }
            $lastmodifierdate = RetroPlanning::getLasteDateByIdDemande($iddemandedrag);
            $nouveaudate = Carbon::parse($lastmodifierdate)->addDay();
            for ($l = 0; $l < count($retroPlaningByChaineAvant); $l++) {
                while ($nouveaudate->isWeekend()) {
                    $nouveaudate->addDay();
                }
                RetroPlanning::where('id', $retroPlaningByChaineAvant[$l]->id)
                    ->update([
                        'inlinechacun' => $nouveaudate
                    ]);
                $nouveaudate->addDay();
            }
        }
        else{
            $lastdragdate = RetroPlanning::getLasteDateByIdDemande($iddemandedrag);
            $alldonneinf = RetroPlanning::getRetroByDateStrict($lastdragdate,$idchainedrag);
            $datefirstdragchaine = RetroPlanning::getFirstDateByIdDemande($iddemandedrag);
            $datepremierdrag = Carbon::parse($datefirstdragchaine);
            if(count($alldonneinf)!=0){
            for($i=0;$i<count($alldonneinf);$i++){
                while ($datepremierdrag->isWeekend()) {
                    $datepremierdrag->addDay();
                }
                RetroPlanning::where('id', $alldonneinf[$i]->id)->update(['inlinechacun'=>$datepremierdrag]);
                $datepremierdrag = Carbon::parse($datepremierdrag)->addDay();
            }
            }
            $nouveau_date = Carbon::parse($formattedDate)->addDays($jourproddrag);
            $modele_entre_date = RetroPlanning::getEntreDeuxDateStrict($formattedDate,$nouveau_date,$chaine_id);
            $demande = RetroPlanning::getRetroPlanningByIdDemande($iddemandedrag);
            $datenouvelle = $formattedDate;
            $nouvelledate = Carbon::parse( $datenouvelle);
                for($i=0;$i<$jourproddrag;$i++){
                    while ($nouvelledate->isWeekend()) {
                        $nouvelledate->addDay();
                    }
                    RetroPlanning::where('id',$demande[$i]->id)->update(['inlinechacun'=>$nouvelledate,'id_chaine'=> $chaine_id]);
                    $nouvelledate = Carbon::parse($nouvelledate)->addDay();
                }
                $dateautre = $nouvelledate;
                if(count( $modele_entre_date)!=0){
                    $alldonnesuperrieur = RetroPlanning::getRetroByDate($modele_entre_date[0]->inlinechacun,$chaine_id);
                    for($i=0;$i<count($alldonnesuperrieur);$i++){
                        while ($dateautre->isWeekend()) {
                            $dateautre->addDay();
                        }
                        RetroPlanning::where('id', $alldonnesuperrieur[$i]->id)->update(['inlinechacun'=>$dateautre->format('Y-m-d')]);
                        $dateautre = Carbon::parse($dateautre)->addDays(1);
                    }
                }
        }
        return redirect()->route('PLANNING.retroplanning');
    }
    public function echangeRetroPlanning(Request $request){
        //drag
        $iddemandedrag = $request->input('dragged_id');
        $jourproddrag = $request->input('dragged_jourprod');
        $idchainedrag = $request->input('dragged_idchaine');
        $draginline = $request->input('drag_inline');
        //drop
        $iddemandedrop = $request->input('target_id');
        $idchainedrop = $request->input('target_idchaine');
        $jourproddrop = $request->input('target_jourprod');
        $dropinline = $request->input('target_inline');
        //fonction

        if($idchainedrag==$idchainedrop){
             $firstdatedrop = RetroPlanning::getFirstDateByIdDemande( $iddemandedrop);
             $firstdatedrag = RetroPlanning::getFirstDateByIdDemande( $iddemandedrag);

             $id_modele_avant = RetroPlanning::getIdByIdChaineAndIdDate(RetroPlanning::compareDateMinForId($firstdatedrop,$firstdatedrag),$idchainedrag);
             $id_modele_apres = RetroPlanning::getIdByIdChaineAndIdDate(RetroPlanning::compareDateMaxForId($firstdatedrop,$firstdatedrag),$idchainedrag);

             $firstdateMax = RetroPlanning::getFirstDateByIdDemande($id_modele_apres[0]->iddemandeclient);
             $lastdateMin = RetroPlanning::getLasteDateByIdDemande($id_modele_avant[0]->iddemandeclient);

            $entre_date = RetroPlanning::getEntreDeuxDateStrict($lastdateMin,$firstdateMax,$idchainedrag);

            $demandeMinApres = RetroPlanning::getRetroPlanningByIdDemandeByChaine($id_modele_apres[0]->iddemandeclient,$idchainedrag);
            $demandeMinAvant = RetroPlanning::getRetroPlanningByIdDemandeByChaine($id_modele_avant[0]->iddemandeclient,$idchainedrag);
            $firstdateMin = RetroPlanning::getFirstDateByIdDemande($id_modele_avant[0]->iddemandeclient);

            for($i=0; $i<count($demandeMinApres); $i++){
                RetroPlanning::where('id',$demandeMinApres[$i]->id)->update(['inlinechacun'=>$firstdateMin]);
                $firstdateMin = Carbon::parse($firstdateMin)->addDays(1);
            }

            $lastMinModifier = $firstdateMin;

            if(count($entre_date)!=0){
                for($i=0;$i<count($entre_date);$i++){
                    RetroPlanning::where('id',$entre_date[$i]->id)->update(['inlinechacun'=>$lastMinModifier]);
                    $lastMinModifier = Carbon::parse($lastMinModifier)->addDays(1);
                }
            }

            $lastDateEntreModifier = $lastMinModifier;
            for($i=0; $i<count($demandeMinAvant); $i++){
                RetroPlanning::where('id',$demandeMinAvant[$i]->id)->update(['inlinechacun'=>$lastDateEntreModifier]);
                $firstdateMin = Carbon::parse($lastDateEntreModifier)->addDays(1);
            }

        }
        return redirect()->route('PLANNING.retroplanning');
    }

    public function modifierDateDeTravail(Request $request){
        $date = $request->input('datechacun');
        $chaine = $request->input('chaines');
        foreach ($chaine as $index => $value) {
              // Display or process each selected chaine
              dd("Index: $chaine[$index]");
            // Destination::create([
            //     'idrecapcommande' => $idrecap,
            //     'numerocommande' => $champ1[$index] ?: '',
            //     'etdinitial' => $champ2[$index] ?: null,
            //     'datelivraisonexacte' => null,
            //     'dateinspection' => null,
            //     'qteof' => $champ3[$index] ?: 0,
            //     'iddeststd' => $champ4[$index]
            // ]);
        }
        dd($date);
    }

    public function ajoutCapaciteReel(Request $request){
        $inlinechacun = $request->input('inlinechacun');
        $iddataprod = $request->input('id_data_prod');
        $idchaine = $request->input('idchaine');
        $iddemande = $request->input('id_demande');
        $heuretravail = $request->input('heuretravail');
        $effectif = $request->input('effectif');
        $efficience = $request->input('efficience');
        $smvprods = $request->input('smv_prod');
        $smvfinitions = $request->input('smv_finition');
        $capacitereel = $request->input('capacitereel');
        $efficiencereel = round(($capacitereel * $smvprods) / ($effectif * $heuretravail * 60), 2);
        $capacite = ($efficience * $effectif * $heuretravail * 60) / ($smvprods + $smvfinitions);
        $lastedate = RetroPlanning::getLasteDateByIdDemande($iddemande);
        $entredate = RetroPlanning::getEntreDeuxDate($inlinechacun,$lastedate,$idchaine);
        //fonctionalite
        RetroPlanning::where('id',$entredate[0]->id)
            ->update(['capacitereel'=> $capacitereel,'heuretravail'=>$heuretravail,'effectif'=>$effectif,'efficiencereel'=>$efficiencereel]);
        $quantite = $request->input('quantite');

        $entredate = RetroPlanning::getEntreDeuxDate($inlinechacun,$lastedate,$idchaine);

        for($i=0;$i<count($entredate);$i++){
            RetroPlanning::where('id',$entredate[$i]->id)
            ->update(['qtereel'=> $quantite]);
        $quantite=$quantite-$entredate[$i]->capacitereel;

        }
        if ($capacite > $capacitereel) {
            $lastquantite = RetroPlanning::getLastQuantiteByIdDemande($iddemande);
            $capacite = RetroPlanning::getLastCapaciteByIdDemande($iddemande);
            if($lastquantite>$capacite){
                $datenouveauajout = Carbon::parse($lastedate)->addDay();
                $datenouveauajoutvrais = $datenouveauajout->copy(); // Cloner l'objet Carbon
                while ($datenouveauajoutvrais->isWeekend()) {
                    $datenouveauajoutvrais->addDay();
                }
                RetroPlanning::create([
                    'iddemandeclient' => $iddemande,
                    'id_data_prod' => $iddataprod,
                    'id_chaine' => $idchaine,
                    'inlinechacun' => $datenouveauajoutvrais,
                    'heuretravail' =>$request->session()->get('heuretravail'),
                    'efficience' => $request->session()->get('efficience'),
                    'efficiencereel' => 0,
                    'effectif' => $request->session()->get('effectif'),
                    'capacitereel' => $request->session()->get('capacite'),
                    'qtereel' => $capacite-$capacitereel,
                    'commentaire' => ""
                ]);
                $alldonnechainemodifier = RetroPlanning::getRetroByDateStrict(Carbon::parse($lastedate)->addDay(),$idchaine);
                $datenouveauajout = Carbon::parse($datenouveauajout)->addDay();
                $dateapresajout = $datenouveauajout;
                for($i=0;$i<count($alldonnechainemodifier);$i++){
                    while ($dateapresajout->isWeekend()) {
                        $dateapresajout->addDay();
                    }
                    RetroPlanning::where('id', $alldonnechainemodifier[$i]->id)
                    ->update([
                        'inlinechacun' => $dateapresajout,
                    ]);
                    $dateapresajout->addDay();
                }
            }
        }
        return redirect()->route('PLANNING.retroplanning');
    }

    public function ajoutDonne(Request $request){
        //parametre
        $inlinechacun = $request->input('inlinechacun');
        $idchaine = $request->input('idchaine');
        //donne
        $heuretravail = $request->input('heuretravail');
        $effectif = $request->input('effectif');
        $efficience = $request->input('efficience');
        RetroPlanning::where('id_chaine',$idchaine)
            ->where('inlinechacun',$inlinechacun)
            ->update(['heuretravail'=>$heuretravail,'effectif'=>$effectif,'efficience'=>$efficience]);
            return redirect()->route('PLANNING.retroplanning');
    }

    public function insertDateNonTravail(Request $request)
    {
        $dateSelection = $request->input('dateSelection');
        $chaines = $request->input('chaines');
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        RetroPlanning::deleteDateNonTravailByChaineDate($dateSelection);
        if($chaines!=null){
            for($i=0; $i<count($chaines); $i++){
                $dateNonTravail = new RetroPlanning();
                $dateNonTravail->insertNonTravail($dateActuelle, $dateSelection, $chaines[$i]);
            }
            $dateNouveau = Carbon::parse($dateSelection)->addDay();
            $dateCopie = $dateNouveau->copy();
            for ($j = 0; $j < count($chaines); $j++) {
                $retro = RetroPlanning::listeRetroPlanningByDateChaine($dateSelection, $chaines[$j]);
                for ($r = 0; $r < count($retro); $r++) {
                    // Boucle jusqu'à ce qu'on atteigne un jour ouvrable
                    while ($dateCopie->isWeekend()) {
                        $dateCopie->addDay();
                    }
                    RetroPlanning::where('id', $retro[$r]->id)
                        ->update([
                            'inlinechacun' => $dateCopie,
                        ]);

                    // Passe au jour suivant après avoir mis à jour
                    $dateCopie->addDay();

                    // Si le nouveau jour est encore un week-end, continue
                    while ($dateCopie->isWeekend()) {
                        $dateCopie->addDay();
                    }
                }
            }
        }
        return redirect()->route('PLANNING.retroplanning');
    }

/****************************************** MICRO PLANNING *******************************************/

    public function microplaning(){
        Carbon::setLocale('fr'); // Définit la langue en français

        $datedebutinline = PrintPlanning::getMinDateInlinePrint();

        if ($datedebutinline) {
            $dateDebut = Carbon::parse($datedebutinline);
            $dateFin = $dateDebut->copy()->addMonths(2);
            $dates = [];
            $charge = [];
            $currentDate = $dateDebut->copy();
            while ($currentDate <= $dateFin) {
                // Format en français : "lundi : 19-sept"
                $dates[] = $currentDate->translatedFormat('l : d-m-Y');
                $charge[] = PrintPlanning::getChargePrintPlaningByInline($currentDate);
                $currentDate->addDay();
            }
        } else {
            $dates = []; // Si la date de début est invalide
            $charge = [];
        }
        $donne = PrintPlanning::getPrintPlanning();
        return view('PLANNING.retroplanning.printplanning', compact('dates','donne','charge'));
    }
    public function bmplaning(){
        Carbon::setLocale('fr'); // Définit la langue en français


        $datedebutinline = BmPlanning::getMinDateInlineBm();

        if ($datedebutinline) {
            $dateDebut = Carbon::parse($datedebutinline);
            $dateFin = $dateDebut->copy()->addMonths(2);
            $dates = [];
            $charge = [];
            $currentDate = $dateDebut->copy();
            while ($currentDate <= $dateFin) {
                // Format en français : "lundi : 19-sept"
                $dates[] = $currentDate->translatedFormat('l : d-m-Y');
                $charge[] = BmPlanning::getChargeBmPlaningByInline($currentDate);
                $currentDate->addDay();
            }
        } else {
            $dates = []; // Si la date de début est invalide
            $charge = [];
        }
        $donne = BmPlanning::getBmPlanning();
        return view('PLANNING.retroplanning.broadMain', compact('dates','donne','charge'));
    }
    public function bmcplaning(){
        Carbon::setLocale('fr'); // Définit la langue en français

        $datedebutinline = BmcPlanning::getMinDateInlineBmc();

        if ($datedebutinline) {
            $dateDebut = Carbon::parse($datedebutinline);
            $dateFin = $dateDebut->copy()->addMonths(2);
            $dates = [];
            $charge = [];
            $currentDate = $dateDebut->copy();
            while ($currentDate <= $dateFin) {
                // Format en français : "lundi : 19-sept"
                $dates[] = $currentDate->translatedFormat('l : d-m-Y');
                $charge[] = BmcPlanning::getChargeBmcPlaningByInline($currentDate);
                $currentDate->addDay();
            }
        } else {
            $dates = []; // Si la date de début est invalide
            $charge = [];
        }
        $donne = BmcPlanning::getBmcPlanning();
        return view('PLANNING.retroplanning.broadMachine', compact('dates','charge','donne'));
    }
    public function lbtplaning(){
        Carbon::setLocale('fr'); // Définit la langue en français

        $datedebutinline = RetroPlanning::getMinDateInline();

        if ($datedebutinline) {
            $dateDebut = Carbon::parse($datedebutinline);
            $dateFin = $dateDebut->copy()->addMonths(2);
            $dates = [];
            $currentDate = $dateDebut->copy();
            while ($currentDate <= $dateFin) {
                // Format en français : "lundi : 19-sept"
                $dates[] = $currentDate->translatedFormat('l : d-m-Y');
                $currentDate->addDay();
            }
        } else {
            $dates = []; // Si la date de début est invalide
        }
        return view('PLANNING.retroplanning.lbt', compact('dates'));
    }
    public function updateDatePrint(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:print_planning,id',
            'date' => 'required|date',
        ]);

        $planning = PrintPlanning::find($validated['id']);
        $planning->inlinechacun = $validated['date']; // Mettre à jour la date
        $planning->save();

        return response()->json(['message' => 'Date mise à jour avec succès.']);
    }
    public function updateDateBrodMain(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:bm_planning,id',
            'date' => 'required|date',
        ]);

        $planning = BmPlanning::find($validated['id']);
        $planning->inlinechacun = $validated['date']; // Mettre à jour la date
        $planning->save();

        return response()->json(['message' => 'Date mise à jour avec succès.']);
    }

}

