<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $contents = Content::where('status', 'published')->orderBy('id', 'desc')->get();
        return view('home', [
            'contents' => $contents,
        ]);
    }

    public function show($id){
        $content = Content::findOrFail($id);
        $content->load('author');

        $content->view_count = $content->view_count + 1;
        $content->save();

        return view('article', compact('content'));
    }

    // public function comment(Request $request, $id){
    //     $content = Content::findOrFail($id);
    //     $content->load('author');

    //     if(auth()->id()){
    //         $content->comments()->create([
    //             'content_id' => $content->id,
    //             'content' => $request->content,
    //             'user_id' => auth()->id(),
    //         ]);

    //         return redirect()->back()->with('success', 'Comment added');
    //     }

    //     return redirect()->back()->with('error', 'You need to login to comment');
    // }
    public function comment(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->back()->with('error', 'You need to login to comment');
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ], [
            'content.required' => 'You need to fill the content to comment',
            'content.string' => 'Invalid comment format',
            'content.max' => 'Comment must not exceed 500 characters',
        ]);

        $content = Content::findOrFail($id);

        $content->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Comment added');
    }

}
