<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            select ci.product_id, cart.status, sum(ci.count_items) as items_total
            from cart_items ci
            join cart on cart.id = ci.cart_id
            group by ci.product_id, cart.status
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('v_cart_items');
    }
}
