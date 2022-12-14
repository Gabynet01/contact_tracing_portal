<?php

use App\SpecialUsers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_user_id');
            $table->string('username');
            $table->string('password');
            $table->string('full_name');
            $table->string('email');
            $table->string('job_position');
            $table->string('app_user_role');
            $table->string('created_by');
            $table->timestamps();
        });

        $users =  [

            //  USERS
            [
                'app_user_id' => 'XccVnGher8',
                'username' => 'gabriel.gyandoh',
                'password' => 'gabynet75',
                'full_name' => 'Gabriel Gyandoh',
                'email' => 'gabriel.gyandoh@diamedghana.com',
                'job_position' => 'Manager',
                'app_user_role' => 'Super Admin',
                'created_by' => 'gabriel.gyandoh',
            ]
        ];
    
            foreach($users as $user){
                $new_user = new SpecialUsers();
                $new_user->app_user_id = $user['app_user_id'];
                $new_user->full_name = $user['full_name'];
                $new_user->username = $user['username'];
                $new_user->password = $user['password'];
                $new_user->job_position = $user['job_position'];
                $new_user->app_user_role = $user['app_user_role'];
                $new_user->email = $user['email'];
                $new_user->created_by = $user['created_by'];
                $new_user->save();
            }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
