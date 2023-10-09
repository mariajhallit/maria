<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;



class RolesAndPermissionsSeeder extends Seeder
{ 
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Reset cached roles and permissions
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //
        $superRole = Role::firstOrCreate(['name' => 'super']); 

       
        $manageUsersPermission = Permission::firstOrCreate(['name' => 'manage_users']);
        $manageCategoriesPermission = Permission::firstOrCreate(['name' => 'manage_categories']);
        $manageProductsPermission = Permission::firstOrCreate(['name' => 'manage_products']);
       
        $superRole->givePermissionTo([$manageCategoriesPermission, $manageProductsPermission,$manageUsersPermission]);
        $user = User::find(1); 
        $user->assignRole($superRole);
    }
}
