<?php

namespace Lomkit\Rest\Tests\Support\Http\Controllers;

use Lomkit\Rest\Http\Controllers\Controller;
use Lomkit\Rest\Tests\Support\Rest\Resources\OrPerimeterModelResource;

class OrPerimeterModelController extends Controller
{
    public static $resource = OrPerimeterModelResource::class;
}
