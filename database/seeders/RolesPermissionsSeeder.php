<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */



    public function run(): void
    {
        //
        //create Roles
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $adminRole=Role::create(['name' => 'admin']);
        $clientRole=Role::create(['name' => 'client']);
        $premiumClientRole=Role::create(['name' => 'premium_client']);
        $superAdminRole=Role::create(['name' => 'super_admin']);

        //Define permissions

$permissions = [

    //email verification
//    'verification.verify',
//    'verification.send',

    // auth
    // no register for superadmin
//    'auth.register',
//    'auth.login',
//    'auth.logout',
//    'auth.refresh',
//    'auth.me',
//    'auth.forgetPassword',
//    'auth.resetPassword',
//    'auth.checkCode',

    // profile
    'profile.get_my_profile',
    'profile.create',
    'profile.show',
    'profile.update',
    'profile.delete',

    // user
    'user.getUserByEmail',
    'user.getUsers',
    'user.create',
    'user.show',
    'user.update',
    'user.delete',
    'user.assignUserRole',
    'user.upgradeToPremium',

    // property
    'property.getProperty',
    'property.getUserProperties',
    'property.create',
    'property.getAttributes',
    'property.update',
    'property.delete',

    // ad
    'ad.create',
    'ad.activate',
    'ad.show',
    'ad.unactivate',
    'ad.getAdsByPropertyType',
    'ad.getUserAds',
    'ad.activateSelectedAds',
    'ad.delete',
    'ad.nearToYou',
    'ad.search',
    'ad.recommend',

    // block
    'block.block',
    'block.unblock',
    'block.index',

    // report
    'report.index',
    'report.create',
    'report.show',
    'report.showAdReports',
    'report.delete',

    // subscriptions
    'subscriptions.allActiveSub',
    'subscriptions.index.admin',
    'subscriptions.deactivate.admin',
    'subscriptions.show.admin',
    'subscriptions.destroy.admin',
    'subscriptions.activeSub.client',
    'subscriptions.deactivate.client',
    'subscriptions.index.client',
    'subscriptions.show.client',
    'subscriptions.store.client',
    'subscriptions.timeRemaining.client',

    // reviews
    'reviews.index',
    'reviews.store',
    'reviews.show',
    'reviews.update',
    'reviews.destroy',
    'reviews.client_destroy',
    'reviews.ad.index',
    'reviews.user.ad.index',

    // plans
    'plans.yearlyPlans',
    'plans.monthlyPlans',
    'plans.index',
    'plans.store',
    'plans.show',
    'plans.update',
    'plans.destroy',

    // favorites
    'favorite.index',
    'favorite.add',
    'favorite.remove',
    'favorite.check',
];

$adminpermissions=[
    //email verification
//    'verification.verify',
//    'verification.send',

    //auth
    //no register for admin
//    'auth.login',
//    'auth.logout',
//    'auth.refresh',
//    'auth.me',
//    'auth.forgetPassword',
//    'auth.resetPassword',
//    'auth.checkCode',

    // profile
    'profile.get_my_profile',
    'profile.create',
    'profile.show',
    'profile.update',
    'profile.delete',

    // user
    'user.getUserByEmail',
    'user.getUsers',
    'user.create',
    'user.show',
    'user.update',
    'user.delete',
    'user.upgradeToPremium',

    // property
    'property.getProperty',
    'property.getUserProperties',

    // ad
    'ad.activate',
    'ad.show',
    'ad.unactivate',
    'ad.getAdsByPropertyType',
    'ad.getUserAds',
    'ad.activateSelectedAds',
    'ad.delete',
    'ad.nearToYou',
    'ad.search',
    'ad.recommend',

    // block
    'block.block',
    'block.unblock',
    'block.index',

    // report
    'report.index',
    'report.show',
    'report.showAdReports',
    'report.delete',

    // subscriptions
    'subscriptions.allActiveSub',
    'subscriptions.index.admin',
    'subscriptions.deactivate.admin',
    'subscriptions.show.admin',
    'subscriptions.destroy.admin',

    // reviews
    'reviews.index',
    'reviews.store',
    'reviews.show',
    'reviews.update',
    'reviews.destroy',
    'reviews.client_destroy',
    'reviews.ad.index',
    'reviews.user.ad.index',

    // plans
    'plans.yearlyPlans',
    'plans.monthlyPlans',
    'plans.index',
    'plans.show',


];

$clientpermissions=[

    //email verification
//    'verification.verify',
//    'verification.send',
//    //auth
//    'auth.register',
//    'auth.login',
//    'auth.logout',
//    'auth.refresh',
//    'auth.me',
//    'auth.forgetPassword',
//    'auth.resetPassword',
//    'auth.checkCode',

    // profile
    'profile.get_my_profile',
    'profile.create',
    'profile.show',
    'profile.update',
    'profile.delete',

    // user
    'user.show',
    'user.update',

    // property
    'property.getProperty',
    'property.getUserProperties',
    'property.create',
    'property.getAttributes',
    'property.update',
    'property.delete',

    // ad
    'ad.create',
    'ad.activate',
    'ad.show',
    'ad.unactivate',
    'ad.getAdsByPropertyType',
    'ad.getUserAds',
    'ad.activateSelectedAds',
    'ad.delete',
    'ad.nearToYou',
    'ad.search',
    'ad.recommend',

    // report
    'report.create',


    // subscriptions
    'subscriptions.activeSub.client',
    'subscriptions.deactivate.client',
    'subscriptions.index.client',
    'subscriptions.show.client',
    'subscriptions.store.client',
    'subscriptions.timeRemaining.client',

    // reviews
    'reviews.index',
    'reviews.store',
    'reviews.show',
    'reviews.update',
    'reviews.client_destroy',
    'reviews.ad.index',
    'reviews.user.ad.index',
    'reviews.destroy',

    // plans
    'plans.yearlyPlans',
    'plans.monthlyPlans',
    'plans.index',
    'plans.show',

    // favorites
    'favorite.index',
    'favorite.add',
    'favorite.remove',
    'favorite.check',

];

$premiumClientPermissions=[

//            //email verification
//            'verification.verify',
//            'verification.send',
//            //auth
//            'auth.register',
//            'auth.login',
//            'auth.logout',
//            'auth.refresh',
//            'auth.me',
//            'auth.forgetPassword',
//            'auth.resetPassword',
//            'auth.checkCode',

            // profile
    'profile.get_my_profile',
            'profile.create',
            'profile.show',
            'profile.update',
            'profile.delete',

            // user
            'user.show',
            'user.update',

            // property
            'property.getProperty',
            'property.getUserProperties',
            'property.create',
            'property.getAttributes',
            'property.update',
            'property.delete',

            // ad
            'ad.create',
            'ad.activate',
            'ad.show',
            'ad.unactivate',
            'ad.getAdsByPropertyType',
            'ad.getUserAds',
            'ad.activateSelectedAds',
            'ad.delete',
            'ad.nearToYou',
            'ad.search',
            'ad.recommend',

            // report
            'report.create',


            // subscriptions
            'subscriptions.activeSub.client',
            'subscriptions.deactivate.client',
            'subscriptions.index.client',
            'subscriptions.show.client',
            'subscriptions.store.client',
            'subscriptions.timeRemaining.client',

            // reviews
            'reviews.index',
            'reviews.store',
            'reviews.show',
            'reviews.update',
            'reviews.client_destroy',
            'reviews.ad.index',
    'reviews.destroy',
    'reviews.user.ad.index',

            // plans
            'plans.yearlyPlans',
            'plans.monthlyPlans',
            'plans.index',
            'plans.show',

            // favorites
            'favorite.index',
            'favorite.add',
            'favorite.remove',
            'favorite.check',

        ];


        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission,'api');
        }

        //Assign permissions to roles
        $superAdminRole->syncPermissions($permissions); // delete old permissions and keep those inside the $permissions
        $clientRole->givePermissionTo($clientpermissions); // add permissions on top of old ones
        $premiumClientRole->givePermissionTo($premiumClientPermissions);
        $adminRole->givePermissionTo($adminpermissions);


        ////////////////////////////////////////

        // Create users and assign roles


        // admin users
        for ( $x = 1; $x <=5 ; $x++) {
            $adminUser = User::query()->create([
                'first_name' => 'superadminUser ' . $x,
                'last_name' => 'User ' . $x,
                'phone_number' => '093675776' . $x,
                'password' => Hash::make('password' ),
                'email'=>    'adminexample@gmail'.$x.'com',
                'email_verified_at'=>Carbon::now(),
                'has_active_subscription'=>true
            ]);

            $adminUser->assignRole($adminRole);

            // Assign permissions associated with the role to the user
            $permissions = $adminRole->permissions()->pluck('name')->toArray();
            $adminUser->givePermissionTo($permissions);
        }

        //client
        for ( $x = 1; $x <= 5; $x++) {
            $clientUser = User::query()->create([
                'first_name' => 'premium_clientUser ' . $x,
                'last_name' => 'User ' . $x,
                'phone_number' => '093675776' . $x,
                'password' => Hash::make('password' ),
                'email'=>    'clientexample@gmail'.$x.'com',
                'email_verified_at'=>Carbon::now(),
            ]);

            $clientUser->assignRole($clientRole);

            // Assign permissions associated with the role to the user
            $permissions = $clientRole->permissions()->pluck('name')->toArray();
            $clientUser->givePermissionTo($permissions);
        }

        //premium_cleint

        for ( $x = 1; $x <= 5; $x++) {
            $premiumClientUser = User::query()->create([
                'first_name' => 'premium_clientUser ' . $x,
                'last_name' => 'User ' . $x,
                'phone_number' => '093675776' . $x,
                'password' => Hash::make('password' ),
                'email'=>    'premium_clientexample@gmail'.$x.'com',
                'email_verified_at'=>Carbon::now(),
                'has_active_subscription'=>true
            ]);

            $premiumClientUser->assignRole($premiumClientRole);

            // Assign permissions associated with the role to the user
            $permissions = $premiumClientRole->permissions()->pluck('name')->toArray();
            $premiumClientUser->givePermissionTo($permissions);
        }

        // super admin users
        for ( $x = 1; $x <= 1; $x++) {
            $superAdminUser = User::query()->create([
                'first_name' => 'super_adminUser ' . $x,
                'last_name' => 'User ' . $x,
                'phone_number' => '093675776' . $x,
                'password' => Hash::make('Aa@98765' ),
                'email'=>    'moalqrfan2003@gmail.com',
                'email_verified_at'=>Carbon::now(),
                'has_active_subscription'=>true
            ]);

            $superAdminUser->assignRole($superAdminRole);

            // Assign permissions associated with the role to the user
            $permissions = $superAdminRole->permissions()->pluck('name')->toArray();
            $superAdminUser->givePermissionTo($permissions);
        }



    }
}
