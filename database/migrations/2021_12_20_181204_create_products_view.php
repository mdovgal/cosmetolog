<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
          CREATE VIEW v_products AS
          (
            select
       p.id,
       p.category_id,
       c.title as category_title,
       p.type_id,
       pt.type_title,
       p.brand_id,
       b.brand_title,
       b.country_title,
       p.title,
       p.short_description,
       p.description,
       p.composition,
       p.price,
       p.image,
       p.image_preview,
       p.items_on_stock as items_total,
       COALESCE(ci.items_total, 0) as items_on_pending,
       (p.items_on_stock - COALESCE(ci.items_total, 0)) as items_on_stock
from products p
join catalog c on c.id = p.category_id
join product_types pt on pt.id = p.type_id
join v_brands b on b.id = p.brand_id
left join v_cart_items ci on ci.product_id = p.id
          )
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('v_products');
    }
}
