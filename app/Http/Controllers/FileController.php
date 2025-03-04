<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;


use Illuminate\Support\Str;
use App\Models\User;

class FileController
{
    public function index() //выводим все свои файлы
    {
        $user = auth()->user();

        $files = $user->files->sortByDesc('created_at');
        return  view('files.index',['files'=>$files]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) //загружаем файл
    {
        $request->validate([
            'file' => 'required|file|max:102400',
        ]);
        $uploadedFile = $request->file('file');

        $path = $uploadedFile->store('uploads');

        $file = $request->user()->files()->create([
            'name' => $uploadedFile->getClientOriginalName(),
            'path' =>$path
        ]);
        return redirect()->route('files.index');
    }

    public function show(File $file){ //возвращаем 404 если пользователь хочет посмотреть файл
        abort(404);
    }

    public function destroy(File $file) //удаляем файл
    {
        Gate::authorize('modify', $file);
        Storage::delete($file->path);

        $file->delete();

        return back();
    }
}
