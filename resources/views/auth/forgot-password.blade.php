<x-auth-layout>
    <div class="card mx-auto w-full max-w-md">
        <div class="card-body px-10 py-12">
            <form method="POST" action="{{ route('forgot-password.store') }}">
                @csrf
                <div class="flex flex-col items-center justify-center">
                    <img src="{{ asset('images/logo-small.svg') }}" alt="logo" class="h-[50px]" />
                    <h5 class="mt-4">Recover Your Password</h5>
                </div>
    
                <div class="mt-6 flex flex-col gap-5">
                    <!-- Email -->
                    <div>
                        <label class="label mb-1">Email</label>
                        <input type="email" name="email" class="input" placeholder="Enter Your Email" required />
                    </div>
                    <!-- Recover Password -->
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary w-full py-2.5">Recover Password</button>
                    </div>
                    <!-- Go back & login -->
                    <div class="flex justify-center">
                        <p class="text-sm text-slate-600 dark:text-slate-300">
                            Go back to <a href="{{ route('login') }}"
                                class="text-sm text-primary-500 hover:underline">Login</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-auth-layout>
