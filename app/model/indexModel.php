<?php
namespace App\Model;
use Gemvc\Core\Model;
use Gemvc\Http\Request;
use Gemvc\Http\Response;
use Gemvc\Http\JsonResponse;

class IndexModel extends Model{
    public function __construct(Request $request){
        parent::__construct($request);
    }

    public function index():JsonResponse{
        return Response::success('welcome to Gemvc');
    }

}