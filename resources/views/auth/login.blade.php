<x-auth-layout>
    <div class="card mx-auto w-full max-w-md p-4 xl:p-6">
              @env('local')
              <div class="flex justify-center gap-4 mb-5">
                  <x-login-link class="btn btn-outline-primary" key="1" label="Login as Admin" />
                  <x-login-link class="btn btn-outline-primary" key="2" label="Login as User" />
                </div>
            @endenv
        <form method="POST" action="{{ route('authenticate') }}">
            @csrf
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/logo-small.svg') }}" alt="logo" class="h-[50px]" />
                <h5 class="mt-4">Welcome Back</h5>
                <p class="text-sm text-slate-500 dark:text-slate-400">Please enter your details</p>
            </div>

      

            <!-- Display General Errors -->
            @if (session('error'))
                <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-6 flex flex-col gap-5">
                <!-- Email -->
                <div>
                    <label class="label mb-1">Email Or Username</label>
                    <input type="text" class="input @error('email') border-red-500 @enderror" name="email"
                        placeholder="Enter Your Email" value="{{ old('email') }}" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Password-->
                <div>
                    <label class="label mb-1">Password</label>
                    <div class="relative">
                        <input type="password" id="password" class="input @error('password') border-red-500 @enderror pr-10" name="password"
                            placeholder="Password" />
                        <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <!-- Remember & Forgot-->
            <div class="mt-2 flex items-center justify-between">
                <div class="flex items-center gap-1.5">
                    <input type="checkbox"
                        class="h-4 w-4 rounded border-slate-300 bg-transparent text-primary-500 shadow-sm transition-all duration-150 checked:hover:shadow-none focus:ring-0 focus:ring-offset-0 enabled:hover:shadow disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-600"
                        id="remember-me" name="remember" />
                    <label for="remember-me" class="label">Remember Me</label>
                </div>
                <a href="{{ route('forgot-password') }}" class="text-sm text-primary-500 hover:underline">Forgot Password</a>
            </div>
            <!-- Login Button -->
            <div class="mt-8">
                <button class="btn btn-primary w-full py-2.5">Login</button>
            </div>
            <!-- Don't Have An Account -->
            <div class="mt-4 flex justify-center">
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Don't Have an Account?
                    <a href="{{ route('register') }}" class="text-sm text-primary-500 hover:underline">Sign up</a>
                </p>
            </div>
        </form>
    </div>

    <script>
        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        });
    </script>
</x-auth-layout>