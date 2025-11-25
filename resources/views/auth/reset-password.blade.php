<x-auth-layout>

  <div class="card mx-auto w-full max-w-md">
    <div class="card-body px-10 py-12">
      <form method="POST" action="{{ route('reset-password.store') }}">
        @csrf
        <div class="flex flex-col items-center justify-center">
          <img src="./images/logo-small.svg" alt="logo" class="h-[50px]" />
          <h5 class="mt-4">Reset Your Password</h5>
        </div>

        <div class="mt-6 flex flex-col gap-5">
          <!-- Hidden fields for token and email -->
          <input type="hidden" name="token" value="{{ $token ?? '' }}" />
          <input type="hidden" name="email" value="{{ $email ?? '' }}" />

          <!-- New Password -->
          <div>
            <label class="label mb-1">New Password</label>
            <input type="password" name="password" class="input" placeholder="New Password" required />
          </div>
          <!--Confirm Password -->
          <div>
            <label class="label mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" class="input" placeholder="Confirm Password" required />
          </div>
          <!-- Reset Password -->
          <div class="mt-2">
            <button type="submit" class="btn btn-primary w-full py-2.5">Reset Password</button>
          </div>
          <!-- Go back & login -->
          <div class="flex justify-center">
            <p class="text-sm text-slate-600 dark:text-slate-300">
              Go back to
              <a href="{{ route('login') }}" class="text-sm text-primary-500 hover:underline">Login</a>
            </p>
          </div>
        </div>
      </form>
    </div>
  </div>
</x-auth-layout>