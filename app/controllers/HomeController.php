<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Message;

/**
 * Home controller
 */
class HomeController extends Controller
{
    /**
     * Show the index page
     *
     * @return void
     */
    public function index()
    {
        $message = new Message();
        $helloMessage = $message->getHelloMessage();
        
        $this->render('home', [
            'title' => 'Home',
            'message' => $helloMessage
        ]);
    }
}
