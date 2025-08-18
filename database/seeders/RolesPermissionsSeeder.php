<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        //create Roles
        $superAdminRole=Role::create(['name' => 'super_admin']);
        $adminRole=Role::create(['name' => 'admin']);
        $premuimClientRole=Role::create(['name' => 'premium_client']);
        $clientRole=Role::create(['name' => 'client']);

        //Define permissions

$permissions = [

    //email verification
    'verification.verify',
    'verification.send',



    // auth
    // no register for superadmin
    //'auth.register',
    'auth.login',
    'auth.logout',
    'auth.refresh',
    'auth.me',
    'auth.forgetPassword',
    'auth.resetPassword',
    'auth.checkCode',

    // profile
    'profile.create',
    'profile.show',
    'profile.update',
    'profile.delete',

    // user
    'user.getUsers',
    'user.create',
    'user.show',
    'user.update',
    'user.delete',

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
    'reviews.property.index',

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
    'verification.verify',
    'verification.send',

    //auth
    //no register for admin
    'auth.login',
    'auth.logout',
    'auth.refresh',
    'auth.me',
    'auth.forgetPassword',
    'auth.resetPassword',
    'auth.checkCode',

    // profile
    'profile.create',
    'profile.show',
    'profile.update',
    'profile.delete',

    // user
    'user.getUsers',
    'user.create',
    'user.show',
    'user.update',
    'user.delete',

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
    'reviews.property.index',

    // plans
    'plans.yearlyPlans',
    'plans.monthlyPlans',
    'plans.index',
    'plans.show',


];

$clientpermissions=[

    //email verification
    'verification.verify',
    'verification.send',
    //auth
    'auth.register',
    'auth.login',
    'auth.logout',
    'auth.refresh',
    'auth.me',
    'auth.forgetPassword',
    'auth.resetPassword',
    'auth.checkCode',

    // profile
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
    'reviews.property.index',

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
            Permission::findOrCreate($permission,'web');
        }

        //Assign permissions to roles
        $adminRole->syncPermissions($permissions); // delete old permissions and keep those inside the $permissions
        $clientRole->givePermissionTo(['report.create','report.index']); // add permissions on top of old ones

        ////////////////////////////////////////

        // Create users and assign roles

        $adminUser=User::factory()->create([
            'name'=>'admin_user',
            'email'=>'admin@admin.com',
            'password'=> bcrypt('password')
        ]);

        $adminUser->assignRole($adminRole);

        $permissions = $adminRole->permissions()->pluck('name')->toArray();
        $adminUser->givePermissionTo($permissions);

        $clientUser=User::factory()->create([
            'name'=>'client_user',
            'email'=>'client@client.com',
            'password'=> bcrypt('password')
        ]);
        $clientUser->assignRole($clientRole);
        // Assign permissions associated with the role to hte user
        $permissions = $clientRole->permissions()->pluck('name')->toArray();
        $clientUser->givePermissionTo($permissions);

    }
}
