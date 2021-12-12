<?php

namespace App\Http\Controllers\Api;

use App\Catalog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CatalogResource;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function index()
    {
        return CatalogResource::collection( Catalog::orderBy('title')->get() );
//        return CatalogResource::collection(
//            Catalog::orderBy('parent_id', 'asc')
//        );
    }
}
