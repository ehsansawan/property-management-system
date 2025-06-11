<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Responses\Response;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected UserService $userService;
    private $id;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function get_users():JsonResponse
    {
        $data=[];
// just for the admin user
        try {
            $data=$this->userService->get_users();
            return Response::Success($data['users'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function show($id):JsonResponse
    {
        $data=[];
        // u must pay attention if user_role is client so the Auth()->user->id = $id
        // but if the user_role is admin it doesn't matter
        try {
            $data=$this->userService->show($id);
            return Response::Success($data['user'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }

    public function create(CreateUserRequest $request):JsonResponse
    {
        $data=[];
        // u must pay attention if user_role is client so the Auth()->user->id = $id
        // but if the user_role is admin it doesn't matter
        try {
            $data=$this->userService->create($request->validated());
            return Response::Success($data['user'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function update(UpdateUserRequest $request,$id):JsonResponse
    {
        $data=[];
        // u must pay attention if user_role is client so the Auth()->user->id = $id
        // but if the user_role is admin it doesn't matter
        try {
            $data=$this->userService->update($request->validated(),$id);
            return Response::Success($data['user'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }
    public function delete(string $id):JsonResponse
    {
        $data=[];
        // u must pay attention if user_role is client so the Auth()->user->id = $id
        // but if the user_role is admin it doesn't matter
        try {
            $data=$this->userService->delete($id);
            return Response::Success($data['user'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }




}
