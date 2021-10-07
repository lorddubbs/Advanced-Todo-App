<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
      * @OA\Info(
      *      version="1.0.0",
      *      title="Simple TODO  API Documentation",
      *      description="Service Documentation",
      *      @OA\Contact(
      *          email="info@std.com"
      *      ),
      *      @OA\License(
      *          name="Apache 2.0",
      *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
      *      )
      * ),
      * @OA\Openapi(openapi="3.0.2"),
      *
      * @OA\Server(
      *      url=L5_SWAGGER_CONST_HOST,
      *      description="STD API Server"
      * )
    */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
