<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;


use Illuminate\Support\Str;
use App\Models\User;

class FileController extends Controller implements HasMiddleware
{

    public static function middleware(){
        return [
            new Middleware('auth:sanctum')
        ];
    }

    public function index()
    {

        //Gate::authorize('modify', $file);
        $user = auth()->user();

        $files = $user->files->sortByDesc('created_at');
        return  view('files.index',['files'=>$files]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);
        $uploadedFile = $request->file('file');

        $path = $uploadedFile->store('uploads');

        $file = $request->user()->files()->create([
            'name' => $uploadedFile->getClientOriginalName(),
            'path' =>$path
        ]);
        return redirect()->route('files.index');
    }

    public function destroy(File $file)
    {
        Gate::authorize('modify', $file);
        Storage::delete($file->path);

        $file->delete();

        return back();
    }
}
