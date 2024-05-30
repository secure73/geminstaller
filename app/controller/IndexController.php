<?php
namespace App\Controller;
use Gemvc\Http\Request;
use Gemvc\Core\Controller;
use App\Model\IndexModel;
use Gemvc\Http\JsonResponse;


class IndexController extends Controller {

    public function __construct(Request $request){
        parent::__construct($request);
    }
    public function index():JsonResponse {
        return (new IndexModel($this->request))->index();
    }
}