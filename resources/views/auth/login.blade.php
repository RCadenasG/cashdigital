<x-guest-layout>
    <div class="p-4 border border-white rounded-lg shadow-md">

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="row">
                <!-- Email Address -->
                <div class="col-12 col-md-6 mb-4">
                    <x-input-label class="text-white mb-2" for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block w-full text-black" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="col-12 col-md-6 mb-4">
                    <x-input-label class="text-white mb-2" for="password" :value="__('Password')" />
                    <div>
                        <x-text-input id="password" class="block w-full text-black" type="password" name="password"
                            required autocomplete="current-password" />
                        <button type="button" class="btn btn-outline-secondary mt-2"
                            onclick="togglePasswordVisibility()">
                            <i class="bi bi-eye" id="togglePassword"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>

            <!-- Remember Me -->
            <div class="block mb-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex flex-col gap-3 w-full mt-4">
                <div class="flex justify-between items-center">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @else
                        <span></span>
                    @endif

                    <x-primary-button>
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </div>
        </form>

        <script>
            function togglePasswordVisibility() {
                const passwordInput = document.getElementById('password');
                const toggleIcon = document.getElementById('togglePassword');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
                }
            }
        </script>
    </div>
</x-guest-layout>
