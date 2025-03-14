<x-layout>
    <h1 class = "title">Register a new account</h1>

    <div class ="mx-auto max-w-screen-sm card bg-white shadow-lg rounded-lg p-6">

        <form action="{{ route('register') }}" method="post">

            @csrf

            {{--Username--}}
            <div class = "mb-8">
                <label for="name" class="text-xl">Username</label>
                <input type="text" name="name" value="{{ old('name') }}" class ="input @error('name') ring-red-500 @enderror">
                @error('name')
                <p class="error">{{ $message }} </p>
                @enderror
            </div>
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
            {{--Confirm Password--}}
            <div class = "mb-8">
                <label for="password_confirmation" class="text-xl">Confirm Password</label>
                <input type="password" name="password_confirmation" class ="input @error('password') ring-red-500 @enderror">
            </div>
            {{--Submit Button--}}
            <button class="primary-btn">Register</button>

        </form>

    </div>
</x-layout>


