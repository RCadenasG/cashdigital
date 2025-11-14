<x-guest-layout>
    <div class="p-4 border border-white rounded-lg shadow-md">

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label class="text-white mb-2" for="email" :value="__('Email')" />
                <x-text-input id="email" class="form-control text-black w-100" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" style="width: 100% !important;" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label class="text-white mb-2" for="password" :value="__('Password')" />
                <div class="input-group" style="width: 100%;">
                    <x-text-input id="password" class="form-control text-black" type="password" name="password"
                        required autocomplete="current-password" style="flex: 1; width: 100% !important;" />
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">
                        <i class="bi bi-eye" id="togglePassword"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="mb-4">
                <label for="remember_me" class="d-flex align-items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 me-2"
                        name="remember">
                    <span class="text-sm text-white">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Forgot Password y Login Button -->
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                @if (Route::has('password.request'))
                    <a class="text-white text-decoration-none small" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @else
                    <span></span>
                @endif

                <x-primary-button>
                    {{ __('Log in') }}
                </x-primary-button>
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
