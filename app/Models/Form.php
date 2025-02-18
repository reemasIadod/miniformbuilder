<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    // Define the table name (optional, as Laravel will use the plural form of the model name by default)
    protected $table = 'form';

    // Define the fillable fields (these are the columns that can be mass-assigned)
    protected $fillable = [
        'label',
        'bg_color',
        'font_family',
        'has_form_labels',
    ];

}