<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormInput extends Model
{
    use HasFactory;

    // Define the table name 
    protected $table = 'form_input';

    // Define the primary key if it's not 'id'
    protected $primaryKey = 'id';

    // Set timestamps to false if the table doesn't have 'created_at' and 'updated_at'
    public $timestamps = true;

    // Define the fillable attributes
    protected $fillable = [
        'form_id', 'type', 'label', 'name','id_index'
    ];

    // Define the relationship with the 'form' model
    // public function form()
    // {
    //     return $this->belongsTo(Form::class);
    // }
}
