<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desginer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DesignerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Desginer::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('specialist', function ($row) {
                    return $row->specialist;
                })
                ->addColumn('telp', function ($row) {
                    return $row->telp;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm mr-2 edit" data-id="' . $row->id . '"><i class="fas fa-pen"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-id="' . $row->id . '"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->toJson();
        }
        return view('admin.designer.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'specialist' => 'required',
            'telp' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        }

        $post = $request->all();

        Desginer::create($post);
        return response()->json(['status' => 200, 'message' => 'Berhasil menyimpan data']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Desginer::where('id', $id)->first();
        if (!$data) {
            return response()->json(['status' => 404, 'data' => null]);
        }
        return response()->json(['status' => 200, 'data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'specialist' => 'required',
            'telp' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        }

        $put = $request->all();

        $data = Desginer::where('id', $request->id)->first();
        $data->update($put);

        return response()->json(['status' => 200, 'message' => 'Berhasil megubah data']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Desginer::find($id);
        $data->delete();

        if (!$data) {
            return response()->json(['status' => 404, 'message' => 'Data Not Found!']);
        }

        return response()->json(['status' => 200, 'message' => 'Berhasil menghapus data']);
    }
}
