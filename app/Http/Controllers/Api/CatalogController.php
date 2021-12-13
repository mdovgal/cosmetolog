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

        $menuItems = Catalog::orderBy('parent_id')->orderBy('title')->get();
        $menuItems = $this->buildTree($menuItems);
        return CatalogResource::collection( $menuItems );
    }

    public function update(Catalog $catalog, Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
//            'parent_id' => 'required',
        ]);

        $catalog->update($data);

        return new CatalogResource($catalog);
    }

    public function buildTree($items)
    {
        $grouped = $items->groupBy('parent_id');

        foreach ($items as $item) {
            if ($grouped->has($item->id)) {
                $item->children = $grouped[$item->id];
            }
        }

        return $items->where('parent_id', null);
    }
}
