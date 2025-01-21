<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionWMS extends Model
{
    use HasFactory;

    protected $table = 'sectionwms';

    protected $fillable = [
        'section',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'section' => 'required|unique:sectionwms',
        ];

        $messages = [
            'section.required' => 'S\'il vous plait remplissez ce champ',
        ];

        return compact('rules', 'messages');
    }
}
