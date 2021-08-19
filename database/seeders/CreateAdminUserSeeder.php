<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $permissions = [
            'invoice',
            'invoice_paid',
            'invoice_paid_partail',
            'invoice_unpaid',
            'invoice_archive',
            'report',
            'report invoice',
            'report customer',
            'user',
            'user menu',
            'user permission',
            'setting',
            'product',
            'section',


            'add_invoice',
            'delete invoice',
            'EXCEL',
            'change payment',
            'update invoice',
            'print invoice',
            'add_file',
            'delete_file',

            'add user',
            'update user',
            'delete user',

            'show permission',
            'add permission',
            'update permission',
            'delete permission',

            'add product',
            'update product',
            'delete product',

            'add section',
            'update section',
            'delete section',
            'notifications',

        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }


        $user = User::create([
            'name' => 'mahmoud khairy',
            'email' => 'khairymahmoud795@gmail.com',
            'password' => bcrypt('123456'),
            'roles_name' => 'owner',
            'Status' => 'active',
        ]);

        $role = Role::create(['name' => 'owner']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

    }
}
