<x-layout>
    <h1 class = "title">Login</h1>

    <div class ="mx-auto max-w-screen-sm card bg-white shadow-lg rounded-lg p-6">

        <form action="{{ route('login') }}" method="post">

            @csrf
            {{--Email--}}
            <div class = "mb-8">
                <label for="email" class="text-xl">Email</label>
                <input type="text" name="email" value="{{ old('email') }}" class ="input @error('email') ring-red-500 @enderror">
                @error('email')
                <p class="error">{{ $message }} </p>
                @enderror
            </div>
            {{--Password--}}
            <div class = "mb-8">
                <label for="password" class="text-xl">Password</label>
                <input type="password" name="password" class ="input @error('password') ring-red-500 @enderror">
                @error('password')
                <p class="error">{{ $message }} </p>
                @enderror
            </div>
            @error('failed')
            <p class="error">{{ $message }} </p>
            @enderror

            <button class="primary-btn">Login</button>

        </form>

    </div>
</x-layout>


