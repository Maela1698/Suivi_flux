<?php

use App\Http\Controllers\COMPLIANCECONTROLLER\ControllerCompliance;
use App\Http\Controllers\COMPLIANCECONTROLLER\ControllerComplianceBudget;
use App\Http\Controllers\COMPLIANCECONTROLLER\ControllerComplianceExterne;
use App\Http\Controllers\COMPLIANCECONTROLLER\ControlleurComplianceNotia;
use App\Http\Controllers\ControllerMatierePremiere;
use App\Http\Controllers\ControllerSdc;
use App\Http\Controllers\ControllerSmv;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\controllerTier;
use App\Http\Controllers\controllerPri;
use App\Http\Controllers\ControllerEchantillon;
use App\Http\Controllers\controllerDemande;
use App\Http\Controllers\controllerBc;
use App\Http\Controllers\ControllerDataMacro;
use App\Http\Controllers\ControllerDevAccueil;
use App\Http\Controllers\ControllerFCTO;
use App\Http\Controllers\ControllerFDC;
use App\Http\Controllers\ControllerKpiCRM;
use App\Http\Controllers\ControllerListeEmploye;
use App\Http\Controllers\ControllerMasterPlan;
use App\Http\Controllers\ControllerObjectifSaison;
use App\Http\Controllers\ControllerPlanningDev;
use App\Http\Controllers\ControllerPpmeeting;
use App\Http\Controllers\ControllerTransit;
use App\Http\Controllers\ControlleurRetroMerch;
use App\Http\Controllers\MES\ControllerDemande as MESControllerDemande;
use App\Http\Controllers\MES\ControllerSuiviFlux as MESControllerSuiviFlux;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/',[ControllerListeEmploye::class,'pageLogin'])->name('pageLogin');
Route::match(['get', 'post'],'/loginUtilisateur',[ControllerListeEmploye::class,'loginUtilisateur'])->name('loginUtilisateur');

/*---------------CRM---------------------------------*/
/*---------------Tier--------------------------------*/
Route::get('/accueilCRM',[controllerTier::class,'accueil'])->name('CRM.accueil');
Route::get('/unauthorized',[ControllerListeEmploye::class,'unauthorized'])->name('unauthorized');


Route::get('/detailTier',[controllerTier::class,'detailTier'])->name('CRM.detailTier');
Route::get('/ajoutTier',[controllerTier::class,'ajoutTier'])->name('CRM.ajoutTier')->middleware('checkrole:CRM');
Route::get('/listeEtatTier',[controllerTier::class,'listeEtatTier'])->name('CRM.listeEtatTier');
Route::get('/listeQualite',[controllerTier::class,'listeQualite'])->name('CRM.listeQualite');
Route::get('/listeUnite',[controllerTier::class,'listeUnite'])->name('CRM.listeUnite');
Route::post('/tiers', [controllerTier::class, 'nouveauTier'])->name('CRM.nouveauTier')->middleware('checkrole:CRM');
Route::post('/deletetiers', [controllerTier::class, 'deleteTier'])->name('CRM.deleteTiers')->middleware('checkrole:CRM');
Route::post('/updateTiers', [controllerTier::class, 'updateTiers'])->name('CRM.updateTiers')->middleware('checkrole:CRM');
Route::post('/modifTier', [controllerTier::class, 'modifTier'])->name('CRM.modifTier')->middleware('checkrole:CRM');


/*--------------Demande-----------------------------*/
Route::get('/listeDemande',[controllerDemande::class,'listeDemande'])->name('CRM.listeDemande');
Route::get('/ajoutDemande',[controllerDemande::class,'ajoutDemande'])->name('CRM.ajoutDemande')->middleware('checkrole:CRM');
Route::post('/demande',[controllerDemande::class,'nouveauDemande'])->name('CRM.nouveauDemande')->middleware('checkrole:CRM');
Route::get('/detailDemande',[controllerDemande::class,'detailDemande'])->name('CRM.detailDemande');
Route::post('/ajoutDossierTech',[controllerDemande::class,'ajoutDossierTech'])->name('CRM.ajoutDossierTech')->middleware('checkrole:CRM');
Route::get('/deleteDossierTech',[controllerDemande::class,'deleteDossierTech'])->name('CRM.deleteDossierTech')->middleware('checkrole:CRM');
Route::post('/deleteUnTaille',[controllerDemande::class,'deleteUnTaille'])->name('CRM.deleteUnTaille')->middleware('checkrole:CRM');
Route::get('/annuleDemande',[controllerDemande::class,'annuleDemande'])->name('CRM.annuleDemande')->middleware('checkrole:CRM');
/*--------------modifier en post pour le RECA COMMANDE*/
Route::post('/valideDemande',[controllerDemande::class,'valideDemande'])->name('CRM.valideDemande')->middleware('checkrole:CRM');
/*--------------modifier en post pour le RECA COMMANDE*/
Route::post('/updateTaille',[controllerDemande::class,'updateTaille'])->name('CRM.updateTaille')->middleware('checkrole:CRM');
Route::post('/updateQuantites',[controllerDemande::class,'updateQuantites'])->name('CRM.updateQuantites')->middleware('checkrole:CRM');
Route::post('/deleteDemande', [controllerDemande::class, 'deleteDemande'])->name('CRM.deleteDemande')->middleware('checkrole:CRM');
Route::post('/updateDemande', [controllerDemande::class, 'updateDemande'])->name('CRM.updateDemande')->middleware('checkrole:CRM');
Route::post('/modifDemande', [controllerDemande::class, 'modifDemande'])->name('CRM.modifDemande')->middleware('checkrole:CRM');
Route::post('/ajoutTaille', [controllerDemande::class, 'ajoutTaille'])->name('CRM.ajoutTaille')->middleware('checkrole:CRM');
Route::get('/duplicata',[controllerDemande::class,'duplicata'])->name('CRM.duplicata')->middleware('checkrole:CRM');
Route::post('/ajoutDuplicata',[controllerDemande::class,'ajoutDuplicata'])->name('CRM.ajoutDuplicata')->middleware('checkrole:CRM');



