<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionCompliance extends Model{
    use HasFactory;

    protected $table = 'section_compliance';

    public $timestamps = false;
}