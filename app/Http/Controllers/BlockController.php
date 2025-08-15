<?php

namespace App\Http\Controllers;

use App\Http\Responses\Response;
use App\Services\BlockService;
use Illuminate\Http\Request;
use Throwable;

class BlockController extends Controller
{

    //
   protected BlockService $blockservice;
    public function __construct(BlockService $blockservice)
    {
        $this->blockservice = $blockservice;
    }

    public function block(Request $request)
    {
        $data=[];

        try {
            $data=$this->blockservice->block($request);
            return Response::Success($data['block'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function unblock($id)
    {
        $data=[];

        try {
            $data=$this->blockservice->block($id);
            return Response::Success($data['block'],$data['message'],$data['code']);
        }
        catch (Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }


}