/*--------------Completion--------------------------*/
Route::get('/recherche-pays', [controllerTier::class, 'recherche'])->name('recherche-pays');
Route::get('/recherche-tiers', [controllerTier::class, 'rechercheTiers'])->name('recherche-tiers');
Route::get('/recherche-tiers-demande', [controllerTier::class, 'rechercheTiersDemande'])->name('recherche-tiers-demande');
Route::get('/recherche-style', [controllerDemande::class, 'rechercheStyle'])->name('recherche-style');
Route::get('/recherche-saison', [controllerDemande::class, 'rechercheSaison'])->name('recherche-saison');
Route::get('/recherche-client', [controllerDemande::class, 'rechercheClient'])->name('recherche-client');
Route::get('/recherche-client-demande', [controllerDemande::class, 'rechercheClientDemande'])->name('recherche-client-demande');
Route::get('/recherche-client-demande-bc', [controllerDemande::class, 'rechercheClientDemandeBc'])->name('recherche-client-demande-bc');
Route::get('/recherche-taille-min', [controllerDemande::class, 'rechercheTailleMin'])->name('recherche-unite-taille-min');
Route::get('/recherche-taille-max', [controllerDemande::class, 'rechercheTailleMax'])->name('recherche-unite-taille-max');
Route::get('/recherche-taille-base', [controllerDemande::class, 'rechercheTailleBase'])->name('recherche-unite-taille-base');


/*------------------------------SDC-----------------------------------*/
Route::get('/sdc',[ControllerSdc::class,'sdc'])->name('CRM.sdc');
Route::get('/sdcApercue',[ControllerSdc::class,'sdcApercue'])->name('CRM.sdcApercue');
Route::post('/nouveauSdc',[ControllerSdc::class,'nouveauSdc'])->name('CRM.ajoutSdc')->middleware('checkrole:CRM');
Route::post('/insertSdc',[ControllerSdc::class,'insertSdc'])->name('CRM.insertSdc')->middleware('checkrole:CRM');
Route::post('/updateSdc',[ControllerSdc::class,'updateSdc'])->name('CRM.updateSdc')->middleware('checkrole:CRM');
Route::post('/modifSdc',[ControllerSdc::class,'modifSdc'])->name('CRM.modifSdc')->middleware('checkrole:CRM');

/*-----------------------------SMV------------------------------------*/
Route::get('/smv',[ControllerSmv::class,'smv'])->name('CRM.smv');
Route::get('/smvApercue',[ControllerSmv::class,'smvApercue'])->name('CRM.smvApercue');
Route::get('/nouveauSmv',[ControllerSmv::class,'nouveauSmv'])->name('CRM.ajoutSmv')->middleware('checkrole:CRM');
Route::post('/insertSmv',[ControllerSmv::class,'insertSmv'])->name('CRM.insertSmv')->middleware('checkrole:CRM');
Route::post('/updateSmv',[ControllerSmv::class,'updateSmv'])->name('CRM.updateSmv')->middleware('checkrole:CRM');
Route::post('/modifSmv',[ControllerSmv::class,'modifSmv'])->name('CRM.modifSmv')->middleware('checkrole:CRM');

/*-----------------------------PRI----------------------------------*/
Route::get('/pri',[ControllerPri::class,'pri'])->name('CRM.pri');
Route::post('/insertPri',[ControllerPri::class,'insertPri'])->name('CRM.insertPri')->middleware('checkrole:CRM');
Route::get('/nouveauPri',[ControllerPri::class,'nouveauPri'])->name('CRM.ajoutPri')->middleware('checkrole:CRM');
Route::get('/priApercue',[ControllerPri::class,'priApercue'])->name('CRM.priApercue');
Route::post('/updatePri',[ControllerPri::class,'updatePri'])->name('CRM.updatePri')->middleware('checkrole:CRM');
Route::post('/modifPri',[ControllerPri::class,'modifPri'])->name('CRM.modifPri')->middleware('checkrole:CRM');

/*----------------------------ECHANTILLON---------------------------*/
Route::get('/echantillon',[ControllerEchantillon::class,'echantillon'])->name('CRM.echantillon');
Route::post('/insertEchantillon',[ControllerEchantillon::class,'insertEchantillon'])->name('CRM.insertEchantillon')->middleware('checkrole:CRM');
Route::get('/nouveauEchantillon',[ControllerEchantillon::class,'nouveauEchantillon'])->name('CRM.ajoutEchantillon')->middleware('checkrole:CRM');
Route::get('/echantillonApercu',[ControllerEchantillon::class,'echantillonApercu'])->name('CRM.echantillonApercu');
Route::post('/updateEchantillon',[ControllerEchantillon::class,'updateEchantillon'])->name('CRM.updateEchantillon')->middleware('checkrole:CRM');
Route::post('/modifEchantillon',[ControllerEchantillon::class,'modifEchantillon'])->name('CRM.modifEchantillon')->middleware('checkrole:CRM');

/*----------------------------FCTO---------------------------*/
Route::get('/ficheCoupe',[ControllerFCTO::class,'ficheCoupe'])->name('CRM.ficheCoupe');
Route::get('/ajoutFicheCoupe',[ControllerFCTO::class,'ajoutFicheCoupe'])->name('CRM.ajoutFicheCoupe')->middleware('checkrole:CRM');
Route::get('/trimCard',[ControllerFCTO::class,'trimCard'])->name('CRM.trimCard');
Route::get('/ordreFabrication',[ControllerFCTO::class,'ordreFabrication'])->name('CRM.ordreFabrication');
Route::get('/exportCSV',[ControllerFCTO::class,'exportCSV'])->name('CRM.exportCSV')->middleware('checkrole:CRM');
Route::post('/insertFicheCoupe',[ControllerFCTO::class,'insertFicheCoupe'])->name('CRM.insertFicheCoupe')->middleware('checkrole:CRM');
Route::get('/openExcel/{id}',[ControllerFCTO::class,'openExcel'])->name('CRM.openExcel')->middleware('checkrole:CRM');

