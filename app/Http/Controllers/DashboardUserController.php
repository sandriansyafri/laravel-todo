<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    public function index()
    {
        $count_all_todo = Todo::where('user_id', auth()->id())->count();
        $count_completed_todo = Todo::where('user_id', auth()->id())->where('status', true)->count();
        $count_not_yet_todo = Todo::where('user_id', auth()->id())->where('status', false)->count();
        return view('page.dashboard.user', compact(['count_all_todo', 'count_completed_todo', 'count_not_yet_todo']));
    }
}
