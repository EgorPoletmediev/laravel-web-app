<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\File;
//use App\Http\Requests\StoreLinkRequest;
//use App\Http\Requests\UpdateLinkRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Facades\Hash;

class LinkController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('auth:sanctum', except: ['index', 'show', 'download'])
        ];
    }

    public function download(Request $request,Link $link){
        $request->validate([
            'password' => 'required'
        ]);
        if ($link && Hash::check($request->password, $link->password) && !$link->used){
            $file = $link->file;
            $link->update([
                'used' => 1
                ]);
            $filePath = $file->path;
            return Storage::download($file->path);

        }
        return back()->withErrors([
            'message'=>'The provided credentials is incorrect.'
            ]);
    }


    public function index(File $file)
    {
        $links = $file->links->sortByDesc('created_at');
        return  view('files.index',['links'=>$links]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, File $file)
    {
        $temp = $request->validate([
            'password'=>'required'
        ]);
        $link = $file->links()->create($temp);
        return back();
    }

//    public function destroy(Link $link)
//    {
//        //
//    }
}
