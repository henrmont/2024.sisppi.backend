<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function getLinks(): JsonResponse
    {
        $links = Link::all();

        return response()->json(['data' => $links]);
    }
}
