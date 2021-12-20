<?php

namespace App\Http\Controllers\Api;

use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CatalogResource;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

use App\Catalog;
use App\Product;
use App\ProductView;
use App\ProductTypes;
use App\Brands;
use App\Attributes;
use App\ProductAttributes;

class ProductController extends Controller
{
    public function index( $category_id )
    {
        $productsItems = ProductView::where('category_id', $category_id)
            ->orderBy('title', 'asc')
            ->paginate(12)
            //->get()
            ;

        $productsItems = $productsItems
            ->groupBy('category_id')
            ->map(function ($subCollection) {
                return $subCollection->chunk(3); // put your group size
            });
        ;

        $all_collections = collect([
            'data' => $productsItems]);
        return $all_collections;
    }

    public function find( $product_id )
    {
        return ProductResource::collection(
            ProductView::where('id', $product_id)->get()
        );
    }

    public function update(Product $product, Request $request){
        $old_data = Product::where('id', $request->id)->get()->toArray();
        $old_image = $old_data[0]['image'];

        $current_product = Product::find( $request->id );

        $validate_rules = [
            'category_id' => 'required|numeric|gt:0',
            'type_id' => 'required|numeric|gt:0',
            'brand_id' => 'numeric',
            'title' => 'required',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'composition' => 'required|string',
            'price' => 'required|numeric|gt:0',
            'items_on_stock' => 'required|numeric|gt:0',
            'attributes' => 'array'
        ];

        if( !empty($request->attachment) ){
            $validate_rules['attachment'] = 'string';
        }

        $data = $request->validate( $validate_rules );

        $attributes = $data['attributes'];
        unset($data['attributes']);

        if( !empty($request->attachment) ){
            $attachment = $data['attachment'];
            unset($data['attachment']);

            if($upload_result = $this->saveAttachment( $attachment )){
                $data['image'] = $upload_result;
                $data['image_preview'] = $upload_result;

                if(!empty($old_image)){
                    $path = getcwd();
                    if( file_exists($file_for_delete = $path . $old_image) ){
                        unlink( $file_for_delete );
                    }
                }
            };
        }

        $res = $current_product->update( $data );
        $current_product->attributes()->delete();

        foreach ($attributes as $attr) {
            if((int)$attr){
                DB::table('product_attributes')->insert([
                    'product_id' => $request->id,
                    'attribute_id' => $attr,
                ]);
            }
        }

        return new ProductResource( $current_product );
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|numeric|gt:0',
            'type_id' => 'required|numeric|gt:0',
            'brand_id' => 'numeric',
            'title' => 'required',
            'short_description' => 'string|min:15',
            'description' => 'string|min:25',
            'composition' => 'string|min:5',
            'price' => 'required|numeric|gt:0',
            'items_on_stock' => 'required|numeric',
            'attachment' => 'string',
            'attributes' => 'array',
        ]);

        $attributes = $data['attributes'];
        unset($data['attributes']);

        $attachment = $data['attachment'];
        unset($data['attachment']);

        if($upload_result = $this->saveAttachment( $attachment )){
            $data['image'] = $upload_result;
            $data['image_preview'] = $upload_result;
        };

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

        return new ProductResource( $product );

        return ProductResource::collection(
            Product::where('id', $id_product)
                ->with('attributes')
                ->get()
        );

        // $product->articles()->delete();  // for edit product

        // todo get attributes and return resorce with attributes

        return new ProductResource( $product );
//        return new ProductResource(Product::create( $data ));

    }

    public function delete( $product_id )
    {
        $old_data = Product::where('id', $product_id)->get()->toArray();
        $old_image = $old_data[0]['image'];

        $current_product = Product::find( $product_id );

        $current_product->attributes()->delete();
        $current_product->delete();

        if(!empty($old_image)){
            $path = getcwd();
            if( file_exists($file_for_delete = $path . $old_image) ){
                unlink( $file_for_delete );
            }
        }

        return response(null, 204);
    }

    protected function  saveAttachment($data = null) {
        if(empty($data)) return false;
        $path = getcwd();
        $path_url = '/img/products/';

        if(!is_dir($full_path = $path . $path_url)){
            mkdir($full_path);
            chmod($full_path, 0777);
        }

        $file_name = uniqid();

        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                throw new \Exception('invalid image type');
            }
            $data = str_replace( ' ', '+', $data );
            $data = base64_decode($data);

            if ($data === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }
        $file_name = "{$file_name}.{$type}";
        $full_filename = $full_path . $file_name;
        file_put_contents($full_filename, $data);

        if(file_exists($full_filename) && filesize($full_filename)){
            chmod($full_filename, 0777);
            return $path_url . $file_name;
        }
    }

    public function params( $product_id = null)
    {
        $menuItems = Catalog::orderBy('parent_id')->orderBy('title')->get();
        $menuItems = $this->buildCategoryTree($menuItems);

        $typeItems = ProductTypes::orderBy('type_title')->get();
        $brendItems = Brands::orderBy('brand_title')->get();

        $attributesItems = Attributes::orderBy('type')->orderBy('title')->get();
        $attributesItems =  $this->buildSubGroups($attributesItems);

        $attributesItemSelected = [];
        if( !empty($product_id)){
            $attributesItemSelected = ProductAttributes::where('product_id', $product_id)->get();
        }

        $all_collections = collect([
            'data' => [
                ['catalog' => $menuItems],
                ['types' => $typeItems],
                ['brends' => $brendItems],
                ['attributes' => $attributesItems],
                ['attributes_selected' => $attributesItemSelected],
            ]]);
        return $all_collections;

    }

    public function params_view( $product_id = null)
    {
        $product_data = Product::where('id', $product_id)->get()->toArray();
        $product = $product_data[0];

        $category = Catalog::where('id', $product['category_id'])->get()->toArray();
        $type = ProductTypes::where('id', $product['type_id'])->get()->toArray();
        $brend = Brands::where('id', $product['brand_id'])->get()->toArray();

        $all_collections = collect([
            'data' => [
                ['catalog' => $category[0]['title']],
                ['types' => $type[0]['type_title']],
                ['brends' => $brend[0]['brand_title'] . ' (' . $brend[0]['country_title'] . ')'],
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

    public function buildProductRowGroups($items)
    {
        $grouped = $items
            ->map(function ($subCollection) {
                return $subCollection->chunk(4); // put your group size
            });
        ;
        return $grouped;
    }
}
