<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    //
     protected $fillable = ['name','idno','mobile','kra_pin'];

     // public function payments(){

     // 	return $this->hasMany(Payment::class);
     // }

     // public function transactions(){

     // 	return $this->hasMany('App\Transaction');
     // }
     //  public function plotnos(){

     // 	return $this->hasMany(Plotno::class);
     // }
}
