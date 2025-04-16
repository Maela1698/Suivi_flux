<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VSectionCompliance extends Model
{
    use HasFactory;

    protected $table = 'v_section_compliance';

    public $timestamps = false;
}
