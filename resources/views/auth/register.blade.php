<x-auth-layout>

  <div class="card mx-auto w-full max-w-md">
    <div class="card-body px-10 py-12">
      <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <div class="flex flex-col items-center justify-center">
          <img src="./images/logo-small.svg" alt="logo" class="h-[50px]" />
          <h5 class="mt-4">Create Account</h5>
        </div>

        <div class="mt-6 flex flex-col gap-5">
          <!-- Fullname -->
          <div>
            <label class="label mb-1">Full Name</label>
            <input type="text" name="name" class="input" placeholder="Enter Your Full Name" required />
          </div>
          <!-- Email -->
          <div>
            <label class="label mb-1">Email</label>
            <input type="email" name="email" class="input" placeholder="Enter Your Email" required />
          </div>
          <!-- Password -->
          <div>
            <label class="label mb-1">Password</label>
            <div class="relative">
              <input type="password" id="password" name="password" class="input pr-10" placeholder="Password" required />
              <button type="button" id="togglePassword"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                </svg>
              </button>
            </div>
          </div>
          <!-- Confirm Password-->
          <div class="relative">
            <label class="label mb-1">Confirm Password</label>
            <div class="relative">
              <input type="password" id="password_confirmation" name="password_confirmation" class="input pr-10"
                placeholder="Confirm Password" required />
              <button type="button" id="togglePasswordConfirm"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg id="eyeIconConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg id="eyeSlashIconConfirm" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                  viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                </svg>
              </button>
            </div>
          </div>
        </div>
        <!-- Remember & Forgot-->
        <div class="mt-2 flex">
          <div class="flex items-center gap-1.5">
            <input type="checkbox" name="terms"
              class="h-4 w-4 rounded border-slate-300 bg-transparent text-primary-500 shadow-sm transition-all duration-150 checked:hover:shadow-none focus:ring-0 focus:ring-offset-0 enabled:hover:shadow disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-600"
              id="terms" required />
            <label for="terms" class="label text-slate-400">I accept</label>
          </div>
          <a href="#" class="ml-2 text-sm text-primary-500 hover:underline">Terms & Condition</a>
        </div>
        <!-- Login Button -->
        <div class="mt-8">
          <button type="submit" class="btn btn-primary w-full py-2.5">Register</button>
          <div class="relative mt-4 flex h-6 items-center justify-center py-4">
            <div class="h-[1px] w-full bg-slate-200 dark:bg-slate-600"></div>
            <div class="t absolute w-10 bg-white text-center text-xs text-slate-400 dark:bg-slate-800">Or</div>
          </div>
          <button class="btn btn-outline-primary mt-4 w-full gap-3 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="24px" height="24px">
              <path fill="#FFC107"
                d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
              <path fill="#FF3D00"
                d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
              <path fill="#4CAF50"
                d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z" />
              <path fill="#1976D2"
                d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
            </svg>
            <span>Continue With Google</span>
          </button>
        </div>
        <!-- Don't Have An Account -->
        <div class="mt-4 flex justify-center">
          <p class="text-sm text-slate-600 dark:text-slate-300">
            Already have an Account?
            <a href="{{ route('login') }}" class="text-sm text-primary-500 hover:underline">Login</a>
          </p>
        </div>
    </div>
  </div>
  </form>
  <script>
    // Password toggle functionality for main password
    document.getElementById('togglePassword').addEventListener('click', function () {
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

    // Password toggle functionality for confirm password
    document.getElementById('togglePasswordConfirm').addEventListener('click', function () {
      const passwordInput = document.getElementById('password_confirmation');
      const eyeIcon = document.getElementById('eyeIconConfirm');
      const eyeSlashIcon = document.getElementById('eyeSlashIconConfirm');

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