<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovernmentProgram extends Model
{
    use HasFactory;

    protected $fillable =['name', 'description', 'status', 'start_date', 'end_date', 'created_by'];
}
