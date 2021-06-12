<?php

use App\Models\MessageModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MessageModel::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->text('message')->nullable(true);
            $table->string('module');
            $table->string('action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(MessageModel::TABLE_NAME);
    }
}
