<?php

namespace App\Services;

use App\Mail\SendCodeResetPassword;
use App\Models\Profile;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserService
{
    /**
     * Create a new class instance.
     */
    protected array $rolesType = [
        1 => 'admin',
        2 => 'client',
        3 => 'premium_client',
    ];
    public function __construct()
    {
        //
    }
    public function getUserByEmail(Request $request): array
{
    $valid = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email'
    ]);

    if ($valid->fails()) {
        return [
            'user' => null,
            'message' => 'email not exist or invalid',
            'code' => 404
        ];
    }

    $user = User::with('profile')->where('email', $request->email)->first();
    $user['role_name']=$user->getRoleNames();

    return [
        'user' => $user,
        'message' => 'user retrieved successfully',
        'code' => 200
    ];
}
    public function get_users():array
    {
        $users = User::with('profile')->get();
        foreach ($users as $user) {
            $user['role_name']=$user->getRoleNames();
        }

        $activeUsers=User::query()->where('has_active_subscription',true)->count();

        $message='users retrieved successfully';
        $code=200;
        return ['users'=>['Active_users_number'=>$activeUsers,'users'=>$users],'message'=>$message,'code'=>$code];
    }
    public function show($id):array
    {
        $user=User::query()->find($id);


        if(is_null($user))
        {
            $message='user not found';
            $code=404;
            return ['user'=>$user,'message'=>$message,'code'=>$code];
        }

        $user['role_name']=$user->getRoleNames();

        $message='user retrieved successfully';
        $code=200;
        return ['user'=>$user,'message'=>$message,'code'=>$code];
    }
    public function create($request):array
    {
        $data=new Request($request);

        $user=User::query()->create(
            [
                'first_name'=>$data->first_name,
                'last_name'=>$data->last_name,
                'email'=>$data->email,
                'password'=>bcrypt($data->password),
                'phone_number'=>$data->phone_number,
                'fcm_token'=>$data->fcm_token??null,
                //role_id
            ]
        );

        if(is_null($user))
        {
            $message='user can not be created, try again later';
            $code=400;
            return ['user'=>$user,'message'=>$message,'code'=>$code];
        }


        $Role=Role::query()->where('name',$this->rolesType[$request['role_id']])->first();
        $user->assignRole($Role);

        //Assign permissions for user
        $permissions=$Role->permissions()->pluck('name')->toArray();
        $user->givePermissionTo($permissions);

        //very important
        // load the user's roles and permissions (research about this method)
        $user->load('roles','permissions');
        if(!$user->hasRole('client'))
        {
            $user->has_active_subscription=true;
            $user->save();
        }
        //Reload the user instant to get updated roles and permissions
        $user=User::query()->find($user->id);
       // $user=$this->appendRolesAndPermissions($user);


        $message='user created successfully';
        $code=200;
        return ['user'=>$user,'message'=>$message,'code'=>$code];

    }
    public function update($request,$id):array
    {
        $user = User::query()->find($id);

        // very important casting from array to Request
        $data= new Request($request);

        if (is_null($user)) {
            $message = 'user not found';
            $code = 404;
            return ['user' => $user, 'message' => $message, 'code' => $code];
        }

            $user_id=auth('api')->id();
            if($user_id != $id)
            {
                return ['user'=>null,'message'=>'you are not allowed to do this action','code'=>403];
            }



        $fields = ['first_name', 'last_name', 'phone_number'];

        foreach ($fields as $field) {
            if (filled($data->get($field))) {
                $user->{$field} = $data->get($field);
            }
        }

        if ($data->filled('password'))
        {
            $user->password = bcrypt($data->password);
        }

        $user->save();
        $message = 'user updated successfully';
        $code=200;
        return ['user'=>$user,'message'=>$message,'code'=>$code];

    }
    public function delete($id):array
    {
        $user=User::query()->find($id);

        if (is_null($user)) {
            $message = 'user not found';
            $code = 404;
            return ['user' => $user, 'message' => $message, 'code' => $code];
        }

        $checkUser=auth('api')->user();

        if(!$checkUser->hasRole('super_admin') && !$checkUser->hasRole('admin'))
        {
            $user_id=auth('api')->id();
            if($user_id != $id)
            {
                return ['user'=>null,'message'=>'you are not allowed to do this action','code'=>403];
            }
        }


        $user->delete();
        $message = 'user deleted successfully';
        $code=200;
        return ['user'=>$user,'message'=>'user deleted successfully','code'=>$code];
    }
    public function upgradeToPremium($id):array  // for admin
    {
        $vaild=Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:users,id']
        );

        if($vaild->fails())
        {
            return ['user'=>null,'message'=>$vaild->errors(),'code'=>422];
        }


        $user = User::query()->with(['roles','permissions'])->find($id);

        if(!$user->hasAnyRole(['super_admin','admin','client','premium_client']))
        {
            return ['user'=>$user,'message'=>'this user does not have any roles yet ','code'=>403];
        }

        if(!$user->hasRole('client') )
        {
            return ['user'=>$user,'message'=>'you are not allowed to do this action','code'=>403];
        }


      //  $role = Role::where('name', $request['role_id'])->firstOrFail();


        $user->syncRoles([]);
        $user->syncPermissions([]);

        $Role=Role::query()->where('name',$this->rolesType[3])->first();
        $user->assignRole($Role);

        //Assign permissions for user
        $permissions=$Role->permissions()->pluck('name')->toArray();
        $user->givePermissionTo($permissions);

        if(!$user->hasRole('client'))
        {
            $user->has_active_subscription=true;
            $user->save();
        }

    $user=User::query()->with(['roles','permissions'])->find($id);

        return ['user'=>$user,'message'=>'user update to premium','code'=>200];
    }
    public function assignUserRole($request) // for super admin
    {
        $vaild=Validator::make($request->all(),[
            'user_id'=>'required|exists:users,id',
            'role_id'=>'required|min:1|max:3',
        ]);
        if($vaild->fails())
        {
            return ['user'=>null,'message'=>$vaild->errors(),'code'=>422];
        }

        $user = User::find($request['user_id']);


        //  $role = Role::where('name', $request['role_id'])->firstOrFail();


        $user->syncRoles([]);
        $user->syncPermissions([]);

        $Role=Role::query()->where('name',$this->rolesType[$request['role_id']])->first();
        $user->assignRole($Role);

        //Assign permissions for user
        $permissions=$Role->permissions()->pluck('name')->toArray();
        $user->givePermissionTo($permissions);

        if(!$user->hasRole('client'))
        {
            $user->has_active_subscription=true;
            $user->save();
        }
        else
        {
            $user->has_active_subscription=false;
            $user->save();
        }
        $user=User::query()->with(['roles','permissions'])->find($user->id);

        return ['user'=>$user,'message'=>'user permissions assigned successfully','code'=>200];
    }
    public function upgrade()
    {
        $user=auth('api')->user();

        if(!$user->hasAnyRole(['super_admin','admin','client','premium_client']))
        {
            return ['user'=>$user,'message'=>'this user does not have any roles yet ','code'=>403];
        }

        if(!$user->hasRole('client') )
        {
            return ['user'=>$user,'message'=>'you are not allowed to do this action','code'=>403];
        }


        //  $role = Role::where('name', $request['role_id'])->firstOrFail();


        $user->syncRoles([]);
        $user->syncPermissions([]);

        $Role=Role::query()->where('name',$this->rolesType[3])->first();
        $user->assignRole($Role);

        //Assign permissions for user
        $permissions=$Role->permissions()->pluck('name')->toArray();
        $user->givePermissionTo($permissions);

        if(!$user->hasRole('client'))
        {
            $user->has_active_subscription=true;
            $user->save();
        }

        return ['user'=>$user,'message'=>'user upgrade to premium ','code'=>200];

    }
    public function downgrade()
    {
        $user=auth('api')->user();

        if(!$user->hasAnyRole(['super_admin','admin','client','premium_client']))
        {
            return ['user'=>$user,'message'=>'this user does not have any roles yet ','code'=>403];
        }

        if(!$user->hasRole('premium_client') )
        {
            return ['user'=>$user,'message'=>'you are not allowed to do this action','code'=>403];
        }


        //  $role = Role::where('name', $request['role_id'])->firstOrFail();


        $user->syncRoles([]);
        $user->syncPermissions([]);

        $Role=Role::query()->where('name',$this->rolesType[2])->first();
        $user->assignRole($Role);

        //Assign permissions for user
        $permissions=$Role->permissions()->pluck('name')->toArray();
        $user->givePermissionTo($permissions);

        if($user->hasRole('client'))
        {
            $user->has_active_subscription=false;
            $user->save();
        }

        return ['user'=>$user,'message'=>'user downgrade from premium client to client ','code'=>200];
    }



}
