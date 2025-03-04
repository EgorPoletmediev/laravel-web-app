<x-layout>

    <h1 class = "text-2xl text-center mb-6 font-bold">Welcome back {{ auth()->user()->name }}!</h1>
    <form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
        @csrf
        {{--File--}}

        <div class = "card bg-slate-300 shadow-lg rounded-lg p-1 mb-4">
            <label for="file" class="text-xl font-bold mb-4" >File download</label>
            <input type="file" name="file" class ="input bg-slate-200 @error('file') ring-red-500 @enderror">
            <button class="bg-slate-200 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center mt-2">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                <span>Download</span>
            </button>
            @error('file')
            <p class="error">{{ $message }} </p>
            @enderror
        </div>
    </form>
    <div class = "card  bg-slate-300 shadow-lg rounded-lg p-1 mb-4">
        <h1 class="text-xl font-bold mb-4">Your files:</h1>

        {{--Show--}}
    @foreach ($files as $file)
        <div class="card bg-slate-200 shadow-lg rounded-lg p-1 mb-4">
            {{--Title--}}
            <h2 class = "font-bold text-xl">
                {{ $file->name }}
            </h2>
                <div class = "text-base font-light">Posted {{ $file->created_at }}
                    <form action="{{ route('files.destroy', $file) }}" method ="post" class = "flex item-center justify-end">
                        @csrf
                        @method('DELETE')
                        <button class ="bg-red-500 text-white px-2 py-1 text-xl rounded-md">Delete</button>
                    </form>
                </div>


                    <form action="{{ route('links.store', $file) }}" method="post">
                        @csrf
                        <div class = "card bg-slate-300 shadow-lg rounded-lg p-1 mb-4 mt-2">
                            <label for="password" class="text-xl font-bold mb-4" >Link create</label>
                            <label for="password" class="text-xl">Write password for link</label>
                            <input type="password" name="password" class ="input bg-slate-200 @error('file') ring-red-500 @enderror">
                            <button class="bg-slate-200 hover:bg-gray-400 text-gray-900 font-bold py-2 px-4 rounded inline-flex items-center mt-2">
                                <span>Confirm</span>
                            </button>
                            @error('file')
                            <p class="error">{{ $message }} </p>
                            @enderror

                        </div>

                    </form>
                    <h1 class="text-xl font-bold mb-1 ml-8">File links:</h1>
                    <div class = "card bg-slate-300 shadow-lg rounded-lg p-1 mb-3 ml-8">
                        @foreach ($file->links as $link)
                            <div class = "flex item-center justify-between gap-4 mb-1">
                            <h2 class = "font-bold text-sm rounded-lg bg-slate-200 mb-1">
                                http://127.0.0.1:8000/download/{{$link->link}}
                            </h2>
                                <h2 class="{{ $link->used ? 'text-red-900 bg-red-300' : 'text-green-900 bg-green-300' }} rounded-md text-sm font-bold justify-end mr-4">
                                    {{ $link->used ? 'Unavailable' : 'Available' }}
                                </h2>
                            </div>
                        @endforeach
                    </div>
        </div>
    @endforeach
    </div>






</x-layout>


