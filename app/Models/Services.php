<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $fillable =['name', 'description', 'status','created_by', 'government_program_id'];

    public function governmentProgram(){
        return $this->belongsTo(GovernmentProgram::class);
    }
}
