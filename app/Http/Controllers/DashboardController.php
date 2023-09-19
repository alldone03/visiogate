<?php

namespace App\Http\Controllers;

use App\Models\StatePintu;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class DashboardController extends Controller
{
    public function dashboard()
    {

        // dd(Auth::user()->role);
        // dd("hello");
        if (auth()->user()->roles == 2 || auth()->user()->roles == 1) {
            return view('pages.dashboard.admin');
        } else if (auth()->user()->roles == 3) {
            return view('pages.dashboard.user');
        }
    }
    public function getrealtimestate()
    {
        $data = StatePintu::all();
        return response()->json($data);
    }
    public function changestate()
    {
        // $data = StatePintu::find();
        $data = StatePintu::find(StatePintu::where('keterangan', '=', request()->data)->take(1)->get()[0]['id']);
        $data->update([
            'state' => request()->state,
        ]);

        return response()->json();
    }
}