Route::get('/afficherConsoAccessoires',[ControllerFCTO::class,'afficherConsoAccessoires'])->name('CRM.afficherConsoAccessoires');

/*----------------------------Matiere premiere----------------------*/
Route::get('/formAjouTissu',[ControllerMatierePremiere::class,'formAjouTissu'])->name('CRM.formAjouTissu')->middleware('checkrole:CRM');
Route::post('/ajoutTissu',[ControllerMatierePremiere::class,'ajoutTissu'])->name('CRM.ajoutTissu')->middleware('checkrole:CRM');
Route::get('/rechercheTypeTissu',[ControllerMatierePremiere::class,'rechercheTypeTissu'])->name('rechercheTypeTissu');
Route::get('/rechercheComposition',[ControllerMatierePremiere::class,'rechercheComposition'])->name('rechercheComposition');
Route::get('/rechercheFamilleTissu',[ControllerMatierePremiere::class,'rechercheFamilleTissu'])->name('rechercheFamilleTissu');
Route::get('/formAjoutImages',[ControllerMatierePremiere::class,'formAjoutImages'])->name('CRM.ajoutImage');
Route::post('/ajoutImages',[ControllerMatierePremiere::class,'ajoutImages'])->name('CRM.ajoutImages');
Route::get('/listeImage',[ControllerMatierePremiere::class,'listeImage'])->name('CRM.listeImage');
Route::get('/listeMatierePremiere',[ControllerMatierePremiere::class,'listeMatierePremiere'])->name('CRM.listeMatierePremiere');
Route::get('/detailTissu',[ControllerMatierePremiere::class,'detailTissu'])->name('CRM.detailTissu');
Route::get('/rechercheFamilleAccessoire',[ControllerMatierePremiere::class,'rechercheFamilleAccessoire'])->name('rechercheFamilleAccessoire');
Route::get('/rechercheTypeAccessoire',[ControllerMatierePremiere::class,'rechercheTypeAccessoire'])->name('rechercheTypeAccessoire');
Route::get('/formAjoutAccessoire',[ControllerMatierePremiere::class,'formAjoutAccessoire'])->name('CRM.formAjoutAccessoire')->middleware('checkrole:CRM');
Route::post('/ajoutAccessoire',[ControllerMatierePremiere::class,'ajoutAccessoire'])->name('CRM.ajoutAccessoire')->middleware('checkrole:CRM');
Route::get('/detailAccessoire',[ControllerMatierePremiere::class,'detailAccessoire'])->name('CRM.detailAccessoire');
Route::get('/formModifTissu',[ControllerMatierePremiere::class,'formModifTissu'])->name('CRM.formModifTissu')->middleware('checkrole:CRM');
Route::post('/modifTissu',[ControllerMatierePremiere::class,'modifTissu'])->name('CRM.modifTissu')->middleware('checkrole:CRM');
Route::get('/formModifAccessoire',[ControllerMatierePremiere::class,'formModifAccessoire'])->name('CRM.formModifAccessoire')->middleware('checkrole:CRM');
Route::post('/modifAccessoire',[ControllerMatierePremiere::class,'modifAccessoire'])->name('CRM.modifAccessoire')->middleware('checkrole:CRM');
Route::post('/deleteTissu',[ControllerMatierePremiere::class,'deleteTissu'])->name('CRM.deleteTissu')->middleware('checkrole:CRM');
Route::post('/deleteTissu',[ControllerMatierePremiere::class,'deleteTissu'])->name('CRM.deleteTissu')->middleware('checkrole:CRM');
Route::post('/deleteAccessoire',[ControllerMatierePremiere::class,'deleteAccessoire'])->name('CRM.deleteAccessoire')->middleware('checkrole:CRM');


/*------------------FDC--------------------------------*/
Route::get('/fdc',[ControllerFDC::class,'fdc'])->name('CRM.fdc');
Route::get('/formAjoutFDC',[ControllerFDC::class,'formAjoutFDC'])->name('CRM.formAjoutFDC')->middleware('checkrole:CRM');
Route::get('/modifConsoTissu',[ControllerFDC::class,'modifConsoTissu'])->name('CRM.modifConsoTissu')->middleware('checkrole:CRM');
Route::match(['get', 'post'],'/formUpdateConsoAccessoire',[ControllerFDC::class,'formUpdateConsoAccessoire'])->name('CRM.formUpdateConsoAccessoire')->middleware('checkrole:CRM');
Route::post('/modifConsoAccy',[ControllerFDC::class,'modifConsoAccy'])->name('CRM.modifConsoAccy')->middleware('checkrole:CRM');
Route::get('/fdcApercu',[ControllerFDC::class,'fdcApercu'])->name('CRM.fdcApercu');
Route::post('/ajoutCaractereTissu',[ControllerFDC::class,'ajoutCaractereTissu'])->name('CRM.ajoutCaractereTissu')->middleware('checkrole:CRM');
/*--------------------------------------------------*/

/*------------------KPI--------------------------------*/
Route::get('/kpi',[ControllerKpiCRM::class,'kpi'])->name('CRM.kpi');


