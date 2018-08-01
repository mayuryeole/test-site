<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyExchangeRate extends Model
{

    protected $fillable = ['inr','usd','cad','euro','gbp'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

}