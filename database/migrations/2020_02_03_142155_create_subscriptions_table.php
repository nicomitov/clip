<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subscription_type_id');
            $table->unsignedBigInteger('client_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->foreign('subscription_type_id')
                    ->references('id')
                    ->on('subscription_types')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::create('subscription_client_email', function (Blueprint $table) {
            $table->unsignedBigInteger('client_email_id');
            $table->unsignedBigInteger('subscription_id');

            $table->foreign('client_email_id')
                    ->references('id')
                    ->on('client_emails')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('subscription_id')
                    ->references('id')
                    ->on('subscriptions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::create('subscription_topic', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription_id');
            $table->unsignedBigInteger('topic_id');

            $table->foreign('subscription_id')
                    ->references('id')
                    ->on('subscriptions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('topic_id')
                    ->references('id')
                    ->on('topics')
                    ->onUpdate('cascade')
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
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('subscription_client_email');
        Schema::dropIfExists('subscription_topic');
    }
}