/*------------------DEV--------------------------------*/
Route::match(['get', 'post'],'/DEV.accueil',[ControllerDevAccueil::class,'accueil'])->name('DEV.accueil');
Route::match(['get', 'post'],'/DEV.detailDemandeClient',[ControllerDevAccueil::class,'detailDemandeClient'])->name('DEV.detailDemandeClient');
Route::match(['get', 'post'],'/DEV.matierePremiere',[ControllerDevAccueil::class,'matierePremiere'])->name('DEV.matierePremiere');
Route::match(['get', 'post'],'/DEV.detailTissu',[ControllerDevAccueil::class,'detailTissu'])->name('DEV.detailTissu');
Route::match(['get', 'post'],'/DEV.detailAccessoire',[ControllerDevAccueil::class,'detailAccessoire'])->name('DEV.detailAccessoire');
Route::match(['get', 'post'],'/DEV.sdc',[ControllerDevAccueil::class,'sdc'])->name('DEV.sdc');
Route::match(['get', 'post'],'/DEV.sdcApercue',[ControllerDevAccueil::class,'sdcApercue'])->name('DEV.sdcApercue');
Route::match(['get', 'post'],'/DEV.fdcApercu',[ControllerDevAccueil::class,'fdcApercu'])->name('DEV.fdcApercu');
Route::match(['get', 'post'],'/DEV.fdc',[ControllerDevAccueil::class,'fdc'])->name('DEV.fdc');
Route::match(['get', 'post'],'/DEV.ficheCoupe',[ControllerDevAccueil::class,'ficheCoupe'])->name('DEV.ficheCoupe');
Route::match(['get', 'post'],'/DEV.planningDEV',[ControllerPlanningDev::class,'planningDEV'])->name('DEV.planningDEV');
Route::match(['get', 'post'],'/DEV.formAjoutBureauEtude',[ControllerPlanningDev::class,'formAjoutBureauEtude'])->name('DEV.formAjoutBureauEtude')->middleware(middleware: 'checkrole:DEV|Admin');
Route::match(['get', 'post'],'/DEV.ajoutBureauEtude',[ControllerPlanningDev::class,'ajoutBureauEtude'])->name('DEV.ajoutBureauEtude')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.formUpdateBureauEtude',[ControllerPlanningDev::class,'formUpdateBureauEtude'])->name('DEV.formUpdateBureauEtude')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.updateBureauEtude',[ControllerPlanningDev::class,'updateBureauEtude'])->name('DEV.updateBureauEtude')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.acheverBureauEtude',[ControllerPlanningDev::class,'acheverBureauEtude'])->name('DEV.acheverBureauEtude')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.debutPatronage',[ControllerPlanningDev::class,'debutPatronage'])->name('DEV.debutPatronage')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.acheverSuiviPatronage',[ControllerPlanningDev::class,'acheverSuiviPatronage'])->name('DEV.acheverSuiviPatronage')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.debutControlePatronage',[ControllerPlanningDev::class,'debutControlePatronage'])->name('DEV.debutControlePatronage')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.acheverControlePatronage',[ControllerPlanningDev::class,'acheverControlePatronage'])->name('DEV.acheverControlePatronage')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.debutPlacement',[ControllerPlanningDev::class,'debutPlacement'])->name('DEV.debutPlacement')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.formFinPlacement',[ControllerPlanningDev::class,'formFinPlacement'])->name('DEV.formFinPlacement')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.acheverPlacement',[ControllerPlanningDev::class,'acheverPlacement'])->name('DEV.acheverPlacement')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.debutIntermediaire',[ControllerPlanningDev::class,'debutIntermediaire'])->name('DEV.debutIntermediaire')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.acheverIntermediaire',[ControllerPlanningDev::class,'acheverIntermediaire'])->name('DEV.acheverIntermediaire')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.debutMontage',[ControllerPlanningDev::class,'debutMontage'])->name('DEV.debutMontage')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.acheverMontage',[ControllerPlanningDev::class,'acheverMontage'])->name('DEV.acheverMontage')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.debutControleFinal',[ControllerPlanningDev::class,'debutControleFinal'])->name('DEV.debutControleFinal')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.suiviPatronage',[ControllerDevAccueil::class,'suiviPatronage'])->name('DEV.suiviPatronage')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.suiviConso',[ControllerDevAccueil::class,'suiviConso'])->name('DEV.suiviConso')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.suiviPlaceur',[ControllerDevAccueil::class,'suiviPlaceur'])->name('DEV.suiviPlaceur')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.rapportControlePatronage',[ControllerDevAccueil::class,'rapportControlePatronage'])->name('DEV.rapportControlePatronage')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.acheverControleFinal',[ControllerPlanningDev::class,'acheverControleFinal'])->name('DEV.acheverControleFinal')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.acheverFinition',[ControllerPlanningDev::class,'acheverFinition'])->name('DEV.acheverFinition')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.debutRapportFinition',[ControllerPlanningDev::class,'debutRapportFinition'])->name('DEV.debutRapportFinition')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.transmission',[ControllerPlanningDev::class,'transmission'])->name('DEV.transmission')->middleware(middleware: 'checkrole:DEV');
Route::match(['get', 'post'],'/DEV.transmissionClient',[ControllerPlanningDev::class,'transmissionClient'])->name('DEV.transmissionClient')->middleware(middleware: 'checkrole:CRM');
Route::match(['get', 'post'],'/DEV.recherchePatronier',[ControllerDevAccueil::class,'recherchePatronier'])->name('DEV.recherchePatronier');
Route::match(['get', 'post'],'/DEV.rechercheSuiviPatronage',[ControllerDevAccueil::class,'rechercheSuiviPatronage'])->name('DEV.rechercheSuiviPatronage');
Route::match(['get', 'post'],'/DEV.rechercheSuiviPlaceur',[ControllerDevAccueil::class,'rechercheSuiviPlaceur'])->name('DEV.rechercheSuiviPlaceur');
Route::match(['get', 'post'],'/DEV.rechercheSuiviConso',[ControllerDevAccueil::class,'rechercheSuiviConso'])->name('DEV.rechercheSuiviConso');
Route::match(['get', 'post'],'/DEV.rapportMontageDev',[ControllerDevAccueil::class,'rapportMontageDev'])->name('DEV.rapportMontageDev');
Route::match(['get', 'post'],'/DEV.rapportFinition',[ControllerDevAccueil::class,'rapportFinition'])->name('DEV.rapportFinition');
Route::match(['get', 'post'],'/DEV.getControlFinalDev',[ControllerDevAccueil::class,'getControlFinalDev'])->name('DEV.getControlFinalDev');
Route::match(['get', 'post'],'/DEV.rechercheRapportMontage',[ControllerDevAccueil::class,'rechercheRapportMontage'])->name('DEV.rechercheRapportMontage');
Route::match(['get', 'post'],'/DEV.rechercheRapportFinition',[ControllerDevAccueil::class,'rechercheRapportFinition'])->name('DEV.rechercheRapportFinition');
Route::match(['get', 'post'],'/DEV.rechercheControlePatronage',[ControllerDevAccueil::class,'rechercheControlePatronage'])->name('DEV.rechercheControlePatronage');
Route::match(['get', 'post'],'/DEV.rechercheControleFinal',[ControllerDevAccueil::class,'rechercheControleFinal'])->name('DEV.rechercheControleFinal');
Route::match(['get', 'post'],'/DEV.rechercheStade',[ControllerDevAccueil::class,'rechercheStade'])->name('DEV.rechercheStade');
Route::match(['get', 'post'],'/DEV.rechercheAccueil',[ControllerDevAccueil::class,'rechercheAccueil'])->name('DEV.rechercheAccueil');
Route::match(['get', 'post'],'/DEV.recherchePlanning',[ControllerPlanningDev::class,'recherchePlanning'])->name('DEV.recherchePlanning');
Route::match(['get', 'post'],'/DEV.transmissionMerch',[ControllerDevAccueil::class,'transmissionMerch'])->name('DEV.transmissionMerch');
Route::match(['get', 'post'],'/DEV.rechercheTransmissionMerch',[ControllerDevAccueil::class,'rechercheTransmissionMerch'])->name('DEV.rechercheTransmissionMerch');
Route::match(['get', 'post'],'/DEV.transmissionClientListe',[ControllerDevAccueil::class,'transmissionClientListe'])->name('DEV.transmissionClientListe');
Route::match(['get', 'post'],'/DEV.rechercheTransmissionClient',[ControllerDevAccueil::class,'rechercheTransmissionClient'])->name('DEV.rechercheTransmissionClient');
Route::match(['get', 'post'],'/DEV.acheverAttente',[ControllerPlanningDev::class,'acheverAttente'])->name('DEV.acheverAttente')->middleware(middleware: 'checkrole:DEV');



