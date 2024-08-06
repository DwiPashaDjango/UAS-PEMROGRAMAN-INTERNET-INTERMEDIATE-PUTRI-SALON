<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index()
    {
        return view('pages.account');
    }

    public function updateAccount(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'image' => 'mimes:png,jpg,jpeg',
        ]);

        $data = User::where('id', $id)->first();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = rand() . '.' . $image->getClientOriginalExtension();
            $path = 'profile/' . $fileName;
            $image->move(public_path('profile'), $fileName);

            $data->update([
                'name' => $request->name,
                'email' => $request->email,
                'telp' => $request->telp,
                'alamat' => $request->alamat,
                'image' => $path,
            ]);
        } else {
            $data->update([
                'name' => $request->name,
                'email' => $request->email,
                'telp' => $request->telp,
                'alamat' => $request->alamat,
            ]);
        }

        return back()->with('message', 'Berhasil mengubah profile');
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'telp' => 'required',
            'alamat' => 'required'
        ]);

        if ($validation->fails()) {
            return Response::json(['status' => 400, 'errors' => $validation->errors()]);
        }

        $user = User::where('id', $id)->first();

        $put = $request->all();

        $user->update($put);

        return Response::json(['status' => 200, 'message' => 'Berhasil mengubah data.']);
    }
}
