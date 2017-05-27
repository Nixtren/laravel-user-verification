<?php
/**
 * This file is part of Jrean\UserVerification package.
 *
 * (c) Jean Ragouin <go@askjong.com> <www.askjong.com>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddVerificationToUserTable extends Migration
{
    /**
     * Determine the user table name.
     *
     * @return string
     */
    public function getUserTableName()
    {
        $user_model = config('auth.providers.users.model', App\User::class);

        return (new $user_model)->getTable();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->getUserTableName(), function (Blueprint $table) {
            $table->boolean('verified')->default(false);
            $table->string('verification_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->getUserTableName(), function (Blueprint $table) {
            if (Schema::hasColumn($this->getUserTableName(), 'verified'))
            {
                Schema::table($this->getUserTableName(), function(BLueprint $table)
                {
                    $table->dropColumn('verified');
                });
            }
            if (Schema::hasColumn($this->getUserTableName(), 'verification_token'))
            {
                Schema::table($this->getUserTableName(), function(BLueprint $table)
                {
                    $table->dropColumn('verification_token');
                });
            }
        });
    }
}
