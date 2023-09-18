<?php

namespace App\Http\Controllers;

use App\Models\Logtaprfid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageuserController extends Controller
{



    public function index()
    {
        if (!(Auth::user()->role->id == 2 || Auth::user()->role->id == 1)) {
            return redirect()->route('dashboard');
        }
        $user = User::all();
        return view('pages.manageuser.index', compact('user'));
    }
    public function isMasuk()
    {
        $user = User::find(request()->id);

        $result = $user->update([
            'ismasuk' => request()->ismasuk
        ]);

        if ($result) {
            return response()->json([
                'status' => 'success',
                'message' => $user->nama . ' Berhasil Update',
                'ismasuk' => $user->ismasuk
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal Update'
            ]);
        }
    }
    public function deleteuser()
    {
        $user = User::find(request()->id);
        if ($user->pathuserpicture) {
            unlink($user->pathuserpicture);
        }
        $user->delete();
        return redirect()->back()->with('status', 'Berhasil Delete');
    }
    public function edit(User $user)
    {
        if ($user->rfiddata == null) {

            $logtap = Logtaprfid::orderBy('updated_at', 'desc')->take(1)->get();
            return response()->json([
                'user' => $user,
                'logtap' => $logtap,
                'status' => 0
            ]);
        }
        return response()->json([
            'user' => $user,
            'status' => 'success'
        ]);
    }
    public function update(User $user)
    {
        $user->update(request()->all());
        return response()->json(['success' => 'user successfully update']);
    }
}
