<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;


class book extends Model
{

    protected $table='book';

    protected  $primaryKey='book_id';

    public  $timestamps=false;



}