/*-------------------------------B.C-------------------------------*/
Route::get('/bc',[ControllerBc::class,'bc'])->name('CRM.bc');
Route::get('/bc-ajoutBc/{idbc}',[ControllerBc::class,'ajoutBc'])->name('CRM.ajoutBc');
Route::get('/bc-detailBc',[ControllerBc::class,'detailBc'])->name('CRM.detailBc');
Route::post('/bc-insertBc',[ControllerBc::class,'insertBc'])->name('CRM.insertBc');
Route::post('/bc-ajoutBcTissus',[ControllerBc::class,'ajoutBcTissus'])->name('CRM.ajoutBcTissus');
Route::get('/bc-ajoutBcGeneral',[ControllerBc::class,'ajoutBcGeneral'])->name('CRM.ajoutBcGeneral');
Route::post('/bc-deleteBc',[ControllerBc::class,'deleteBc'])->name('CRM.deleteBc');
Route::post('/bc-revisiterBc',[ControllerBc::class,'revisiterBc'])->name('CRM.revisiterBc');
Route::get('/bc-detailBcAccessoire',[ControllerBc::class,'detailBcAccessoire'])->name('CRM.detailBcAccessoire');
Route::get('/bc-detailBcTissus',[ControllerBc::class,'detailBcTissus'])->name('CRM.detailBcTissus');
Route::get('/bc-tableauDeBordTscf',[ControllerBc::class,'tableauDeBordTscf'])->name('CRM.tableauDeBordTscf');
Route::get('/bcapercu/{id}/{idtier}', [controllerBC::class, 'bcapercu'])->name('CRM.bcapercu');
Route::get('/validerBc', [controllerBC::class, 'validerBc'])->name('CRM.validerBc');

/*-----------------------------------TSCF-------------------------------------------*/
Route::get('/tscfCoupeType',[ControllerBc::class,'tscfCoupeType'])->name('CRM.tscfCoupeType');
Route::get('/nouvelleBc',[ControllerBc::class,'nouvelleBc'])->name('CRM.nouvelleBc');
Route::post('/merch',[ControllerBc::class,'merch'])->name('CRM.merch');
Route::post('/transit',[ControllerBc::class,'transit'])->name('CRM.transit');
Route::post('/magasin',[ControllerBc::class,'magasin'])->name('CRM.magasin');
Route::post('/reclamation',[ControllerBc::class,'reclamation'])->name('CRM.reclamation');
Route::post('/comptabilite',[ControllerBc::class,'compta'])->name('CRM.comptabilite');
Route::get('/retourListeTscf',[ControllerBc::class,'retourListeTscf'])->name('CRM.retourListeTscf');

/*-------------------------------------------------------RETRO MERCH------------------------------------------------------*/
Route::get('/retro',[ControlleurRetroMerch::class,'retro'])->name('PLANNING.retro');
Route::get('/micro',[ControlleurRetroMerch::class,'micro'])->name('PLANNING.micro');
Route::get('/recapcommande',action: [ControlleurRetroMerch::class,'recapcommande'])->name('PLANNING.recapcommande');
Route::post('/microRealisation', [ControlleurRetroMerch::class,'microRealisation'])->name('PLANNING.microRealisation');
Route::get('/detailRetro',[ControlleurRetroMerch::class,'detailRetro'])->name('PLANNING.detailRetro');
Route::post('/update-etat',[ControlleurRetroMerch::class,'updateEtat']);

/*-------------------------------------------------RECAP COMMANDE----------------------------------------------------*/
Route::get('/detailRecap',[ControlleurRetroMerch::class,'detailRecap'])->name('PLANNING.detailRecap');
Route::post('/modifierRecapCommande',[ControlleurRetroMerch::class,'modifierRecapCommande'])->name('PLANNING.modifierRecapCommande');
Route::post('/modifierDestinationRecapCommande',[ControlleurRetroMerch::class,'modifierDestinationRecapCommande'])->name('PLANNING.modifierDestinationRecapCommande');
Route::post('/deleteLigneDest',[ControlleurRetroMerch::class,'deleteLigneDest'])->name('PLANNING.deleteLigneDest');
Route::post('/modifierDateDeadline',[ControlleurRetroMerch::class,'modifierDateDeadline'])->name('PLANNING.modifierDateDeadline');
Route::get('/microrealiser',[ControlleurRetroMerch::class,'microrealiser'])->name('PLANNING.microrealiser');

