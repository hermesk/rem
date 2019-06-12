<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commonPermissionList = [
            [
                "slug" => "change_password",
                "name" => "Change Password",
                "group" => "Common"
            ],
            [
                "slug" => "user.dashboard",
                "name" => "Dashboard",
                "group" => "Common"
            ],
            [
                "slug" => "lockscreen",
                "name" => "Lock Screen",
                "group" => "Common"
            ],
            [
                "slug" => "logout",
                "name" => "Logout",
                "group" => "Common"
            ],
            [
                "slug" => "profile",
                "name" => "Profile",
                "group" => "Common"
            ],
            [
                "slug" => "user.notification_unread",
                "name" => "Notification View",
                "group" => "Common"
            ],
            [
                "slug" => "user.notification_read",
                "name" => "Notification View",
                "group" => "Common"
            ],
            [
                "slug" => "user.notification_all",
                "name" => "Notification View",
                "group" => "Common"
            ]

        ];

        $administratorPermissionList = [

            [   "slug" => "user.store",
                "name" => "User Create",
                "group" => "Administration"
            ],
            [   "slug" => "user.index",
                "name" => "User View",
                "group" => "Administration"
            ],
            [   "slug" => "user.create",
                "name" => "User Create",
                "group" => "Administration"
            ],
            [   "slug" => "user.status",
                "name" => "User Edit",
                "group" => "Administration"
            ],
            [   "slug" => "user.show",
                "name" => "User View",
                "group" => "Administration"
            ],
            [   "slug" => "user.update",
                "name" => "User Edit",
                "group" => "Administration"
            ],
            [   "slug" => "user.destroy",
                "name" => "User Delete",
                "group" => "Administration"
            ],
            [   "slug" => "user.edit",
                "name" => "User Edit",
                "group" => "Administration"
            ],
            [   "slug" => "user.permission",
                "name" => "User Edit",
                "group" => "Administration"
            ]
        ];

        $onlyAdminPermissions = [
                      
            [ "slug" => "settings.institute",
                "name" => "Institute Edit",
                "group" => "Admin Only"
            ],
            [   "slug" => "user.role_index",
                "name" => "Role View",
                "group" => "Admin Only"
            ],
            [   "slug" => "user.role_destroy",
                "name" => "Role Delete",
                "group" => "Admin Only"
            ],
            [   "slug" => "user.role_create",
                "name" => "Role Create",
                "group" => "Admin Only"
            ],
            [   "slug" => "user.role_store",
                "name" => "Role Create",
                "group" => "Admin Only"
            ],
            [   "slug" => "user.role_update",
                "name" => "Role Edit",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.user_index",
                "name" => "System Admin View",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.user_create",
                "name" => "System Admin Create",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.user_status",
                "name" => "System Admin Edit",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.user_store",
                "name" => "System Admin Create",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.user_update",
                "name" => "System Admin Edit",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.user_destroy",
                "name" => "System Admin Delete",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.user_edit",
                "name" => "System Admin Edit",
                "group" => "Admin Only"
            ],
            [   "slug" => "administrator.user_password_reset",
                "name" => "User Password Reset",
                "group" => "Admin Only"
            ],
          
     
            
        ];
  
      $userPermissions =[
               [
                    "slug" => "clients.index",
                    "name" => "Client View",
                    "group" => "Client"
                ],
                 [
                    "slug" => "clients.create",
                    "name" => "Client Create",
                    "group" => "Client"
                ],
                 [
                    "slug" => "clients.store",
                    "name" => "Client Create",
                    "group" => "Client"
                ],
                 [
                    "slug" => "clients.edit",
                    "name" => "Client Edit",
                    "group" => "Client"
                ],
                 [
                    "slug" => "clients.update",
                    "name" => "Client Update",
                    "group" => "Client"
                ],
                 [
                    "slug" => "clients.destroy",
                    "name" => "Client Delete",
                    "group" => "Client"
                ],

      ];

        //merge all permissions and insert into db
        $permissions = array_merge($commonPermissionList, $administratorPermissionList, $onlyAdminPermissions,$userPermissions);

        echo PHP_EOL , 'seeding permissions...';

        Permission::insert($permissions);


        echo PHP_EOL , 'seeding role permissions...';
        //now add admin role permissions
        $admin = Role::where('name', 'admin')->first();
        $permissions = Permission::get();
        $admin->permissions()->saveMany($permissions);

        //now add other roles common permissions
        $slugs = array_map(function ($permission){
            return $permission['slug'];
        }, $commonPermissionList);

        $permissions = Permission::whereIn('slug', $slugs)->get();

        $roles = Role::where('name', '!=', 'admin')->get();
        foreach ($roles as $role){
            echo PHP_EOL , 'seeding '.$role->name.' permissions...';
            $role->permissions()->saveMany($permissions);
        }



    }
}
