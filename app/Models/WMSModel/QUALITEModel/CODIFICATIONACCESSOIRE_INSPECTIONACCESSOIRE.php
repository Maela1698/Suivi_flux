<?php

namespace App\Models\WMSModel\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CODIFICATIONACCESSOIRE_INSPECTIONACCESSOIRE extends Model
{
    use HasFactory;
    protected $table = 'codificationaccessoire_inspectionaccessoire';
    protected $fillable = [
        'idcodificationaccessoire',
        'idinspectionaccessoire',
        'defectquantity',
        'remarque',
    ];

    // Disable auto-incrementing ID behavior
    public $incrementing = false;

    // Disable timestamps
    public $timestamps = false;

    // If your primary key is composite (combination of identreetissu and idcellule), you can set them like this:
    protected $primaryKey = null;

    public static function getValidationRules($id = null)
    {
        $rules = [
            'idcodificationaccessoire' => 'required|numeric',
            'idinspectionaccessoire' => 'required|numeric',
            'defectquantity' => 'required|numeric',
            'remarque' => 'nullable',

        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