/*------------------ObjectifSaison--------------------------------*/
Route::get('/LRP/objectifSaison', [ControllerObjectifSaison::class, 'objectifSaison'])->name('LRP.objectifSaison');
Route::get('/LRP/detailobjectifSaison/{id_tier}/{id_saison}', [ControllerObjectifSaison::class, 'getDetailObjectifSaison'])->name('LRP.detailobjectifSaison');
Route::get('/LRP/ajouterobjectifSaison', [ControllerObjectifSaison::class, 'showajouterObjectifSaison'])->name('LRP.ajouterobjectifSaison');
Route::post('/insertObjectifSaison', [ControllerObjectifSaison::class, 'ajouterObjectifSaison'])->name('LRP.ajouterObjectifSaison');
Route::post('/LRP/updateObjectifSaison', [ControllerObjectifSaison::class, 'updateObjectifSaison'])->name('LRP.updateObjectifSaison');
Route::get('/recherche-merchsenior', [ControllerObjectifSaison::class, 'rechercheMerchSenior'])->name('LRP.recherche-merchsenior');
Route::post('/deleteObjectifSaison', [ControllerObjectifSaison::class, 'deleteObjectifSaison'])->name('LRP.deleteObjectifSaison');
/*------------------ObjectifSaison--------------------------------*/


/*------------------MasterPlan--------------------------------*/
Route::get('/LRP/listeMasterPlan', [ControllerMasterPlan::class, 'listemasterplan'])->name('LRP.listeMasterPlan');
Route::get('/LRP/detailsMasterPlan/{demande_client_id}', [ControllerMasterPlan::class, 'detailsmasterplan'])->name('LRP.detailMasterPlan');
Route::get('/LRP/showajoutMasterPlan', [ControllerMasterPlan::class, 'showajoutermasterplan'])->name('LRP.showajoutermasterplan');
Route::post('/LRP/ajouterMasterPlan', [ControllerMasterPlan::class, 'ajoutermasterplan'])->name('LRP.ajoutermasterplan');
/*------------------MasterPlan--------------------------------*/

/*------------------RAD--------------------------------*/
/*------------------DATA & MACRO-CHARGES 20-09-2024 --------------------------------*/
Route::get('/LRP/listeData', [ControllerDataMacro::class, 'showlistData'])->name('LRP.listeData');
// Route::get('/LRP/listeData1', [ControllerDataMacro::class, 'showlistData1'])->name('LRP.listeData');
// Route::get('/LRP/detailsData/{numerocommande}/{iddemandeclient}', [ControllerDataMacro::class, 'showdetailsData'])->name('LRP.detailsData');


Route::get('/LRP/dataprod/{iddemandeclient}', [ControllerDataMacro::class, 'showdataprod'])->name('LRP.dataprod');
Route::get('/LRP/dataprint/{iddemandeclient}', [ControllerDataMacro::class, 'showdataprint'])->name('LRP.dataprint');
Route::get('/LRP/databm/{iddemandeclient}', [ControllerDataMacro::class, 'showdatabm'])->name('LRP.databm');
Route::get('/LRP/databmc/{iddemandeclient}', [ControllerDataMacro::class, 'showdatabmc'])->name('LRP.databmc');
Route::get('/LRP/datalbt/{iddemandeclient}', [ControllerDataMacro::class, 'showdatalbt'])->name('LRP.datalbt');


Route::post('/LRP/ajouterdataProd', [ControllerDataMacro::class, 'createDataProd'])->name('LRP.createDataProd');
Route::post('/LRP/ajouterdataPrint', [ControllerDataMacro::class, 'createDataPrint'])->name('LRP.createDataPrint');
Route::post('/LRP/ajouterdataBm', [ControllerDataMacro::class, 'createDataBm'])->name('LRP.createDataBm');
Route::post('/LRP/ajouterdataBmc', [ControllerDataMacro::class, 'createDataBmc'])->name('LRP.createDataBmc');
Route::post('/LRP/ajouterdataLbt', [ControllerDataMacro::class, 'createDataLbt'])->name('LRP.createDataLbt');

Route::post('/LRP/updatedataProd', [ControllerDataMacro::class, 'updateDataProd'])->name('LRP.updateDataProd');
Route::post('/LRP/updatedataPrint', [ControllerDataMacro::class, 'updateDataPrint'])->name('LRP.updateDataPrint');
Route::post('/LRP/updatedataBm', [ControllerDataMacro::class, 'updateDataBm'])->name('LRP.updateDataBm');
Route::post('/LRP/updatedataBmc', [ControllerDataMacro::class, 'updateDataBmc'])->name('LRP.updateDataBmc');
Route::post('/LRP/updatedataLbt', [ControllerDataMacro::class, 'updateDataLbt'])->name('LRP.updateDataLbt');

Route::get('/recherche-stadespecifique', [ControllerDataMacro::class, 'recherchestadespecifique'])->name('LRP.recherchestadespecifique');
Route::get('/recherche-lavage', [ControllerDataMacro::class, 'recherchelavage'])->name('LRP.recherche-lavage');
Route::get('/jours-ouvrables', [ControllerDataMacro::class, 'countJourOuvrableAjax'])->name('joursouvrables.count');


// 08/10/2024

Route::get('/LRP/formajoutMacro', [ControllerDataMacro::class, 'showajoutmacro'])->name('LRP.listeajoutmacro');
Route::post('/LRP/ajouterMacro', [ControllerDataMacro::class, 'ajouterMacro'])->name('LRP.ajouterMacro');

// 09-10-2024
Route::post('/get-macro-data', [ControllerDataMacro::class, 'getMacroData'])->name('get.macro.data');
Route::post('/macrocharge/store', [ControllerDataMacro::class, 'store'])->name('macrocharge.store');

