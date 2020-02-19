<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table="person";
    protected $primaryKey = 'id';
    /**
     * @var array
     */

    protected $fillable = [
       'name', 'lastName', 'email', 'ci',
    ];
}
