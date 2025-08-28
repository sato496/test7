<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::table('sales', function (Blueprint $table) {
        $table->integer('price')->after('quantity'); // ← 商品価格を追加
    });
}

public function down()
{
    Schema::table('sales', function (Blueprint $table) {
        $table->dropColumn('price');
    });
}
};