// 10-10-2024
// Dans web.php
Route::post('/LRP/listeDataJson', [ControllerDataMacro::class, 'getDataJson']);
Route::get('/get-qte/{demande_client_id}', [ControllerDataMacro::class, 'getQte']);

Route::get('/getProchaineDispo', [ControllerDataMacro::class, 'getProchaineDispo']);

/*------------------DATA & MACRO-CHARGES --------------------------------*/




/*------------------------------------------------------MICRO PLANNING--------------------------------------------------------------*/
Route::get('/microplaning',[ControlleurRetroMerch::class,'microplaning'])->name('PLANNING.microplanning');
Route::get('/bmplanning',[ControlleurRetroMerch::class,'bmplaning'])->name('PLANNING.bmplanning');
Route::get('/bmcplanning',action: [ControlleurRetroMerch::class,'bmcplaning'])->name('PLANNING.bmcplanning');
Route::get('/lbtplanning',[ControlleurRetroMerch::class,'lbtplaning'])->name('PLANNING.lbtplanning');
Route::post('/update-date', [ControlleurRetroMerch::class, 'updateDatePrint'])->name('update.date');
Route::post('/update-date-brod-main', [ControlleurRetroMerch::class, 'updateDateBrodMain'])->name('update.datebrodmain');

/*------------------------------------------------------RETRO PLANNING--------------------------------------------------------------*/
Route::get('/kanban',[ControlleurRetroMerch::class,'kanban'])->name('PLANNING.retroplanning');
Route::post('/echangeRetroPlanning',[ControlleurRetroMerch::class,'echangeRetroPlanning'])->name('PLANNING.echangeRetroPlanning');
Route::post('/ajoutRetroPlanning',[ControlleurRetroMerch::class,'ajoutRetroPlanning'])->name('PLANNING.ajoutRetroPlanning');
Route::post('/modifierDateDeTravail',[ControlleurRetroMerch::class,'modifierDateDeTravail'])->name('PLANNING.modifierDateDeTravail');
Route::post('/ajoutDonne',[ControlleurRetroMerch::class,'ajoutDonne'])->name('PLANNING.ajoutDonne');
Route::post('/ajoutCapaciteReel',[ControlleurRetroMerch::class,'ajoutCapaciteReel'])->name('PLANNING.ajoutCapaciteReel');
Route::post('/insertDateNonTravail',[ControlleurRetroMerch::class,'insertDateNonTravail'])->name('PLANNING.insertDateNonTravail');

/*------------------------------------------------------DETAIL RECLAMATION---------------------------------------------------------*/
Route::get('/detailreclamation',[ControllerBc::class,'detailreclamation'])->name('CRM.detailreclamation');
Route::get('/chartreclamation',[ControllerBc::class,'chartreclamation'])->name('CRM.chartreclamation');
Route::get('/historiqueReclamation',[ControllerBc::class,'historiqueReclamation'])->name('CRM.historiqueReclamation');

/*----------------------TRANSIT--------------------------*/
Route::get('/transit',[ControllerTransit::class,'acceuil'])->name('TRANSIT.acceuil');


/*----------------------MES--------------------------*/
Route::get('/mes-demande',[MESControllerDemande::class,'getDemandeConfirme'])->name('MES.demande');
Route::get('/mes-fiche-demande/{id}',[MESControllerDemande::class,'getFicheDemandeConfirme'])->name('MES.fiche-demande');
Route::get('/mes-destinations-of/{recap_id}/{numerocommande}',[MESControllerDemande::class,'getDestinationByOF'])->name('MES.destinations-of');
Route::match(['get', 'post'],'/mes-suiviFlux',[MESControllerSuiviFlux::class,'suiviFlux'])->name('MES.suiviFlux');
Route::post('/mes-suivre-flux',[MESControllerDemande::class,'suivreFlux'])->name('MES.suivreFlux');
Route::match(['get', 'post'],'/mes-modificationSuiviMes',[MESControllerSuiviFlux::class,'modificationSuiviMes'])->name('MES.modificationSuiviMes');
Route::get('/export-csv', [MESControllerSuiviFlux::class, 'exportCSVFlux'])->name('exportCSV');

/*------------------------------------------------COMPLIANCE NOTIA------------------------------------------------------*/
Route::match(['get', 'post'],'/COMPLIANCE.listePerimetre',[ControlleurComplianceNotia::class,'listePerimetre'])->name('COMPLIANCE.listePerimetre');
Route::match(['get', 'post'],'/COMPLIANCE.listeQuestionnaire',action: [ControlleurComplianceNotia::class,'listeQuestionnaire'])->name('COMPLIANCE.listeQuestionnaire');
Route::match(['get', 'post'],'/COMPLIANCE.listeConstatProcedure',[ControlleurComplianceNotia::class,'listeConstatProcedure'])->name('COMPLIANCE.listeConstatProcedure');
Route::match(['get', 'post'],'/COMPLIANCE.detailQuestionnaire',[ControlleurComplianceNotia::class,'detailQuestionnaire'])->name('COMPLIANCE.detailQuestionnaire');
Route::match(['get', 'post'],'/COMPLIANCE.detailQuestionnaireProcedure',action: [ControlleurComplianceNotia::class,'detailQuestionnaireProcedure'])->name('COMPLIANCE.detailQuestionnaireProcedure');
Route::match(['get', 'post'],'/COMPLIANCE.ajoutQuestionnaire',action: [ControlleurComplianceNotia::class,'ajoutQuestionnaire'])->name('COMPLIANCE.ajoutQuestionnaire');
Route::match(['get', 'post'],'/COMPLIANCE.ajoutQuestionnaireProcedure',action: [ControlleurComplianceNotia::class,'ajoutQuestionnaireProcedure'])->name('COMPLIANCE.ajoutQuestionnaireProcedure');
Route::match(['get', 'post'],'/COMPLIANCE.ajoutConstatPerimetre',action: [ControlleurComplianceNotia::class,'ajoutConstatPerimetre'])->name('COMPLIANCE.ajoutConstatPerimetre');
Route::match(['get', 'post'],'/COMPLIANCE.ajoutConstatProcedure',action: [ControlleurComplianceNotia::class,'ajoutConstatProcedure'])->name('COMPLIANCE.ajoutConstatProcedure');
Route::match(['get', 'post'],'/COMPLIANCE.listeConstatPerimetre',action: [ControlleurComplianceNotia::class,'listeConstatPerimetre'])->name('COMPLIANCE.listeConstatPerimetre');
Route::match(['get', 'post'],'/COMPLIANCE.detailConstatPerimetre',action: [ControlleurComplianceNotia::class,'detailConstatPerimetre'])->name('COMPLIANCE.detailConstatPerimetre');
Route::get('/get-types/{departementId}', [ControlleurComplianceNotia::class, 'getTypes']);


