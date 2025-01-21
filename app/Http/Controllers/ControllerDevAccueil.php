<?php

namespace App\Http\Controllers;

use App\Models\BureauEtude;
use App\Models\CaracteristiqueTissu;
use App\Models\ConsoAccessoire;
use App\Models\ConsoTissus;
use App\Models\DemandeClient;
use App\Models\DispositionMatierePremiere;
use App\Models\FicheCoupe;
use App\Models\Lavage;
use App\Models\ListeEmploye;
use App\Models\Planning;
use App\Models\Sdc;
use App\Models\StadeDemandeClient;
use App\Models\SuiviDEV;
use App\Models\Tiers;
use App\Models\V_accessoire;
use App\Models\V_tissus;
use App\Models\ValeurAjoute;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerDevAccueil extends Controller
{
    public function accueil(Request $request)
    {
        $demande = Planning::getAllDemandeClientSDCEtapeDevLimit();
        $idSaison = '';
        $modele = '';
        $idTiers = '';
        $idStyle = '';
        $patronier = '';
        $dateDebut = '';
        $dateFin = '';
        $nomSaison = '';
        $nomTiers = '';
        $nomStyle = '';
        $nomEmploye = '';
        $nomStade = '';
        $idStade = '';
        $nbCommande= Planning::nombreCommande();
        $nbCommande = $nbCommande[0]->nombre;
        return view('DEV.accueil', compact('nbCommande','idTiers', 'idStyle', 'idSaison', 'modele', 'idTiers', 'patronier', 'dateDebut', 'dateFin', 'nomSaison', 'nomTiers', 'nomStyle', 'nomEmploye', 'nomStade', 'idStade', 'demande'));
    }

    public function rechercheAccueil(Request $request)
    {

        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $idTiers = $request->input('idTiers');
        $idStyle = $request->input('idStyle');
        $patronier = $request->input('patronier');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $nomSaison = $request->input('nomSaison');
        $nomTiers = $request->input('nomTiers');
        $nomStyle = $request->input('nomStyle');
        $nomEmploye = $request->input('nomEmploye');
        $nomStade = $request->input('nomStade');
        $idStade = $request->input('idStade');
        $condition = "";
        if (empty($nomSaison)) {
            $idSaison = "";
        }

        if (empty($nomTiers)) {
            $idTiers = "";
        }

        if (empty($nomStyle)) {
            $idStyle = "";
        }

        if (empty($nomEmploye)) {
            $patronier = "";
        }

        if (empty($nomStade)) {
            $idStade = "";
        }

        if (!empty($idSaison)) {
            $condition = " and id_saison=" . $idSaison;
        }
        if (!empty($idStade)) {
            $condition = " and stadesdc='" . $idStade . "'";
        }
        if (!empty($modele)) {
            $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition = $condition . " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition = $condition . " and id_style=" . $idStyle;
        }
        if (!empty($patronier)) {
            $condition = $condition . " and idlisteemploye=" . $patronier;
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and DATE(deadlinedemandeclient) between '" . $dateDebut . "' and '" . $dateFin . "'";
        }

        if (!empty($dateDebut) && empty($dateFin)) {
            $condition = $condition . " and DATE(deadlinedemandeclient) between '" . $dateDebut . "' and '" . $dateDebut . "'";
        }
        $demande = Planning::getAllDemandeClientSDCEtapeDevRecherche($condition);
        $nbCommande = count($demande);
        return view('DEV.accueil', compact('nbCommande','idTiers', 'idStyle', 'idSaison', 'modele', 'idTiers', 'patronier', 'dateDebut', 'dateFin', 'nomSaison', 'nomTiers', 'nomStyle', 'nomEmploye', 'nomStade', 'idStade', 'demande'));
    }
    public function detailDemandeClient(Request $request)
    {
        $idDemande = $request->input('idDemande');
        $request->session()->put('idDemande', $idDemande);
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        $lavage = Lavage::getAllLavageDemandeById($idDemande);
        $valeur = ValeurAjoute::getAllValeurDemandeById($idDemande);
        $tailles = DemandeClient::getTailleByIdDemande($idDemande);
        $dossiertech = DemandeClient::getDossierTechniqueById($idDemande);
        return view('DEV.detailDemandeClient', compact('tailles', 'demande', 'lavage', 'valeur', 'dossiertech'));
    }

    public function matierePremiere(Request $request)
    {
        $idDC = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $listeTissu = V_tissus::getAllV_tissu($idDC);
        $listeAcc = V_accessoire::getAllV_accessoireByDC($idDC);
        return view('DEV.matierePremiereDemandeClient', compact('listeTissu', 'demande', 'listeAcc'));
    }

    public function detailTissu(Request $request)
    {
        $id = $request->input('idTissus') ?? session('idTissus');
        $listeTissu = V_tissus::getAllV_tissuById($id);
        return view('DEV.detailTissu', compact('listeTissu'));
    }

    public function detailAccessoire(Request $request)
    {
        $id = $request->input('idAcc') ?? session('idAcc');
        $listeAcc = V_accessoire::getAllV_accessoireById($id);
        return view('DEV.detailAccessoire', compact('listeAcc'));
    }

    public function sdc(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $stades = StadeDemandeClient::all();

        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        return view('DEV.sdc', compact('demande', 'stades'));
    }

    public function sdcApercue(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $detaildemande = DemandeClient::getAllListeDemandeById($idDemande);
        $sdc = Sdc::where('id_demande_client', $idDemande)->first();
        $idsdc = Sdc::getLastIdSdcByIdDemande($idDemande);
        $detailsdc = Sdc::getDetailSdcById($idsdc);
        $dispomat = Sdc::getDispoMatierePremiere();
        $tissus = V_tissus::getAllV_tissu($idDemande);
        $accessoire = V_accessoire::getAllV_accessoireSansFinition($idDemande);
        $lavage = DemandeClient::getLavageByIdDemande($idDemande);
        $valeur = DemandeClient::getValeurAjoutByIdDemande($idDemande);
        $tier = Tiers::getAllTierByIdTier($detaildemande[0]->id_tiers);
        return view('DEV.sdcApercu', compact('tier', 'detaildemande', 'sdc', 'detailsdc', 'dispomat', 'tissus', 'accessoire', 'valeur', 'lavage'));
    }

    public function fdc(Request $request)
    {
        $idDC = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        return view('DEV.fdcDEV', compact('demande'));
    }

    public function fdcApercu(Request $request)
    {
        $idDC =  $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $tissu = V_tissus::getAllV_tissu($idDC);
        $dispo = DispositionMatierePremiere::getAllDispoMP();
        $accessoire = V_accessoire::getAllV_accessoireByDC($idDC);
        $consoTissu = ConsoTissus::getAllConsoTissuByTissu();
        $detailTaille = DemandeClient::getTailleByIdDemande($idDC);
        $consoAccy = ConsoAccessoire::getAllConsoAccyByDC($idDC);
        $caracteristique = CaracteristiqueTissu::getAllCaracteristiqueTissu();
        $tier = Tiers::getAllTierByIdTier($demande[0]->id_tiers);
        return view('DEV.fdcApercuDEV', compact('tier', 'idDC', 'caracteristique', 'consoAccy', 'accessoire', 'detailTaille', 'demande', 'tissu', 'dispo', 'consoTissu'));
    }

    public function ficheCoupe(Request $request)
    {
        $idDC = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $fiche = FicheCoupe::getFicheCoupeByDC($idDC);
        return view('DEV.ficheCoupe', compact('demande', 'fiche'));
    }

    public function suiviPatronage(Request $request)
    {
        $patronage = SuiviDEV::getAllSuiviPatronage();
        $primeP = BureauEtude::getAllPrimePatronier();
        $idSaison = '';
        $modele = '';
        $idTiers = '';
        $idStyle = '';
        $patronier = '';
        $dateDebut = '';
        $dateFin = '';
        $nomSaison = '';
        $nomTiers = '';
        $nomStyle = '';
        $nomEmploye = '';
        $results = DB::select("
        select sum(pointpatronage) as total_quantite from v_suivipatronage");
        $nbrPoints = $results[0]->total_quantite ?? 0;

        $nbrModele = count($patronage);

        $primePatronier = BureauEtude::getPrimePatronierByPoints($nbrPoints);
        $prime = $primePatronier[0]->prime;
        $result = DB::select("
        select count(*) as total from v_suivipatronage where deadline<datefin");
        $retard = $result[0]->total ?? 0;
        return view('DEV.PLANNING.suiviPatronage', compact('retard', 'prime', 'nbrPoints', 'nbrModele', 'nomEmploye', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'patronier', 'idStyle', 'idTiers', 'modele', 'idSaison', 'patronage'));
    }

    public function suiviConso(Request $request)
    {
        $conso = SuiviDEV::getAllSuiviConso();
        $idSaison = '';
        $modele = '';
        $idTiers = '';
        $idStyle = '';
        $dateDebut = '';
        $dateFin = '';
        $nomSaison = '';
        $nomTiers = '';
        $nomStyle = '';
        $nbrModel = count($conso);

        $results = DB::select("
        select sum(varience)/count(*) as moyenneVar from v_suiviDetailConso where varience<0");
        $mSousC = ($results[0]->moyennevar) * -1 ?? 0;

        $results = DB::select("
       select sum(quantitesdc*prix_unitaire*varience) as prixsous from v_suiviDetailConso where varience<0");
        $pSousC = ($results[0]->prixsous) * -1 ?? 0;

        $results = DB::select("
       select count(*) as pourcentagesous from v_suiviDetailConso where varience<0");
        $pourcentageSousC = ($results[0]->pourcentagesous)  ?? 0;
        $pourcentageSousC = ($pourcentageSousC * 100) / $nbrModel;

        $results = DB::select("
        select sum(varience)/count(*) as moyenneVar from v_suiviDetailConso where varience>0");
        $mSurC = ($results[0]->moyennevar) ?? 0;

        $results = DB::select("
        select sum(quantitesdc*prix_unitaire*varience) as prixsur from v_suiviDetailConso where varience>0");
        $pSurC = ($results[0]->prixsur) ?? 0;


        $results = DB::select("
        select count(*) as pourcentagesur from v_suiviDetailConso where varience>0");
        $pourcentageSurC = ($results[0]->pourcentagesur)  ?? 0;
        $pourcentageSurC = ($pourcentageSurC * 100) / $nbrModel;

        return view('DEV.PLANNING.suiviConso', compact('pourcentageSurC', 'pSurC', 'mSurC', 'pourcentageSousC', 'pSousC', 'mSousC', 'nbrModel', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'idStyle', 'idTiers', 'modele', 'idSaison', 'conso'));
    }

    public function suiviPlaceur(Request $request)
    {
        $placeur = SuiviDEV::getAllSuiviPlaceur();
        $idSaison = '';
        $modele = '';
        $idTiers = '';
        $idStyle = '';
        $patronier = '';
        $dateDebut = '';
        $dateFin = '';
        $nomSaison = '';
        $nomTiers = '';
        $nomStyle = '';
        $nomEmploye = '';
        $results = DB::select("
        select sum(pointplacement) as total_quantite from v_suiviPlaceur");
        $nbrPoints = $results[0]->total_quantite ?? 0;
        $nbrModele = count($placeur);
        $primePlaceur = BureauEtude::getPrimePatronierByPoints($nbrPoints);
        $prime = $primePlaceur[0]->prime;
        $result = DB::select("
        select count(*) as total from v_suiviPlaceur where deadline<datefin");
        $retard = $result[0]->total ?? 0;
        return view('DEV.PLANNING.suiviPlaceur', compact('retard', 'prime', 'nbrPoints', 'nbrModele', 'nomEmploye', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'patronier', 'idStyle', 'idTiers', 'modele', 'idSaison', 'placeur'));
    }

    public function recherchePatronier(Request $request)
    {
        $query = $request->get('nom');

        $style = ListeEmploye::getAllListeEmployeRecherche($query);

        return response()->json($style);
    }


    // public function rechercheSuiviPatronage(Request $request)
    // {
    //     $idSaison = $request->input('idSaison');
    //     $modele = $request->input('modele');
    //     $idTiers = $request->input('idTiers');
    //     $idStyle = $request->input('idStyle');
    //     $patronier = $request->input('patronier');
    //     $dateDebut = $request->input('dateDebut');
    //     $dateFin = $request->input('dateFin');
    //     $nomSaison = $request->input('nomSaison');
    //     $nomTiers = $request->input('nomTiers');
    //     $nomStyle = $request->input('nomStyle');
    //     $nomEmploye = $request->input('nomEmploye');
    //     $condition = "";
    //     if (empty($nomSaison)) {
    //         $idSaison = "";
    //     }

    //     if (empty($nomTiers)) {
    //         $idTiers = "";
    //     }

    //     if (empty($nomStyle)) {
    //         $idStyle = "";
    //     }

    //     if (empty($nomEmploye)) {
    //         $patronier = "";
    //     }

    //     if (!empty($idSaison)) {
    //         $condition = " and id_saison=" . $idSaison;
    //     }
    //     if (!empty($modele)) {
    //         $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
    //     }
    //     if (!empty($idTiers)) {
    //         $condition = $condition . " and id_tiers=" . $idTiers;
    //     }
    //     if (!empty($idStyle)) {
    //         $condition = $condition . " and id_style=" . $idStyle;
    //     }
    //     if (!empty($patronier)) {
    //         $condition = $condition . " and idlisteemploye=" . $patronier;
    //     }
    //     if (!empty($dateDebut) && !empty($dateFin)) {
    //         $condition = $condition . " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateFin . "'";
    //     }

    //     if (!empty($dateDebut) && empty($dateFin)) {
    //         $condition = $condition . " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateDebut . "'";
    //     }


    //     $patronage = SuiviDEV::getSuiviPatronageRecherche($condition);
    //     return view('DEV.PLANNING.suiviPatronage', compact('nomEmploye', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'patronier', 'idStyle', 'idTiers', 'modele', 'idSaison', 'patronage'));
    // }


    public function rechercheSuiviPatronage(Request $request)
    {
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $idTiers = $request->input('idTiers');
        $idStyle = $request->input('idStyle');
        $patronier = $request->input('patronier');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $nomSaison = $request->input('nomSaison');
        $nomTiers = $request->input('nomTiers');
        $nomStyle = $request->input('nomStyle');
        $nomEmploye = $request->input('nomEmploye');

        if (empty($nomSaison)) {
            $idSaison = "";
        }

        if (empty($nomTiers)) {
            $idTiers = "";
        }

        if (empty($nomStyle)) {
            $idStyle = "";
        }

        if (empty($nomEmploye)) {
            $patronier = "";
        }

        $condition = "1=1";
        if (!empty($idSaison)) {
            $condition .= " and id_saison=" . $idSaison;
        }
        if (!empty($modele)) {
            $condition .= " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition .= " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition .= " and id_style=" . $idStyle;
        }
        if (!empty($patronier)) {
            $condition .= " and idlisteemploye=" . $patronier;
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition .= " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateFin . "'";
        }
        if (!empty($dateDebut) && empty($dateFin)) {
            $condition .= " and DATE(deadline) = '" . $dateDebut . "'";
        }

        $patronage = SuiviDEV::getSuiviPatronageRecherche($condition);

        $results = DB::select("
        select sum(pointpatronage) as total_quantite
        from v_suivipatronage
        where $condition
    ");
        $nbrPoints = $results[0]->total_quantite ?? 0;

        $nbrModele = count($patronage);

        $primePatronier = BureauEtude::getPrimePatronierByPoints($nbrPoints);
        $prime = $primePatronier[0]->prime ?? 0;

        $result = DB::select("
        select count(*) as total
        from v_suivipatronage
        where deadline < datefin and $condition
    ");
        $retard = $result[0]->total ?? 0;

        return view('DEV.PLANNING.suiviPatronage', compact(
            'retard',
            'prime',
            'nbrPoints',
            'nbrModele',
            'nomEmploye',
            'nomStyle',
            'nomTiers',
            'nomSaison',
            'dateFin',
            'dateDebut',
            'patronier',
            'idStyle',
            'idTiers',
            'modele',
            'idSaison',
            'patronage'
        ));
    }

    // public function rechercheSuiviPlaceur(Request $request)
    // {
    //     $idSaison = $request->input('idSaison');
    //     $modele = $request->input('modele');
    //     $idTiers = $request->input('idTiers');
    //     $idStyle = $request->input('idStyle');
    //     $patronier = $request->input('patronier');
    //     $dateDebut = $request->input('dateDebut');
    //     $dateFin = $request->input('dateFin');
    //     $nomSaison = $request->input('nomSaison');
    //     $nomTiers = $request->input('nomTiers');
    //     $nomStyle = $request->input('nomStyle');
    //     $nomEmploye = $request->input('nomEmploye');
    //     $condition = "";

    //     if (empty($nomSaison)) {
    //         $idSaison = "";
    //     }

    //     if (empty($nomTiers)) {
    //         $idTiers = "";
    //     }

    //     if (empty($nomStyle)) {
    //         $idStyle = "";
    //     }

    //     if (empty($nomEmploye)) {
    //         $patronier = "";
    //     }

    //     if (!empty($idSaison)) {
    //         $condition = " and id_saison=" . $idSaison;
    //     }
    //     if (!empty($modele)) {
    //         $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
    //     }
    //     if (!empty($idTiers)) {
    //         $condition = $condition . " and id_tiers=" . $idTiers;
    //     }
    //     if (!empty($idStyle)) {
    //         $condition = $condition . " and id_style=" . $idStyle;
    //     }
    //     if (!empty($patronier)) {
    //         $condition = $condition . " and idlisteemploye=" . $patronier;
    //     }
    //     if (!empty($dateDebut) && !empty($dateFin)) {
    //         $condition = $condition . " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateFin . "'";
    //     }

    //     if (!empty($dateDebut) && empty($dateFin)) {
    //         $condition = $condition . " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateDebut . "'";
    //     }


    //     $placeur = SuiviDEV::getSuiviPlaceurRecherche($condition);
    //     return view('DEV.PLANNING.suiviPlaceur', compact('nomEmploye', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'patronier', 'idStyle', 'idTiers', 'modele', 'idSaison', 'placeur'));
    // }

    // public function rechercheSuiviConso(Request $request)
    // {
    //     $idSaison = $request->input('idSaison');
    //     $modele = $request->input('modele');
    //     $idTiers = $request->input('idTiers');
    //     $idStyle = $request->input('idStyle');
    //     $dateDebut = $request->input('dateDebut');
    //     $dateFin = $request->input('dateFin');
    //     $nomSaison = $request->input('nomSaison');
    //     $nomTiers = $request->input('nomTiers');
    //     $nomStyle = $request->input('nomStyle');
    //     $condition = "";

    //     if (empty($nomSaison)) {
    //         $idSaison = "";
    //     }

    //     if (empty($nomTiers)) {
    //         $idTiers = "";
    //     }

    //     if (empty($nomStyle)) {
    //         $idStyle = "";
    //     }

    //     if (!empty($idSaison)) {
    //         $condition = " and id_saison=" . $idSaison;
    //     }
    //     if (!empty($modele)) {
    //         $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
    //     }
    //     if (!empty($idTiers)) {
    //         $condition = $condition . " and id_tiers=" . $idTiers;
    //     }
    //     if (!empty($idStyle)) {
    //         $condition = $condition . " and id_style=" . $idStyle;
    //     }
    //     if (!empty($dateDebut) && !empty($dateFin)) {
    //         $condition = $condition . " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateFin . "'";
    //     }

    //     if (!empty($dateDebut) && empty($dateFin)) {
    //         $condition = $condition . " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateDebut . "'";
    //     }



    //     $conso = SuiviDEV::getSuiviConsoRecherche($condition);
    //     return view('DEV.PLANNING.suiviConso', compact('nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'idStyle', 'idTiers', 'modele', 'idSaison', 'conso'));
    // }

    public function rechercheSuiviConso(Request $request)
    {
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $idTiers = $request->input('idTiers');
        $idStyle = $request->input('idStyle');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $nomSaison = $request->input('nomSaison');
        $nomTiers = $request->input('nomTiers');
        $nomStyle = $request->input('nomStyle');
        $condition = "";

        if (empty($nomSaison)) {
            $idSaison = "";
        }

        if (empty($nomTiers)) {
            $idTiers = "";
        }

        if (empty($nomStyle)) {
            $idStyle = "";
        }

        if (!empty($idSaison)) {
            $condition = " and id_saison=" . $idSaison;
        }
        if (!empty($modele)) {
            $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition = $condition . " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition = $condition . " and id_style=" . $idStyle;
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateFin . "'";
        }
        if (!empty($dateDebut) && empty($dateFin)) {
            $condition = $condition . " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateDebut . "'";
        }

        $conso = SuiviDEV::getSuiviConsoRecherche($condition);

        $nbrModel = count($conso);

        // Recalcul des valeurs après filtrage

        $results = DB::select("
        select sum(varience)/count(*) as moyenneVar from v_suiviDetailConso where varience<0 $condition");
        $mSousC = ($results[0]->moyennevar) * -1 ?? 0;

        $results = DB::select("
       select sum(quantitesdc*prix_unitaire*varience) as prixsous from v_suiviDetailConso where varience<0 $condition");
        $pSousC = ($results[0]->prixsous) * -1 ?? 0;

        $results = DB::select("
       select count(*) as pourcentagesous from v_suiviDetailConso where varience<0 $condition");
        $pourcentageSousC = ($results[0]->pourcentagesous) ?? 0;
        if ($nbrModel > 0) {
            $pourcentageSousC = ($pourcentageSousC * 100) / $nbrModel;
        }

        $results = DB::select("
        select sum(varience)/count(*) as moyenneVar from v_suiviDetailConso where varience>0 $condition");
        $mSurC = ($results[0]->moyennevar) ?? 0;

        $results = DB::select("
        select sum(quantitesdc*prix_unitaire*varience) as prixsur from v_suiviDetailConso where varience>0 $condition");
        $pSurC = ($results[0]->prixsur) ?? 0;

        $results = DB::select("
        select count(*) as pourcentagesur from v_suiviDetailConso where varience>0 $condition");
        $pourcentageSurC = ($results[0]->pourcentagesur) ?? 0;
        if ($nbrModel > 0) {
            $pourcentageSurC = ($pourcentageSurC * 100) / $nbrModel;
        }

        // Retourner les données avec les nouvelles valeurs recalculées
        return view('DEV.PLANNING.suiviConso', compact('pourcentageSurC', 'pSurC', 'mSurC', 'pourcentageSousC', 'pSousC', 'mSousC', 'nbrModel', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'idStyle', 'idTiers', 'modele', 'idSaison', 'conso'));
    }

    public function rechercheSuiviPlaceur(Request $request)
    {
        // Récupération des inputs du formulaire
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $idTiers = $request->input('idTiers');
        $idStyle = $request->input('idStyle');
        $patronier = $request->input('patronier');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $nomSaison = $request->input('nomSaison');
        $nomTiers = $request->input('nomTiers');
        $nomStyle = $request->input('nomStyle');
        $nomEmploye = $request->input('nomEmploye');

        // Construction des conditions dynamiques
        $condition = "";

        if (!empty($idSaison)) {
            $condition .= " and id_saison=" . $idSaison;
        }
        if (!empty($modele)) {
            $condition .= " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition .= " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition .= " and id_style=" . $idStyle;
        }
        if (!empty($patronier)) {
            $condition .= " and idlisteemploye=" . $patronier;
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition .= " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateFin . "'";
        }
        if (!empty($dateDebut) && empty($dateFin)) {
            $condition .= " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateDebut . "'";
        }

        // Récupération des données filtrées
        $placeur = SuiviDEV::getSuiviPlaceurRecherche($condition);

        // Calcul du nombre de points total après la recherche
        $nbrPointsResults = DB::select("
        select sum(pointplacement) as total_quantite
        from v_suiviPlaceur
        where 1=1 $condition
    ");
        $nbrPoints = $nbrPointsResults[0]->total_quantite ?? 0;

        // Calcul du nombre de modèles
        $nbrModele = count($placeur);

        // Calcul de la prime en fonction des points
        $primePlaceur = BureauEtude::getPrimePatronierByPoints($nbrPoints);
        $prime = $primePlaceur[0]->prime ?? 0;

        // Calcul du retard basé sur la nouvelle condition
        $resultRetard = DB::select("
        select count(*) as total
        from v_suiviPlaceur
        where deadline < datefin $condition
    ");
        $retard = $resultRetard[0]->total ?? 0;

        // Retourner la vue avec toutes les données nécessaires
        return view('DEV.PLANNING.suiviPlaceur', compact('retard', 'prime', 'nbrPoints', 'nbrModele', 'nomEmploye', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'patronier', 'idStyle', 'idTiers', 'modele', 'idSaison', 'placeur'));
    }



    public function rapportMontageDev(Request $request)
    {
        $rapportMontage = SuiviDEV::getAllRapportMontageDev();
        $idSaison = '';
        $modele = '';
        $idTiers = '';
        $idStyle = '';
        $patronier = '';
        $dateDebut = '';
        $dateFin = '';
        $nomSaison = '';
        $nomTiers = '';
        $nomStyle = '';
        $nomEmploye = '';
        $nbrModele = count($rapportMontage);

        $results = DB::select("
        select sum(qteproduite) as qteproduite from v_rapportMontageDev");
        $qte = ($results[0]->qteproduite) ?? 0;

        $results = DB::select("
         select sum(minuteproduite) as minuteproduite from v_rapportMontageDev");
        $minProd = ($results[0]->minuteproduite) ?? 0;

        $results = DB::select("
          select sum(minutepresence) as minutepresence from v_rapportMontageDev");
        $minPres = ($results[0]->minutepresence) ?? 0;

        $results = DB::select("
        select sum(efficiencedev) as efficiencedev from v_rapportMontageDev");
        $eff = ($results[0]->efficiencedev) ?? 0;


        return view('DEV.PLANNING.rapportMontage', compact('eff', 'minPres', 'minProd', 'qte', 'nbrModele', 'nomEmploye', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'patronier', 'idStyle', 'modele', 'idSaison', 'idTiers', 'rapportMontage'));
    }

    public function rapportFinition(Request $request)
    {
        $finition = SuiviDEV::getAllRapportFinitionDev();
        $idSaison = '';
        $modele = '';
        $idTiers = '';
        $idStyle = '';
        $patronier = '';
        $dateDebut = '';
        $dateFin = '';
        $nomSaison = '';
        $nomTiers = '';
        $nomStyle = '';
        $nomEmploye = '';

        $nbrModele = count($finition);

        $results = DB::select("
        select sum(qtefini) as qteproduite from v_rapportFinition");
        $qte = ($results[0]->qteproduite) ?? 0;

        $results = DB::select("
         select sum(minuteproduite) as minuteproduite from v_rapportFinition");
        $minProd = ($results[0]->minuteproduite) ?? 0;

        $results = DB::select("
          select sum(minutepresence) as minutepresence from v_rapportFinition");
        $minPres = ($results[0]->minutepresence) ?? 0;

        $results = DB::select("
        select sum(efficiencedev) as efficiencedev from v_rapportFinition");
        $eff = ($results[0]->efficiencedev) ?? 0;

        return view('DEV.PLANNING.rapportFinition', compact('eff','minPres','minProd','qte','nbrModele','nomEmploye', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'patronier', 'idStyle', 'modele', 'idSaison', 'idTiers', 'finition'));
    }

    public function rapportControlePatronage(Request $request)
    {
        $contrPatronage = SuiviDEV::getAllControlePatronage();
        $idSaison = '';
        $modele = '';
        $idTiers = '';
        $idStyle = '';
        $patronier = '';
        $dateDebut = '';
        $dateFin = '';
        $nomSaison = '';
        $nomTiers = '';
        $nomStyle = '';
        $nomEmploye = '';
        $occurence = 'Occurence';
        $idOccurence = '';
        $typeOccurence = BureauEtude::getAllTypeOccurencePatronage();
        $nbrModele = count($contrPatronage);
        $results = DB::select("
         select count(*) as compte from controlePatronage where occurence=1");
        $nbrOcc = ($results[0]->compte) ?? 0;
        $pourcentage = (100*$nbrOcc)/$nbrModele;
        return view('DEV.PLANNING.rapportPatronage', compact('pourcentage','nbrOcc','nbrModele','idOccurence', 'occurence', 'typeOccurence', 'nomEmploye', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'patronier', 'idStyle', 'modele', 'idSaison', 'idTiers', 'contrPatronage'));
    }

    public function getControlFinalDev(Request $request)
    {
        $idSaison = '';
        $modele = '';
        $idTiers = '';
        $idStyle = '';
        $patronier = '';
        $dateDebut = '';
        $dateFin = '';
        $nomSaison = '';
        $nomTiers = '';
        $nomStyle = '';
        $nomEmploye = '';
        $retouche = 'Retouche';
        $idretouche = '';
        $typeRetouche = BureauEtude::getAllRetouche();
        $final = SuiviDEV::getControlFinalDev();

        $nbrModele= count($final);
        $results = DB::select("
        select sum(qtecontrole) as qtecontrole from v_controlefinal");
       $qteContr = ($results[0]->qtecontrole) ?? 0;

       $results = DB::select("
       select sum(tauxrejet) as tauxrejet from v_controlefinal");
      $tauxrejet = ($results[0]->tauxrejet) ?? 0;

      $results = DB::select("
      select sum(tauxretouche) as tauxretouche from v_controlefinal");
     $tauxretouche = ($results[0]->tauxretouche) ?? 0;

        return view('DEV.PLANNING.rapportControlFinal', compact('tauxretouche','tauxrejet','qteContr','nbrModele','idretouche', 'retouche', 'typeRetouche', 'nomEmploye', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'patronier', 'idStyle', 'modele', 'idSaison', 'idTiers', 'final'));
    }

    public function rechercheRapportMontage(Request $request)
    {
        // Récupération des inputs du formulaire de recherche
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $idTiers = $request->input('idTiers');
        $idStyle = $request->input('idStyle');
        $patronier = $request->input('patronier');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $nomSaison = $request->input('nomSaison');
        $nomTiers = $request->input('nomTiers');
        $nomStyle = $request->input('nomStyle');
        $nomEmploye = $request->input('nomEmploye');
        $condition = "";

        // Gestion des conditions dynamiques pour la requête
        if (empty($nomSaison)) {
            $idSaison = "";
        }
        if (empty($nomTiers)) {
            $idTiers = "";
        }
        if (empty($nomStyle)) {
            $idStyle = "";
        }
        if (empty($nomEmploye)) {
            $patronier = "";
        }

        if (!empty($idSaison)) {
            $condition .= " and id_saison=" . $idSaison;
        }
        if (!empty($modele)) {
            $condition .= " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition .= " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition .= " and id_style=" . $idStyle;
        }
        if (!empty($patronier)) {
            $condition .= " and idlisteemploye=" . $patronier;
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition .= " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateFin . "'";
        }
        if (!empty($dateDebut) && empty($dateFin)) {
            $condition .= " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateDebut . "'";
        }

        // Requête principale pour récupérer les résultats filtrés
        $rapportMontage = SuiviDEV::getRapportMontageRecherche($condition);

        // Recalcul des valeurs à partir des résultats filtrés
        // Calcul de la quantité produite
        $results = DB::select("
        select sum(qteproduite) as qteproduite
        from v_rapportMontageDev
        where 1=1 $condition
    ");
        $qte = ($results[0]->qteproduite) ?? 0;

        // Calcul des minutes produites
        $results = DB::select("
        select sum(minuteproduite) as minuteproduite
        from v_rapportMontageDev
        where 1=1 $condition
    ");
        $minProd = ($results[0]->minuteproduite) ?? 0;

        // Calcul des minutes de présence
        $results = DB::select("
        select sum(minutepresence) as minutepresence
        from v_rapportMontageDev
        where 1=1 $condition
    ");
        $minPres = ($results[0]->minutepresence) ?? 0;

        // Calcul de l'efficacité
        $results = DB::select("
        select sum(efficiencedev) as efficiencedev
        from v_rapportMontageDev
        where 1=1 $condition
    ");
        $eff = ($results[0]->efficiencedev) ?? 0;

        // Calcul du nombre total de modèles (dépendant des résultats filtrés)
        $nbrModele = count($rapportMontage);

        // Retourner la vue avec les données recalculées
        return view('DEV.PLANNING.rapportMontage', compact(
            'eff',
            'minPres',
            'minProd',
            'qte',
            'nbrModele',
            'nomEmploye',
            'nomStyle',
            'nomTiers',
            'nomSaison',
            'dateFin',
            'dateDebut',
            'patronier',
            'idStyle',
            'idTiers',
            'modele',
            'idSaison',
            'rapportMontage'
        ));
    }


    public function rechercheRapportFinition(Request $request)
    {
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $idTiers = $request->input('idTiers');
        $idStyle = $request->input('idStyle');
        $patronier = $request->input('patronier');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $nomSaison = $request->input('nomSaison');
        $nomTiers = $request->input('nomTiers');
        $nomStyle = $request->input('nomStyle');
        $nomEmploye = $request->input('nomEmploye');
        $condition = "";
        if (empty($nomSaison)) {
            $idSaison = "";
        }

        if (empty($nomTiers)) {
            $idTiers = "";
        }

        if (empty($nomStyle)) {
            $idStyle = "";
        }

        if (empty($nomEmploye)) {
            $patronier = "";
        }

        if (!empty($idSaison)) {
            $condition = " and id_saison=" . $idSaison;
        }
        if (!empty($modele)) {
            $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition = $condition . " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition = $condition . " and id_style=" . $idStyle;
        }
        if (!empty($patronier)) {
            $condition = $condition . " and idlisteemploye=" . $patronier;
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateFin . "'";
        }

        if (!empty($dateDebut) && empty($dateFin)) {
            $condition = $condition . " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateDebut . "'";
        }

        $finition = SuiviDEV::getRapportFinitionRecherche($condition);

        $results = DB::select("
        select sum(qtefini) as qteproduite
        from v_rapportFinition
        where 1=1 $condition
    ");
        $qte = ($results[0]->qteproduite) ?? 0;

        // Calcul des minutes produites
        $results = DB::select("
        select sum(minuteproduite) as minuteproduite
        from v_rapportFinition
        where 1=1 $condition
    ");
        $minProd = ($results[0]->minuteproduite) ?? 0;

        // Calcul des minutes de présence
        $results = DB::select("
        select sum(minutepresence) as minutepresence
        from v_rapportFinition
        where 1=1 $condition
    ");
        $minPres = ($results[0]->minutepresence) ?? 0;

        // Calcul de l'efficacité
        $results = DB::select("
        select sum(efficiencedev) as efficiencedev
        from v_rapportFinition
        where 1=1 $condition
    ");
        $eff = ($results[0]->efficiencedev) ?? 0;

        // Calcul du nombre total de modèles (dépendant des résultats filtrés)
        $nbrModele = count($finition);
        return view('DEV.PLANNING.rapportFinition', compact('eff','minPres','minProd','qte','nbrModele','nomEmploye', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'patronier', 'idStyle', 'modele', 'idSaison', 'idTiers', 'finition'));
    }

    public function rechercheControlePatronage(Request $request)
    {
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $idTiers = $request->input('idTiers');
        $idStyle = $request->input('idStyle');
        $patronier = $request->input('patronier');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $nomSaison = $request->input('nomSaison');
        $nomTiers = $request->input('nomTiers');
        $nomStyle = $request->input('nomStyle');
        $nomEmploye = $request->input('nomEmploye');
        $idOccurence = $request->input('typeOccurence');
        $occurence = $request->input('typeOccurence');
        $condition = "";
        if (empty($nomSaison)) {
            $idSaison = "";
        }

        if (empty($nomTiers)) {
            $idTiers = "";
        }

        if (empty($nomStyle)) {
            $idStyle = "";
        }

        if (empty($nomEmploye)) {
            $patronier = "";
        }

        if (!empty($idSaison)) {
            $condition = " and id_saison=" . $idSaison;
        }
        if (!empty($idOccurence)) {
            $condition = " and type_occurence='" . $idOccurence . "'";
        }
        if (!empty($modele)) {
            $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition = $condition . " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition = $condition . " and id_style=" . $idStyle;
        }
        if (!empty($patronier)) {
            $condition = $condition . " and idlisteemploye=" . $patronier;
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateFin . "'";
        }

        if (!empty($dateDebut) && empty($dateFin)) {
            $condition = $condition . " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateDebut . "'";
        }
        $contrPatronage = SuiviDEV::getControlePatronageRecherche($condition);
        $typeOccurence = BureauEtude::getAllTypeOccurencePatronage();
        $nbrModele = count($contrPatronage);
        $results = DB::select("
         select count(*) as compte from v_controlePatronage where occurence=1 $condition");
        $nbrOcc = ($results[0]->compte) ?? 0;
        $pourcentage = (100*$nbrOcc)/$nbrModele;
        return view('DEV.PLANNING.rapportPatronage', compact('pourcentage','nbrOcc','nbrModele','idOccurence', 'occurence', 'typeOccurence', 'nomEmploye', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'patronier', 'idStyle', 'modele', 'idSaison', 'idTiers', 'contrPatronage'));
    }


    public function rechercheStade(Request $request)
    {
        $query = $request->get('type_stade');

        $stade = StadeDemandeClient::where('type_stade', 'ILIKE', '%' . $query . '%')->get();

        return response()->json($stade);
    }
    public function rechercheControleFinal(Request $request)
    {
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $idTiers = $request->input('idTiers');
        $idStyle = $request->input('idStyle');
        $patronier = $request->input('patronier');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $nomSaison = $request->input('nomSaison');
        $nomTiers = $request->input('nomTiers');
        $nomStyle = $request->input('nomStyle');
        $nomEmploye = $request->input('nomEmploye');
        $idretouche = $request->input('typeRetouche');
        $retouche = $request->input('typeRetouche');
        $condition = "";
        if (empty($nomSaison)) {
            $idSaison = "";
        }

        if (empty($nomTiers)) {
            $idTiers = "";
        }

        if (empty($nomStyle)) {
            $idStyle = "";
        }

        if (empty($nomEmploye)) {
            $patronier = "";
        }

        if (!empty($idSaison)) {
            $condition = " and id_saison=" . $idSaison;
        }
        if (!empty($idretouche)) {
            $condition = " and typeretouche='" . $idretouche . "'";
        }
        if (!empty($modele)) {
            $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition = $condition . " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition = $condition . " and id_style=" . $idStyle;
        }
        if (!empty($patronier)) {
            $condition = $condition . " and idlisteemploye=" . $patronier;
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateFin . "'";
        }

        if (!empty($dateDebut) && empty($dateFin)) {
            $condition = $condition . " and DATE(deadline) between '" . $dateDebut . "' and '" . $dateDebut . "'";
        }
        $final = SuiviDEV::getControlFinalDevRecherche($condition);
        $typeRetouche = BureauEtude::getAllRetouche();
        $nbrModele= count($final);
        $results = DB::select("
        select sum(qtecontrole) as qtecontrole from v_controlefinal where 1=1 $condition");
       $qteContr = ($results[0]->qtecontrole) ?? 0;

       $results = DB::select("
       select sum(tauxrejet) as tauxrejet from v_controlefinal where 1=1 $condition");
      $tauxrejet = ($results[0]->tauxrejet) ?? 0;

      $results = DB::select("
      select sum(tauxretouche) as tauxretouche from v_controlefinal where 1=1 $condition");
     $tauxretouche = ($results[0]->tauxretouche) ?? 0;
     return view('DEV.PLANNING.rapportControlFinal', compact('tauxretouche','tauxrejet','qteContr','nbrModele','idretouche', 'retouche', 'typeRetouche', 'nomEmploye', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'patronier', 'idStyle', 'modele', 'idSaison', 'idTiers', 'final'));
    }

    public function transmissionMerch(Request $request)
    {
        $transmission = SuiviDev::getAllTransmissionMerch();
        $idSaison = '';
        $modele = '';
        $idTiers = '';
        $idStyle = '';
        $dateDebut = '';
        $dateFin = '';
        $nomSaison = '';
        $nomTiers = '';
        $nomStyle = '';
        $nomStade = '';
        $idStade = '';
        return view('DEV.PLANNING.transmissionMerch', compact('idStade', 'nomStade', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'idStyle', 'modele', 'idSaison', 'idTiers', 'transmission'));
    }


    public function rechercheTransmissionMerch(Request $request)
    {

        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $idTiers = $request->input('idTiers');
        $idStyle = $request->input('idStyle');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $nomSaison = $request->input('nomSaison');
        $nomTiers = $request->input('nomTiers');
        $nomStyle = $request->input('nomStyle');
        $nomStade = $request->input('nomStade');
        $idStade = $request->input('idStade');
        $condition = "";
        if (empty($nomSaison)) {
            $idSaison = "";
        }

        if (empty($nomTiers)) {
            $idTiers = "";
        }

        if (empty($nomStyle)) {
            $idStyle = "";
        }

        if (empty($nomEmploye)) {
            $patronier = "";
        }

        if (empty($nomStade)) {
            $idStade = "";
        }

        if (!empty($idSaison)) {
            $condition = " and id_saison=" . $idSaison;
        }
        if (!empty($idStade)) {
            $condition = " and stadesdc='" . $idStade . "'";
        }
        if (!empty($modele)) {
            $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition = $condition . " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition = $condition . " and id_style=" . $idStyle;
        }

        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and DATE(deadlinedemandeclient) between '" . $dateDebut . "' and '" . $dateFin . "'";
        }

        if (!empty($dateDebut) && empty($dateFin)) {
            $condition = $condition . " and DATE(deadlinedemandeclient) between '" . $dateDebut . "' and '" . $dateDebut . "'";
        }
        $transmission = SuiviDEV::getAllTransmissionMerchRecherche($condition);
        return view('DEV.PLANNING.transmissionMerch', compact('idStade', 'nomStade', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'idStyle', 'modele', 'idSaison', 'idTiers', 'transmission'));
    }

    public function transmissionClientListe(Request $request)
    {
        $transmission = SuiviDev::getAllTransmissionClient();
        $idSaison = '';
        $modele = '';
        $idTiers = '';
        $idStyle = '';
        $dateDebut = '';
        $dateFin = '';
        $nomSaison = '';
        $nomTiers = '';
        $nomStyle = '';
        $nomStade = '';
        $idStade = '';
        return view('DEV.PLANNING.transmissionClient', compact('idStade', 'nomStade', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'idStyle', 'modele', 'idSaison', 'idTiers', 'transmission'));
    }

    public function rechercheTransmissionClient(Request $request)
    {

        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $idTiers = $request->input('idTiers');
        $idStyle = $request->input('idStyle');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $nomSaison = $request->input('nomSaison');
        $nomTiers = $request->input('nomTiers');
        $nomStyle = $request->input('nomStyle');
        $nomStade = $request->input('nomStade');
        $idStade = $request->input('idStade');
        $condition = "";
        if (empty($nomSaison)) {
            $idSaison = "";
        }

        if (empty($nomTiers)) {
            $idTiers = "";
        }

        if (empty($nomStyle)) {
            $idStyle = "";
        }

        if (empty($nomEmploye)) {
            $patronier = "";
        }

        if (empty($nomStade)) {
            $idStade = "";
        }

        if (!empty($idSaison)) {
            $condition = " and id_saison=" . $idSaison;
        }
        if (!empty($idStade)) {
            $condition = " and stadesdc='" . $idStade . "'";
        }
        if (!empty($modele)) {
            $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition = $condition . " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition = $condition . " and id_style=" . $idStyle;
        }

        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and DATE(date_envoie) between '" . $dateDebut . "' and '" . $dateFin . "'";
        }

        if (!empty($dateDebut) && empty($dateFin)) {
            $condition = $condition . " and DATE(date_envoie) between '" . $dateDebut . "' and '" . $dateDebut . "'";
        }
        $transmission = SuiviDEV::getAllTransmissionClientRecherche($condition);
        return view('DEV.PLANNING.transmissionClient', compact('idStade', 'nomStade', 'nomStyle', 'nomTiers', 'nomSaison', 'dateFin', 'dateDebut', 'idStyle', 'modele', 'idSaison', 'idTiers', 'transmission'));
    }
}
