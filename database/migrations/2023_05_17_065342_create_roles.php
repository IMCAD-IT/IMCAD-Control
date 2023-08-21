<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'cotrrsa hombres']);
        $role3 = Role::create(['name' => 'cotrrsa mujeres']);
        $role4 = Role::create(['name' => 'administracion']);
        
        $users = User::where("jobPosition", "ADMINISTRADOR-MASTER")->get();
        foreach ($users as $user) {
            $user->assignRole($role1);
        }

        $users = User::where("jobPosition", "COTRRSA HOMBRES")->get();
        foreach ($users as $user) {
            $user->assignRole($role2);
        }

        $users = User::where("jobPosition", "COTRRSA MUJERES")->get();
        foreach ($users as $user) {
            $user->assignRole($role3);
        }

        $users = User::where("jobPosition", "ADMINISTRACION")->get();
        foreach($users as $user){
            $user->assignRole($role4);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        $role1 = Role::where('name', 'admin')->first();
        $role2 = Role::where('name', 'cotrrsa hombres')->first();
        $role3 = Role::where('name', 'cotrrsa mujeres')->first();
        $role4 = Role::where('name', 'administracion')->first();

        if ($role1) {
            $role1->delete();
        }

        if ($role2) {
            $role2->delete();
        }

        if ($role3) {
            $role3->delete();
        }

        if ($role4) {
            $role4->delete();
        }

    }
};