/*------------------COMPLIANCE--------------------------------*/
Route::match(['get', 'post'],'/COMPLIANCE.listeConstat',[ControllerCompliance::class,'listeConstat'])->name('COMPLIANCE.listeConstat');
Route::match(['get', 'post'],'/COMPLIANCE.ajoutConstat',[ControllerCompliance::class,'ajoutConstat'])->name('COMPLIANCE.ajoutConstat');
Route::match(['get', 'post'],'/COMPLIANCE.detailConstat',[ControllerCompliance::class,'detailConstat'])->name('COMPLIANCE.detailConstat');
Route::get('/COMPLIANCE.rechercheEmployeByNomPrenom', [ControllerCompliance::class, 'rechercheEmployeByNomPrenom'])->name('COMPLIANCE.rechercheEmployeByNomPrenom');
Route::match(['get', 'post'],'/COMPLIANCE.ajoutPlanAction',[ControllerCompliance::class,'ajoutPlanAction'])->name('COMPLIANCE.ajoutPlanAction');
Route::match(['get', 'post'],'/COMPLIANCE.listePlanAction',[ControllerCompliance::class,'listePlanAction'])->name('COMPLIANCE.listePlanAction');
Route::match(['get', 'post'],'/COMPLIANCE.ajoutAvancement',[ControllerCompliance::class,'ajoutAvancement'])->name('COMPLIANCE.ajoutAvancement');
Route::match(['get', 'post'],'/COMPLIANCE.detailPlanAction',[ControllerCompliance::class,'detailPlanAction'])->name('COMPLIANCE.detailPlanAction');
Route::match(['get', 'post'],'/COMPLIANCE.modifConstatInterne',[ControllerCompliance::class,'modifConstatInterne'])->name('COMPLIANCE.modifConstatInterne');


/*------------------COMPLIANCE EXTERNE-------------------------------*/
Route::match(['get', 'post'],'/COMPLIANCEEXTERNE.listeAuditExterne',[ControllerComplianceExterne::class,'listeAuditExterne'])->name('COMPLIANCEEXTERNE.listeAuditExterne');
Route::match(['get', 'post'],'/COMPLIANCEEXTERNE.ajoutAuditExterne',[ControllerComplianceExterne::class,'ajoutAuditExterne'])->name('COMPLIANCEEXTERNE.ajoutAuditExterne');
Route::match(['get', 'post'],'/COMPLIANCEEXTERNE.detailAuditExterne',[ControllerComplianceExterne::class,'detailAuditExterne'])->name('COMPLIANCEEXTERNE.detailAuditExterne');
Route::match(['get', 'post'],'/COMPLIANCEEXTERNE.ajoutPlanActionExterne',[ControllerComplianceExterne::class,'ajoutPlanActionExterne'])->name('COMPLIANCEEXTERNE.ajoutPlanActionExterne');
Route::match(['get', 'post'],'/COMPLIANCEEXTERNE.listePlanActionExterne',[ControllerComplianceExterne::class,'listePlanActionExterne'])->name('COMPLIANCEEXTERNE.listePlanActionExterne');
Route::match(['get', 'post'],'/COMPLIANCEEXTERNE.ajoutAvancementExterne',[ControllerComplianceExterne::class,'ajoutAvancementExterne'])->name('COMPLIANCEEXTERNE.ajoutAvancementExterne');



/*------------------COMPLIANCE BUDGET-------------------------------*/
Route::match(['get', 'post'],'/COMPLIANCEBUDGET.listeBudgetCompliance',action: [ControllerComplianceBudget::class,'listeBudgetCompliance'])->name('COMPLIANCEBUDGET.listeBudgetCompliance');
Route::match(['get', 'post'],'/COMPLIANCEBUDGET.ajoutBudgetCompliance',[ControllerComplianceBudget::class,'ajoutBudgetCompliance'])->name('COMPLIANCEBUDGET.ajoutBudgetCompliance');
Route::match(['get', 'post'],'/COMPLIANCEBUDGET.detailBudgetNorme',[ControllerComplianceBudget::class,'detailBudgetNorme'])->name('COMPLIANCEBUDGET.detailBudgetNorme');
Route::match(['get', 'post'],'/COMPLIANCEBUDGET.modifBudgetReel',[ControllerComplianceBudget::class,'modifBudgetReel'])->name('COMPLIANCEBUDGET.modifBudgetReel');


 /*-------------------------------------------------------------PPMEETING---------------------------------------------------------*/
 Route::get('listeDemandeForPpmeeting', [ControllerPpmeeting::class, 'listeDemandeForPpmeeting'])->name('LRP.listeDemandeForPpmeeting');
 Route::post('ajoutedisponibilite', [ControllerPpmeeting::class, 'ajoutedisponibilite'])->name('LRP.ajoutedisponibilite');
 Route::post('modifdisponibilite', [ControllerPpmeeting::class, 'modifdisponibilite'])->name('LRP.modifdisponibilite');

/*------------------PP_MEETING_MAELA-------------------------------*/
require __DIR__.'/LRP/web_ppm.php';
 Route::post('ajoutPPMeeting', [ControllerPpmeeting::class, 'ajoutPPMeeting'])->name('LRP.ajoutPPMeeting');
