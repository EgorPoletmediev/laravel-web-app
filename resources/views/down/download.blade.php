<x-layout>
    @if(!isset($link))<h1 class = "title">To download file you should insert link into URL</h1>
    @else <h1 class = "title">Write download password</h1>
    @endif
    <form action="{{ isset($link) ? route('downloadLink', $link) :'#' }}" method="POST">
        @if(isset($link))
            @csrf
            {{--Password--}}
            <div class = "mb-8">
                <label for="password" class="text-xl">Password</label>
                <input type="password" name="password" class ="input @error('password') ring-red-500 @enderror">
                @error('password')
                <p class="error">{{ $message }} </p>
                @enderror
            </div>
            @error('message')
            <p class="error">{{ $message }} </p>
            @enderror
            {{--Submit Button--}}
            <button class="primary-btn">Download</button>
        @endif
    </form>
</x-layout>
