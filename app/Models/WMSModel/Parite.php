<?php

namespace App\Models\WMSModel;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parite extends Model
{
    use HasFactory;

    protected $table = 'parite';

    protected $fillable = [
        'dateparite',
        'deviseeuro',
        'devisedollar',
        'valeur',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'dateparite' => ['required', function ($attribute, $value, $fail) use ($id) {
                if (! self::isUniqueDateParite($value, $id)) {
                    $fail('Il y a déjà une parité pour ce mois.');
                }
            }],
            'deviseeuro' => 'required|numeric',
            'devisedollar' => 'required|numeric',
            'valeur' => 'required|numeric',
        ];

        $messages = [
            'dateparite.required' => 'S\'il vous plait remplissez ce champ',
            'deviseeuro.required' => 'S\'il vous plait remplissez ce champ',
            'devisedollar.required' => 'S\'il vous plait remplissez ce champ',
            'valeur.required' => 'S\'il vous plait remplissez ce champ',
            'dateparite.unique' => 'Il y a déjà une parité pour ce mois.',
        ];

        return compact('rules', 'messages');
    }

    public static function isUniqueDateParite($date, $id = null)
    {
        $parsedDate = Carbon::parse($date);
        $query = self::whereYear('dateparite', $parsedDate->year)
            ->whereMonth('dateparite', $parsedDate->month);

        if ($id) {
            $query->where('id', '!=', $id);
        }

        return ! $query->exists();
    }
}
