<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
//use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\JsonResponse;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class GeneralException extends Exception
{
  /**
   * Report the exception.
   */
  public function report(): void
  {
    Log::warning($this->getMessage());
  }

  /**
   * Render the exception into an HTTP response.
   */
  public function render(Request $request)
  {
    return response()->json(
      [
        'error' => $this->getMessage(),
      ],
      Response::HTTP_BAD_REQUEST
    );
  }
}
