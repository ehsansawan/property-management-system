<?php

namespace App\Services;

use App\Mail\SendCodeResetPassword;
use App\Models\Profile;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

    public function get_users():array
    {
        $users=User::all();
        $message='users retrieved successfully';
        $code=200;
        return ['users'=>$users,'message'=>$message,'code'=>$code];
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
                'fcm_token'=>$data->fcm_token,
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

        $user->delete();
        $message = 'user deleted successfully';
        $code=200;
        return ['user'=>$user,'message'=>'user deleted successfully','code'=>$code];
    }

}
