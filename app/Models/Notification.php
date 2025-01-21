<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';

    protected $fillable = [
        'id_demande',
        'dateentree',
        'message',
        'etat',
    ];

    public function insertDemandeBroadMachine($idDC, $dateEntree,$message)
    {
        DB::table('notification')->insert([
            'id_demande' => $idDC,
            'dateentree' => $dateEntree,
            'message' => $message,
            'etat' => 0
        ]);
    }

    public static function getAllNotification()
    {
        $select = DB::select('select * from v_notification where etat=0');
        return self::hydrate($select);
    }
}
