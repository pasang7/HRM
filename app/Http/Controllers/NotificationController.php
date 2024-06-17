<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(){
        $data['user'] = User::find(Auth::user()->id);
        return view('notification.index', $data);
    }
}
