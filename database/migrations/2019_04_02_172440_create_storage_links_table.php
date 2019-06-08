<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_links', function (Blueprint $table) {
            $table->string('linkable_type');
            $table->unsignedBigInteger('linkable_id');
            $table->string('linkable_caller_name');
            $table->timestamps();

            $table->unsignedBigInteger('storage_id')->index();
            $table->foreign('storage_id')
                ->references('id')->on('storage')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->primary(['linkable_type', 'linkable_id', 'linkable_caller_name'], 'storage_links_type_id_caller_name_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_pivot');
    }
}
