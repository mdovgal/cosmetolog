<?php

namespace App\Http\Controllers\Api;

use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CatalogResource;

use App\Catalog;
use App\Product;
use App\ProductTypes;
use App\Brands;
use App\Attributes;

class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(
            Product::orderBy('name', 'asc')
                ->paginate(10)
        );
    }

    public function find()
    {
        return ProductResource::collection(
            Product::orderBy('name', 'asc')
                ->paginate(10)
        );
    }

    public function save(Request $request)
    {
//dd($request->all());exit();

        $data = $request->validate([
            'category_id' => 'required|numeric|gt:0',
            'type_id' => 'required|numeric|gt:0',
            'brand_id' => 'numeric',
            'title' => 'required',
            'description' => 'string|min:25',
            'composition' => 'string|min:5',
            'price' => 'required|numeric|gt:0',
            'items_on_stock' => 'required|numeric',
            'attributes' => 'array',
        ]);
        $attributes = $data['attributes'];
        unset($data['attributes']);

        $product = Product::create( $data );
        $id_product = $product->id;

        foreach ($attributes as $attr) {
            if((int)$attr){
                DB::table('product_attributes')->insert([
                    'product_id' => $id_product,
                    'attribute_id' => $attr,
                ]);
            }
        }

        // $product->articles()->delete();  // for edit product

        // todo get attributes and return resorce with attributes

        return new ProductResource( $product );
//        return new ProductResource(Product::create( $data ));

    }

    public function params()
    {
        $menuItems = Catalog::orderBy('parent_id')->orderBy('title')->get();
        $menuItems = $this->buildCategoryTree($menuItems);

        $typeItems = ProductTypes::orderBy('type_title')->get();
        $brendItems = Brands::orderBy('brand_title')->get();

        $attributesItems = Attributes::orderBy('type')->orderBy('title')->get();
        $attributesItems =  $this->buildSubGroups($attributesItems);

        $all_collections = collect([
            'data' => [
                ['catalog' => $menuItems],
                ['types' => $typeItems],
                ['brends' => $brendItems],
                ['attributes' => $attributesItems]
            ]]);
        return $all_collections;

    }

    public function buildCategoryTree($items)
    {
        $grouped = $items->groupBy('parent_id');

        foreach ($items as $item) {
            if ($grouped->has($item->id)) {
                $item->children = $grouped[$item->id];
            }
        }

        return $items->where('parent_id', null);
    }

    public function buildSubGroups($items)
    {
        $grouped = $items
            ->groupBy('type')
            ->map(function ($subCollection) {
                return $subCollection->chunk(4); // put your group size
            });
        ;
        return $grouped;
    }
}
