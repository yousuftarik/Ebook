<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('title');
            $table->string('summary')->nullable();
            $table->integer('stock')->nullable();
            $table->string('description')->nullable();
            $table->integer('old_price');
            $table->integer('page');
            $table->string('country');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->string('language');
            $table->unsignedBigInteger('publisher_id')->nullable();
            $table->integer('discount')->default(0);
            $table->string('cover')->nullable();
            $table->string('editor')->nullable();
            $table->string('edition')->nullable();
            $table->string('isbn')->nullable();
            $table->integer('upcoming')->default(0);
            $table->integer('quantity')->default(1);
            $table->timestamps();

        //    ; // foreign key
            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('cascade');

            // foreign key
            $table->foreign('publisher_id')
            ->references('id')
            ->on('publishers')
            ->onDelete('cascade');

             // foreign key
             $table->foreign('author_id')
             ->references('id')
             ->on('authors')
             ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
