<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{

    protected $table='comments';

    protected  $primaryKey='book_id';

    public  $timestamps=false;

}
