<?php
namespace App\Http\Controllers;

use App\Mail\replyDiscussMsg;
use Illuminate\Support\Facades\Mail;
use function Scarecrow\requestIsPjax;

class TestController extends Controller
{
    public function index() {
//        var_dump(Mail::to('790828430@qq.com')->send(new replyDiscussMsg()));
//        return (new  replyDiscussMsg())->render();

    }

}
