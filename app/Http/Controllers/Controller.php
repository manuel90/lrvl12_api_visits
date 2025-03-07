<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;


abstract class Controller
{
    //
    public function ok($message)
    {
        return response()->json(array('message' => $message), Response::HTTP_OK);
    }
}
