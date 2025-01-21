<?php

namespace App\Http\Controllers;

use App\Models\BonCommande;
use App\Models\DemandeClient;
use App\Models\Tiers;
use App\Models\V_accessoire;
use App\Models\V_detail_reclamation;
use App\Models\V_donne_bc;
use App\Models\V_tissus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ControllerBc extends Controller
{

    public function bc(Request $request)
    {
        $iddemande = $request->session()->get('idDemande');
        $allbc = BonCommande::getAllDonneBcById($iddemande);
        return view('CRM.bc.bc', compact('allbc'));
    }
    public function ajoutBc(Request $request,$idbc)
    {
        $typebc = BonCommande::getAllTypeBc();
        $fournisseur = Tiers::getAllTiersByIdActeur();
        $client = DemandeClient::getAllListeDemande();
        $numero = BonCommande::getNumeroBcById($idbc);
        $typebcbyid = BonCommande::getTypeBcById($idbc);
        $allbc = BonCommande::getAllBc();
        $attn = BonCommande::getInterlocateurFournisseur();
        $iddemande = BonCommande::getLastIdDemande();
        $demande = [];
        for ($i=0; $i <count($iddemande) ; $i++) {
            $demande[] = BonCommande::getClientByDetail($iddemande[$i]->id_demande_client);
        }
        return view('CRM.bc.ajoutBc',compact('fournisseur','client','numero','typebc','typebcbyid','idbc','allbc','attn','demande'));
    }
    public function insertBc(Request $request){
        $datebc = $request->input('dateBc');
        $numero = $request->input('numero');
        $fournisseur = $request->input('fournisseur');
        $echeance = $request->input('echeance');
        $idbc = $request->input('idbc');
        BonCommande::insertBc($datebc,$numero,$idbc,$fournisseur,$echeance);
        $nombre = $request->input('totalClients');
        if($nombre==0){
            BonCommande::insertDetailBc($request->input('nomClient0'));
        }
        if($nombre!=0){
            for($i=0;$i<=$nombre-1;$i++){
                BonCommande::insertDetailBc($request->input('nomClient'.$i));
            }
        }

        $accessoire = V_accessoire::getAllV_accessoireByDC($request->input('nomClient0'));
        $tissus = V_tissus::getAllV_tissu($request->input('nomClient0'));
        session()->forget('detaildonne');
        session()->put('tissus',$tissus);
        session()->put('accessoire',$accessoire);
        return redirect()->route('CRM.ajoutBc', ['idbc' => $idbc]);
    }

    public function ajoutBcTissus(Request $request){
        $idbc = $request->input('idbc');
        $idtissus = $request->input('idtissus');
        $idaccessoire = $request->input('idaccessoire');
        $numero = $request->input('numero_bc');
        $index = $request->input('idtissus');
        $zindex = $request->input('idaccessoire');
        $detail = BonCommande::getDetailByIdBc();
        if($idbc==1 || $idbc==3){
            $designation = $request->input('designation'.$index); // Exemple si tu as un name='designation'
            $laizeUtile = $request->input('laize_utile'.$index);
            $couleur = $request->input('couleur'.$index);
            $quantite = $request->input('quantite'.$index);
            $uniteMesure = $request->input('unite_mesure'.$index);
            $unite = $request->input('unite'.$index);
            $pri = $request->input('pri'.$index);
            for ($i=0; $i < count($detail) ; $i++) {
                BonCommande::insertDonneBcTissus($detail[$i]->id,$designation,$laizeUtile,0,$couleur,$quantite,$uniteMesure,$pri,$unite,$idtissus,$numero);
            }
        }
        if($idbc==2){
            $designation = $request->input('designation'.$zindex); // Exemple si tu as un name='designation'
            $utilisation = $request->input('utilisation'.$zindex);
            $couleur = $request->input('couleur'.$zindex);
            $quantite = $request->input('quantite'.$zindex);
            $uniteMesure = $request->input('unite_mesure'.$zindex);
            $unite = $request->input('unite'.$zindex);
            $pri = $request->input('pri'.$zindex);
            for ($i=0; $i < count($detail) ; $i++) {
                BonCommande::insertDonneBcAccessoire($detail[$i]->id,$designation,0,$utilisation,$couleur,$quantite,$uniteMesure,$pri,$unite,$idaccessoire,$numero);
            }
        }

        $detaildonne = BonCommande::getDonne();
        session()->put('detaildonne',$detaildonne);
        return redirect()->route('CRM.ajoutBc', ['idbc' => $idbc]);
    }
    public function deleteBc(Request $request){
        $idbc = $request->input('idbc');
        $iddonnebc = $request->input('iddonnebc');
            BonCommande::deleteDonne($iddonnebc);

        return redirect()->route('CRM.ajoutBc', ['idbc' => $idbc]);
    }

    public function ajoutBcGeneral(){
        $typebc = BonCommande::getAllTypeBc();
        $fournisseur = Tiers::getAllTiersByIdActeur();
        $numero = BonCommande::getNumeroGeneral();
        return view('CRM.bc.bcGeneral',compact('fournisseur','numero','typebc'));
    }

    public function tscfCoupeType(Request $request){

        $donnes = V_donne_bc::query()
        ->where('etat', 10)
        ->where('idtypebc',3)
         ->orderBy('id_donne_bc', 'desc');


    $columns = ['type_bc', 'type_saison', 'nom_modele', 'client', 'fournisseur','des_tissus','ref_tissus','des_accessoire','ref_accessoire'];

    if ($request->search) {
        $searchTerm = $request->input('search');
        $donnes->where(function($query) use ($columns, $searchTerm) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
            }
        });
    }
    if ($request->startDeadline && $request->endDeadline) {
        $donnes->when($donnes->first()->deadline == 0, function($query) use ($request) {
            // Si 'deadline' est égale à 0, on utilise 'echeance'
            return $query->whereBetween('echeance', [$request->startDeadline, $request->endDeadline]);
        }, function($query) use ($request) {
            // Sinon, on utilise 'deadline'
            return $query->whereBetween('deadline', [$request->startDeadline, $request->endDeadline]);
        });
    }
    if ($request->startEmmission && $request->endEmmission) {
        $donnes->whereBetween('date_bc', [$request->startEmmission, $request->endEmmission]);
    }

    if ($request->idetatbc) {
        // Si idetatbc == 1, on ajoute la condition sur 'datearrive' et 'deadline'
        if ($request->input('idetatbc') == 1) {
            $donnes->where(function($query) {
                $query->where(function($subQuery) {
                    $subQuery->whereNull('datearrive')  // Vérifie si datearrive est NULL
                             ->where('echeance', '>=', now()); // Comparaison avec la date actuelle
                })->orWhere(function($subQuery) {
                    $subQuery->whereNotNull('datearrive') // Vérifie si datearrive n'est pas NULL
                             ->where('datearrive', '>=', now()); // Comparaison avec la date actuelle
                });
            });
        }



        if ($request->input('idetatbc') == 2) {
            $donnes->where(function($query) {
                $query->where('reste', '>', 0)
                      ->where('magasin_quantite', '>', 0);
            });
        }

        if ($request->input('idetatbc') == 3) {
            $donnes->where(function($query) {
                $query->where('reste', '=', 0);
            });
        }

        if ($request->input('idetatbc') == 4) {
            $donnes->where(function($query) {
                $query->where(function($subQuery) {
                    $subQuery->whereNull('datearrive')  // Vérifie si datearrive est NULL
                             ->where('echeance', '<', now()); // Comparaison avec la date actuelle
                })->orWhere(function($subQuery) {
                    $subQuery->whereNotNull('datearrive') // Vérifie si datearrive n'est pas NULL
                             ->where('datearrive', '<', now()); // Comparaison avec la date actuelle
                });
            });
        }

        if ($request->input('idetatbc') == 5) {
            $donnes->where('raison', '!=', 0);
        }

        if ($request->input('idetatbc') == 6) {
            $donnes->where(function($query) {
                $query->where('deposit', '=', 0)
                      ->where('payer', '<', 1);
            });
        }

        if ($request->input('idetatbc') == 7) {
            $donnes->where(function($query) {
                $query->where('deposit', '>', 0)
                      ->where('payer', '<', 1);
            });
        }

        if ($request->input('idetatbc') == 8) {
            $donnes->where(function($query) {
                $query->where('deposit', '>', 0)
                      ->where('payer', '>=', 1);
            });
        }

    }


    // Récupérer les résultats après application de tous les filtres
    $donne = $donnes->get();
    $etat = BonCommande::getAllEtatBc();
        $today = Carbon::now()->format('Y-m-d');
        $typebc = BonCommande::getAllTypeBc();
        // $donne = BonCommande::getAllDonneTscfBcValide();
        $coupe = BonCommande::getAllTscfCoupeType();
        return view('CRM.bc.tscfCoupeType',compact('typebc','coupe','donne','today','etat'));
    }

    public function revisiterBc(Request $request){
        $idbc = $request->input('idbc');
        $idtier = $request->input('idTier');
        $idtypebc = $request->input('idtypebc');
        $numero = $request->input('numero');
        $designation = $request->input('designation');
        $couleur = $request->input('couleur');
        $laize = $request->input('laize');
        $utilisation = $request->input('utilisation');
        $quantite = $request->input('quantite');
        $unite = $request->input('unite');
        $prix_unitaire = $request->input('prix_unitaire');
        $devise = $request->input('devise');

        if ($idtypebc==1) {
            if (strpos($numero, 'Tissu_revised') === false) {
                $numerotissus = str_replace('Tissu', 'Tissu_revised', $numero);
            } else {
                $numerotissus = $numero;
            }
            BonCommande::revisiterTissus($designation,$couleur,$laize,$quantite,$unite,$prix_unitaire,$devise,$idbc);
            BonCommande::revisiterNumero($numerotissus,$idbc);
        }
        if ($idtypebc==3) {
            if (strpos($numero, 'CoupeType_revised') === false) {
                $numerocoupe = str_replace('CoupeType','CoupeType_revised', $numero);
            } else {
                $numerocoupe = $numero;
            }
            BonCommande::revisiterTissus($designation,$couleur,$laize,$quantite,$unite,$prix_unitaire,$devise,$idbc);
            BonCommande::revisiterNumero($numerocoupe,$idbc);
        }
        if ($idtypebc==2) {
            if (strpos($numero, 'Accessoire_revised') === false) {
                $numeroacc = str_replace('Accessoire','Accessoire_revised',$numero);
            } else {
                $numeroacc = $numero;
            }
            BonCommande::revisiterAccessoire($designation,$couleur,$utilisation,$quantite,$unite,$prix_unitaire,$devise,$idbc);
            BonCommande::revisiterNumero($numeroacc,$idbc);
        }
        return redirect()->route('CRM.detailBc', ['idBc' => $idbc,'idTier' =>$idtier,'prixunitaire' =>$prix_unitaire]);
    }
    public function detailBc(Request $request){
        $idbc = $request->input('idBc');
        $idtier = $request->input('idTier');
        $prix_unitaire = $request->input('prixunitaire');
        $typebc = BonCommande::getAllTypeBc();
        $produit = BonCommande::getProduitById($idbc);
        $merch = BonCommande::getMerch($idbc);
        $transite = BonCommande::getTransit($idbc);
        $magasin = BonCommande::getMagasin($idbc);
        $reclamation = BonCommande::getReclamation($idbc);
        $compta = BonCommande::getCompta($idbc);
        $attn = Tiers::getInterlocateurById($idtier);
        return view('CRM.bc.detailbc',compact('typebc','produit','merch','transite','magasin','reclamation','compta','attn','prix_unitaire'));
    }
    public function merch(Request $request){
        $idbc = $request->input('idbc');
        $idtier = $request->input('idtier');
        $dateEx = $request->input('dateex'); // Date Ex-Usine Fournisseur
        $echeance = $request->input('echeance'); // Deadline Arrivee Usine
        $modeTransport = $request->input('modeTransport'); // Mode de Transport
        $dateFacture = $request->input('dateFacture'); // Date Emmission Facture
        $numeroFacture = $request->input('numeroFacture'); // Numéro de Facture
        $montantFacture = $request->input('montantFacture'); // Montant de la Facture
        $detailsFacture = $request->input('detailsFacture'); // Détails de la Facture
        $commentaireFacturation = $request->input('commentaireFacturation'); // Commentaire
        BonCommande::insertMerch($idbc,$dateEx,$echeance,$modeTransport,$dateFacture,$numeroFacture,$montantFacture,$detailsFacture,$commentaireFacturation);

        return redirect()->route('CRM.detailBc', ['idBc' => $idbc,'idTier' =>$idtier]);
    }
    public function transit(Request $request){
        $idbc = $request->input('idbc');
        $idtier = $request->input('idtier');
        $transit = $request->input('Transit'); // Transit
        $transitTime = $request->input('TransitTime'); // Transit Time
        $dateDepart = $request->input('dateDepart'); // Date de Départ
        $dateArrive = $request->input('dateArrive'); // Date d'Arrivée Import Prévue
        $awb = $request->input('awb'); // AWB/BL
        BonCommande::insertTransit($idbc,$transit,$transitTime,$dateDepart,$dateArrive,$awb);

        return redirect()->route('CRM.detailBc', ['idBc' => $idbc,'idTier' =>$idtier]);
    }
    public function magasin(Request $request){
        $idbc = $request->input('idbc');
        $idtier = $request->input('idtier');
        $dateArrive = $request->input('Transit'); // Date d'Arrivée Réelle Usine
        $bl = $request->input('bl'); // BL N°
        $quantite = $request->input('quantite'); // Quantité à livrer
        $reste = $request->input('reste'); // Reste à livrer
        $facture = $request->input('facture'); // N° Facture
        BonCommande::insertMagasin($idbc,$dateArrive,$bl,$quantite,$reste,$facture);

        return redirect()->route('CRM.detailBc', ['idBc' => $idbc,'idTier' =>$idtier]);
    }
    public function reclamation(Request $request){
        $request->validate([
            'logo' => 'mimes:pdf|max:10000',
        ]);

        $idbc = $request->input('idbc');
        $idtier = $request->input('idtier');
        $date1 = $request->input('date1'); // Date Envoie Réclamation
        $date2 = $request->input('date2'); // Date Relance
        $raison = $request->input('raison'); // Raison de Réclamation
        $dateFacture = $request->input('dateFacture'); // Quantité Concernée
        $numeroFacture = $request->input('numeroFacture'); // Défaut/Remarque
        $montantFacture = $request->input('montantFacture'); // Retour Fournisseur
        $detailsFacture = $request->input('detailsFacture'); // Récompensation
        $commentaireFacturation = $request->input('commentaireFacturation'); // Note de Crédit

        $prix_unitaire = $request->input('prixunitaire');
        $imageBase64 = "";
        if ($request->hasFile('logo')) {
            $photo = $request->file('logo');
            $imageBase64 = base64_encode(file_get_contents($photo->getRealPath()));
        }
        $unite =$request->input('unite');
        $valeurreclame =  $dateFacture*$prix_unitaire;
        if($unite=="Prix"){$valeurcompense = $detailsFacture;}
        if($unite=="Unite"){$valeurcompense = $detailsFacture*$prix_unitaire;}
        $reste =$valeurreclame-$valeurcompense;
        if($reste<0){
            $reste=0;
        }

        BonCommande::insertReclamation($idbc,$date1,$date2,$raison,$dateFacture,$numeroFacture,$montantFacture,$detailsFacture,$commentaireFacturation,$unite,$imageBase64,$valeurreclame,$valeurcompense,$reste);

        return redirect()->route('CRM.detailBc', ['idBc' => $idbc,'idTier' =>$idtier,'prixunitaire'=>$prix_unitaire]);
    }
    public function compta(Request $request){
        $idbc = $request->input('idbc');
        $idtier = $request->input('idtier');
        $transitDate = $request->input('Transit'); // Swift (Date)
        $bl = $request->input('bl'); // Deposit (Formule(30%))
        $quantite = $request->input('quantite'); // Prix BC
        $facture = $request->input('facture'); // % Payer
        if ($quantite==0) {
            $payer = 0;
        }
        if ($quantite!=0) {
            $payer = $bl/$quantite;
        }
        BonCommande::insertComptabilite($idbc,$transitDate,$bl,$quantite,$payer);

        return redirect()->route('CRM.detailBc', ['idBc' => $idbc,'idTier' =>$idtier]);
    }
    public function tableauDeBordTscf(){
        return view('CRM.bc.tableauDeBord');
    }

    public function nouvelleBc(Request $request)
    {

        $donnes = V_donne_bc::query()
        ->where('etat', 10)
        ->where('idtypebc', '!=',3)
         ->orderBy('id_donne_bc', 'desc');


    $columns = ['type_bc', 'type_saison', 'nom_modele', 'client', 'fournisseur','des_tissus','ref_tissus','des_accessoire','ref_accessoire'];

    if ($request->search) {
        $searchTerm = $request->input('search');
        $donnes->where(function($query) use ($columns, $searchTerm) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
            }
        });
    }
    if ($request->startDeadline && $request->endDeadline) {
        $donnes->when($donnes->first()->deadline == 0, function($query) use ($request) {
            // Si 'deadline' est égale à 0, on utilise 'echeance'
            return $query->whereBetween('echeance', [$request->startDeadline, $request->endDeadline]);
        }, function($query) use ($request) {
            // Sinon, on utilise 'deadline'
            return $query->whereBetween('deadline', [$request->startDeadline, $request->endDeadline]);
        });
    }
    if ($request->startEmmission && $request->endEmmission) {
        $donnes->whereBetween('date_bc', [$request->startEmmission, $request->endEmmission]);
    }

    if ($request->idetatbc) {
        // Si idetatbc == 1, on ajoute la condition sur 'datearrive' et 'deadline'
        if ($request->input('idetatbc') == 1) {
            $donnes->where(function($query) {
                $query->where(function($subQuery) {
                    $subQuery->whereNull('datearrive')  // Vérifie si datearrive est NULL
                             ->where('echeance', '>=', now()); // Comparaison avec la date actuelle
                })->orWhere(function($subQuery) {
                    $subQuery->whereNotNull('datearrive') // Vérifie si datearrive n'est pas NULL
                             ->where('datearrive', '>=', now()); // Comparaison avec la date actuelle
                });
            });
        }



        if ($request->input('idetatbc') == 2) {
            $donnes->where(function($query) {
                $query->where('reste', '>', 0)
                      ->where('magasin_quantite', '>', 0);
            });
        }

        if ($request->input('idetatbc') == 3) {
            $donnes->where(function($query) {
                $query->where('reste', '=', 0);
            });
        }

        if ($request->input('idetatbc') == 4) {
            $donnes->where(function($query) {
                $query->where(function($subQuery) {
                    $subQuery->whereNull('datearrive')  // Vérifie si datearrive est NULL
                             ->where('echeance', '<', now()); // Comparaison avec la date actuelle
                })->orWhere(function($subQuery) {
                    $subQuery->whereNotNull('datearrive') // Vérifie si datearrive n'est pas NULL
                             ->where('datearrive', '<', now()); // Comparaison avec la date actuelle
                });
            });
        }

        if ($request->input('idetatbc') == 5) {
            $donnes->where('raison', '!=', 0);
        }

        if ($request->input('idetatbc') == 6) {
            $donnes->where(function($query) {
                $query->where('deposit', '=', 0)
                      ->where('payer', '<', 1);
            });
        }

        if ($request->input('idetatbc') == 7) {
            $donnes->where(function($query) {
                $query->where('deposit', '>', 0)
                      ->where('payer', '<', 1);
            });
        }

        if ($request->input('idetatbc') == 8) {
            $donnes->where(function($query) {
                $query->where('deposit', '>', 0)
                      ->where('payer', '>=', 1);
            });
        }

    }


    // Récupérer les résultats après application de tous les filtres
    $donne = $donnes->get();


        $today = Carbon::now()->format('Y-m-d');
        $typebc = BonCommande::getAllTypeBc();
        // $donne = BonCommande::getAllDonneBcValide(   );
        $tscf = BonCommande::getTscf();
        $etat = BonCommande::getAllEtatBc();
        return view('CRM.bc.nouvelleBc',compact('typebc','donne','today','tscf','etat'));
    }


    public function bcapercu(Request $request,$id,$idtier)
    {
        $donne = BonCommande::getDonneByIdBc($id);
        $interloc = Tiers::getInterlocateurById($idtier);
        return view('CRM.bc.bcApercu',compact('donne','interloc'));
    }

    public function validerBc(Request $request)
    {
        $idbc = $request->input('idbc');
        $iddetail = BonCommande::getIdDetail($idbc);
        for ($i=0; $i <count($iddetail) ; $i++) {
            BonCommande::dateConfirmation($iddetail[$i]->id);
            BonCommande::valideBc($iddetail[$i]->id);
        }
        return redirect()->route('CRM.bc');
    }
    public function retourListeTscf(Request $request){
        $id = $request->input('coupe');
        if($id==3){
            return redirect()->route('CRM.tscfCoupeType');
        }
        if($id!=3){
            return redirect()->route('CRM.nouvelleBc');
        }

    }

    public function detailreclamation(Request $request){
        $typebc = BonCommande::getAllTypeBc();
        $detailbc = V_detail_reclamation::get();
        $nombre = $detailbc->count();
        $valeurreclame = $detailbc->sum('total_valeurreclame');
        $reste = $detailbc->sum('total_reste');
        $qte = $detailbc->sum('total_quantite');
        $compense = $detailbc->sum('total_valeurcompense');
        return view('CRM.bc.detailreclamation',compact('typebc','detailbc','nombre','compense','qte','reste','valeurreclame'));
    }
    public function chartreclamation(Request $request){
        $typebc = BonCommande::getAllTypeBc();
        $prix = DB::table('v_detail_reclamation')
        ->select(
            'nomtier',
            DB::raw('SUM(total_valeurreclame) AS total_valeurreclame'),
            DB::raw('SUM(total_recompensation) AS total_recompensation'),
            DB::raw('SUM(total_quantite) AS total_quantite'),
            DB::raw('SUM(total_valeurcompense) AS total_valeurcompense'),
            DB::raw('SUM(total_reste) AS total_reste')
        )
        ->groupBy('nomtier')
        ->orderByDesc(DB::raw('SUM(total_reste)'))
        ->get();

        $nombre = DB::table('v_detail_reclamation')
            ->select(
                'nomtier',
                DB::raw('COUNT(donne_bc_id) AS nombre_nomtier'),
                DB::raw('SUM(total_valeurreclame) AS total_valeurreclame'),
                DB::raw('SUM(total_recompensation) AS total_recompensation'),
                DB::raw('SUM(total_quantite) AS total_quantite'),
                DB::raw('SUM(total_valeurcompense) AS total_valeurcompense'),
                DB::raw('SUM(total_reste) AS total_reste')
            )
            ->groupBy('nomtier')
            ->orderByDesc(DB::raw('COUNT(donne_bc_id)')) // Tri selon nombre_nomtier
            ->get();

        $detailbc = V_detail_reclamation::get();
        $nombres = $detailbc->count();
        $valeurreclame = $detailbc->sum('total_valeurreclame');
        $reste = $detailbc->sum('total_reste');
        $qte = $detailbc->sum('total_quantite');
        $compense = $detailbc->sum('total_valeurcompense');

        $nombrefournisseur = DB::table('v_detail_reclamation')
        ->selectRaw('COUNT(*) OVER() AS nbrfournisseur')
        ->groupBy('nomtier')
        ->get();
        return view('CRM.bc.chartreclamation',compact('typebc','prix','nombre','nombres','compense','qte','reste','valeurreclame','nombrefournisseur'));
    }
    public function historiqueReclamation(Request $request){
        $iddonnebc = $request->input('idDonneBc');
        $donnehistorique = V_detail_reclamation::getHistoriqueById($iddonnebc);
        $typebc = BonCommande::getAllTypeBc();
        return view('CRM.bc.historiqueReclamation',compact('donnehistorique','typebc'));
    }
}
