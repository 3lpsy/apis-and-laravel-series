<?php

use Illuminate\Database\Seeder;

class AccessControlTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $truncate = ['user_role', 'role_permission', 'users', 'permissions', 'roles'];

        collect($truncate)->each(function($table){
            \DB::table($table)->truncate();
        });

        $sudo = factory(\App\Models\User::class)->create([
            'name' => "Sudo",
            'email' => 'sudo@application.dev'
        ]);

        $sudoRole = factory(\App\Models\Role::class)->create([
            'name' => "sudo"
        ]);

        $sudoPermission = factory(\App\Models\Permission::class)->create([
            'name' => "sudo"
        ]);

        $sudo->roles()->save($sudoRole);

        $sudoRole->permissions()->save($sudoPermission);

        $admin = factory(\App\Models\User::class)->create([
            'name' => "Margaret",
            'email' => 'admin@application.dev'
        ]);

        $adminRole = factory(\App\Models\Role::class)->create([
            'name' => "admin"
        ]);


        $adminPermissions = collect([
            "view_admin",
            "create_user",
            "edit_user",
            "delete_user",
            "create_user_role",
            "edit_user_role",
            "delete_user_role",
            "create_permission",
            "edit_permission",
            "delete_permission",
            "create_role_permission",
            "edit_role_permission",
            "delete_role_permission",
        ])->map(function($permission) {
            return factory(\App\Models\Permission::class)->create([
                'name' => $permission
            ]);
        });

        $admin->roles()->save($adminRole);

        $adminRole->permissions()->saveMany($adminPermissions);

        $writer = factory(\App\Models\User::class)->create([
            'name' => "Oliver"
        ]);

        $writerRole = factory(\App\Models\Role::class)->create([
            'name' => "writer"
        ]);

        $writerPermissions = collect([
            "view_admin",
            "my_edit_user"
        ])->map(function($permission) {
            return factory(\App\Models\Permission::class)->create([
                'name' => $permission
            ]);
        });
    }
}
