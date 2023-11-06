<?php
namespace App\Controller;
use GemFramework\Core\Controller;
use Gemlibrary\Http\JsonResponse;
class IndexController extends Controller
{
    public function __construct(\GemLibrary\Http\GemRequest $request)
    {
        parent::__construct($request);
    }

    public function index():void
    {
        $this->response->success('','','welcome to gemvc');
    }
}