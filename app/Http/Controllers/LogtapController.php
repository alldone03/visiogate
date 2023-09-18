<?php

namespace App\Http\Controllers;

use App\Models\Logtaprfid;
use App\Models\User;
use Illuminate\Http\Request;

class LogtapController extends Controller
{
    public function index()
    {
        $logtap = Logtaprfid::all();
        $lastlogtap = Logtaprfid::orderBy('updated_at', 'desc')->take(1)->get()[0]['updated_at'];
        return view('pages.logtap.index', compact('logtap', 'lastlogtap'));
    }
    public function addtap()
    {
        $data = User::all()->where('rfiddata', '=', request()->rfiddata)->first();
        if ($data) {
            $logtap = new Logtaprfid();
            $logtap->rfiddata = request()->rfiddata;
            $logtap->username = $data->username;
            $logtap->keterangan = request()->keterangan;
            $logtap->respon = $data->ismasuk;

            $logtap->save();
            return response()->json([
                'status' => 'success',
                'message' =>  'Berhasil ditambahkan',
                'ismasuk' => $logtap->respon
            ]);
        } else {
            $logtap = new Logtaprfid();
            $logtap->rfiddata = request()->rfiddata;
            $logtap->username = '-';
            $logtap->keterangan = request()->keterangan;
            $logtap->respon = false;
            $logtap->save();
            return response()->json([
                'status' => 'success',
                'message' =>  'Berhasil ditambahkan',
                'ismasuk' => $logtap->respon
            ]);
        }
    }
    public function lasttap()
    {
        $logtap = Logtaprfid::orderBy('updated_at', 'desc')->take(1)->get()[0]['updated_at'];
        return response()->json($logtap);
    }
}
