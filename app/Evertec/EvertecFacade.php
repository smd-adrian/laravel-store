<?php 

namespace App\Evertec;

use Illuminate\Support\Facades\Facade;

class EvertecFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Evertec::class;
    }
}