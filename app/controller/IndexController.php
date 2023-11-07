<?php
namespace App\Controller;
use GemFramework\Core\Controller;
class IndexController extends Controller
{
    public function __construct(\GemLibrary\Http\GemRequest $request)
    {
        parent::__construct($request);
    }

    public function index():JsonResponse
    {
        $message = new \stdClass();
        $message->message = 'welcome to gemvc API';
        $message->requestId = $this->request->getId();
        $this->response->success($message);
        return $this->response;
    }
}
