<?php

namespace App\Models\LRP\PP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VPPMeeting extends Model
{
    use HasFactory;

    protected $table = 'v_ppmeeting';

    protected $fillable = [
        'details_meeting_etat'
    ];

    // public function getStyleAttribute()
    // {
    //     if($this->details_meeting_etat){
    //         return [
    //             'text-color-class' => 'fini-text-color', 
    //             'background-color-class' => 'fini-back-ground-color', 
    //             'ball-color' => '#25D366', 
    //         ];
    //     }
    //     return [
    //         'text-color-class' => 'huhu', 
    //         'background-color-class' => 'haha', 
    //         'ball-color' => '', 
    //     ];
    // }
}
