<?php

namespace App\Models\COMPLIANCE;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VPlanAction extends Model
{
    use HasFactory;

    protected $table = 'vue_plans_action';

    protected $fillable = ['deadline','dateavancement','avancement','datedebut'];

    public function getDeadlineAttribute($value){
        return Carbon::parse($value)->format('d/m/y');
    }

    public function getDateavancementAttribute($value){
        return Carbon::parse($value)->format('d/m/y');
    }
    
    public function getAvancementAttribute($value){
        return $value !== null ? $value : 0;
    }

    public function getDatedebutAttribute($value){
        return Carbon::parse($value)->format('d/m/y');
    }
}
