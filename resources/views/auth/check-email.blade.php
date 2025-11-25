<x-auth-layout>
    <div class="card mx-auto w-full max-w-md p-4 xl:p-6">
        <div class="flex flex-col items-center justify-center text-center">
            <!-- Success Message -->
            @if(session('success'))
                <div class="w-full mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="w-full mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Success Icon -->
            <div class="w-16 h-16 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>

            <!-- Main Heading -->
            <h5 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-2">
                Check Your Email
            </h5>

            <!-- Subtitle -->
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">
                We've sent a password reset link to your email address
                @if(isset($email))
                    <span class="font-medium text-slate-900 dark:text-slate-100">{{ $email }}</span>
                @endif
            </p>

            <!-- Instructions Card -->
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-4 mb-6 w-full">
                <div class="flex items-start gap-3">
                    <div class="w-5 h-5 bg-primary-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="text-sm font-medium text-slate-900 dark:text-slate-100 mb-1">
                            Check your inbox
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            Look for an email from us with the subject "Reset Your Password"
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3 mt-3">
                    <div class="w-5 h-5 bg-primary-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="text-sm font-medium text-slate-900 dark:text-slate-100 mb-1">
                            Click the reset link
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            Click the link in the email to reset your password
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3 mt-3">
                    <div class="w-5 h-5 bg-primary-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="text-sm font-medium text-slate-900 dark:text-slate-100 mb-1">
                            Didn't receive the email?
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            Check your spam folder or try again
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col gap-3 w-full">
                <!-- Back to Login -->
                <a href="{{ route('login') }}" class="btn btn-primary w-full py-2.5">
                    Back to Login
                </a>

                <!-- Resend Email (if route exists) -->
                @if(Route::has('forgot-password'))
                    <div class="w-full">
                        <!-- Countdown Timer Display -->
                        <div id="countdown-display" class="text-center mb-2">
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                You can resend email in <span id="countdown-timer" class="font-mono font-semibold text-primary-500">05:00</span>
                            </p>
                        </div>

                        <form method="POST" action="{{ route('forgot-password.store') }}" class="w-full">
                            @csrf
                            @if(isset($email))
                                <input type="hidden" name="email" value="{{ $email }}">
                            @endif
                            <button type="submit" id="resend-button" class="btn btn-outline-primary w-full py-2.5" disabled>
                                <span id="resend-text">Resend Email</span>
                                <span id="resend-loading" class="hidden">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Sending...
                                </span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Help Text -->
            <div class="mt-6 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <p class="text-xs text-blue-700 dark:text-blue-300 text-center">
                    The reset link will expire in 60 minutes for security reasons.
                </p>
            </div>

            <!-- Footer Links -->
            <div class="mt-4 flex flex-col sm:flex-row gap-2 justify-center text-center">
                <span class="text-sm text-slate-600 dark:text-slate-400">
                    Remember your password?
                </span>
                <a href="{{ route('login') }}" class="text-sm text-primary-500 hover:underline font-medium">
                    Sign in here
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countdownDisplay = document.getElementById('countdown-display');
            const countdownTimer = document.getElementById('countdown-timer');
            const resendButton = document.getElementById('resend-button');
            const resendText = document.getElementById('resend-text');
            const resendLoading = document.getElementById('resend-loading');
            const resendForm = resendButton.closest('form');

            let timeLeft = 300; // 5 minutes in seconds
            let countdownInterval;

            // Function to format time as MM:SS
            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
            }

            // Function to update countdown
            function updateCountdown() {
                if (timeLeft <= 0) {
                    // Enable button when countdown reaches zero
                    resendButton.disabled = false;
                    resendButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    resendButton.classList.add('hover:bg-primary-50', 'dark:hover:bg-primary-900/20');
                    countdownDisplay.classList.add('hidden');
                    clearInterval(countdownInterval);
                    return;
                }

                countdownTimer.textContent = formatTime(timeLeft);
                timeLeft--;
            }

            // Function to start countdown
            function startCountdown() {
                timeLeft = 300; // Reset to 5 minutes
                countdownDisplay.classList.remove('hidden');
                resendButton.disabled = true;
                resendButton.classList.add('opacity-50', 'cursor-not-allowed');
                resendButton.classList.remove('hover:bg-primary-50', 'dark:hover:bg-primary-900/20');

                updateCountdown(); // Update immediately
                countdownInterval = setInterval(updateCountdown, 1000);
            }

            // Handle form submission
            if (resendForm) {
                resendForm.addEventListener('submit', function(e) {
                    // Show loading state
                    resendText.classList.add('hidden');
                    resendLoading.classList.remove('hidden');
                    resendButton.disabled = true;
                });
            }

            // Handle page visibility changes (pause/resume countdown when tab is not visible)
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    clearInterval(countdownInterval);
                } else if (timeLeft > 0) {
                    countdownInterval = setInterval(updateCountdown, 1000);
                }
            });

            // Start the countdown when page loads
            startCountdown();
        });
    </script>
</x-auth-layout>