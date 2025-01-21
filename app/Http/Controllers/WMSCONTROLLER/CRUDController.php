<?php

namespace App\Http\Controllers\WMSCONTROLLER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CRUDController extends Controller
{
    public function inserer(Request $request, $modelName)
    {
        $name = 'App\Models\WMSModel\\'.$modelName;
        $data = $request->all();
        $validationData = $name::getValidationRules();
        $rules = $validationData['rules'];
        $messages = $validationData['messages'];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            $model = new $name($data);
            $res = $model->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement des données, veuillez réessayer.'.$e;

            return back()->withInput()->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }

    //Fonction pour mettre à jour les données des tables dans la base
    public function modifier(Request $request, $modelName, $id)
    {
        $name = 'App\Models\WMSModel\\'.$modelName;
        $data = $request->except('id');
        $validationData = $name::getValidationRules($id);
        $rules = $validationData['rules'];
        $messages = $validationData['messages'];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $model = $name::find($id);
            if (! $model) {
                return back()->with('error', $modelName.' non trouvé');
            }
            $model->fill($data);
            $res = $model->save();
        } catch (\Exception $e) {
            $errorMessage = 'Une anomalie est survenue pendant le processus de mise à jour des données, veuillez réessayer.';

            return back()->withInput()->withErrors(['error' => $errorMessage]);
            //return $exceptionMessage;
        }
        $message = $res ? 'La mise à jour des données a été effectuée conformément au processus prévu.' : 'Le processus de mise à jour des données n\'a pu aboutir.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }

    //Fonction pour supprimer des données dans la base
    public function supprimer($modelName, $id)
    {
        $name = 'App\Models\WMSModel\\'.$modelName;
        $model = $name::find($id);
        if (! $model) {
            return back()->with('error', $modelName.' non trouvé');
        }

        // Update the 'etat' column to 1
        $model->etat = 1;
        $res = $model->save();

        $message = $res ? 'L\'éléments choisis ont été supprimer avec succès.' : 'Une anomalie est survenue pendant le processus de suppression.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
}
