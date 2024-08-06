<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CommentController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $products_id = $request->input('products_id');
        $start = $request->input('start');
        $limit = 3;

        $comments = Comment::with('user')
            ->where('products_id', $products_id)
            ->orderBy('id', 'DESC')
            ->skip($start)
            ->take($limit)
            ->get();

        foreach ($comments as $comment) {
            $comment->images = asset($comment->image);
            $comment->profile = asset($comment->user->image);
            $comment->tgl = Carbon::parse($comment->created_at)->diffForHumans();
        }

        $totalComments = Comment::where('products_id', $products_id)->count();
        $hasMore = ($start + $limit) < $totalComments;

        return Response::json([
            'data' => $comments,
            'next' => $start + $limit,
            'hasMore' => $hasMore
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'image' => 'mimes:png,jpg,jpeg'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = rand() . '.' . $image->getClientOriginalExtension();
            $path = 'comments/' . $imageName;
            $image->move(public_path('comments'), $imageName);

            Comment::create([
                'users_id' => Auth::user()->id,
                'products_id' => $request->products_id,
                'body' => $request->body,
                'image' => $path
            ]);
        } else {
            Comment::create([
                'users_id' => Auth::user()->id,
                'products_id' => $request->products_id,
                'body' => $request->body,
            ]);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
