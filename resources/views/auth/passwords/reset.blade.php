@extends('layouts.app')

@section('content')
<div class="flex bg-gray-50 justify-center flex-col items-center h-screen w-screen ">
    <h1 class="text-center font-bold text-5xl  text-blue-400">AsTee</h1>
    <div class="bg-white w-6/12 flex flex-col items-center justify-start   shadow-lg rounded py-5 px-10">
        <div class="w-full">  
            <div class="w-full flex items-center justify-center flex-col">
                <div class="text-xl self-start  mb-2 font-bold text-gray-800">{{ __('Reset Password') }}</div>
                <hr class="w-full">
                <div class="w-full mt-2 ">
                    <form method="POST" class="w-full" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="w-full">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="w-full col-md-6">
                                <input id="email" type="email" class="border border-gray-300 rounded p-2 text-base w-full form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            
                                @error('email')
                                    <span class="invalid-feedback text-xs" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="relative form-group">
                                <input id="password" type="password" class="password border border-gray-300 rounded p-2 text-base w-full form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <ion-icon name="eye-off-outline" class="absolute right-0 pe-4 top-3 cursor-pointer revealPassword text-lg"></ion-icon>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="relative form-group">
                                <input id="password-confirm" type="password" class="password border border-gray-300 rounded p-2 text-base w-full form-control" name="password_confirmation" required autocomplete="new-password">
                                <ion-icon name="eye-off-outline" class="absolute right-0 pe-4 top-3 cursor-pointer revealPassword text-lg"></ion-icon>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="w-full bg-blue-700 py-1 text-white rounded hover:opacity-70 text-lg">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
