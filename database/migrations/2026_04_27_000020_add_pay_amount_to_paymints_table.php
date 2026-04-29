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
        Schema::table('paymints', function (Blueprint $table) {
            if (!Schema::hasColumn('paymints', 'pay_amount')) {
                $table->integer('pay_amount')->default(0)->after('invoice_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paymints', function (Blueprint $table) {
            if (Schema::hasColumn('paymints', 'pay_amount')) {
                $table->dropColumn('pay_amount');
            }
        });
    }
};
