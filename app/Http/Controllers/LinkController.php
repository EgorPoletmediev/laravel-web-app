<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\File;
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
            new Middleware('auth:sanctum', except: ['download', 'check_valid'])
        ];
    }

    public function download(Request $request,Link $link){ //скачиваем файл по ссылке

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


    public function index(File $file) //выводим список ссылок, относящихся к файлу
    {
        Gate::authorize('modify', $file);

        $links = $file->links->sortByDesc('created_at');
        return  view('files.index',['links'=>$links]);
    }

    public function store(Request $request, File $file) //создаем новую ссылку
    {
        Gate::authorize('modify', $file);

        $temp = $request->validate([
            'password'=>'required|min:8'
        ]);
        $link = $file->links()->create($temp);
        return back();
    }
    public function show(File $file){ //возвращаем 404 если пользователь хочет посмотреть ссылку
        abort(404);
    }

    public function check_valid($link) { //проверяем ссылку на существование, в противном случае возвращаем 404
        $link = Link::where('link', $link)->first();
        if (!$link) {
            //return redirect()->route('download')->withErrors([
            //    'link' => 'The provided link is invalid.']);
            abort(404);
        }
        return view('down.download', ['link' => $link]);
    }

}
