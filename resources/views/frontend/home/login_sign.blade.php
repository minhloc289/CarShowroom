<div id="login-overlay"
    class="overlay-hidden fixed inset-0 bg-gray-800 bg-opacity-50 z-50 flex items-center justify-center">
    <div id="login-form" class="h-[569px] w-[400px] max-w-md px-6 py-4 bg-white shadow-lg rounded-lg"
        onclick="event.stopPropagation();">
        @include('frontend/login_sign/customer_login')
    </div>
</div>

<!-- Register Overlay -->
<div id="register-overlay"
    class="overlay-hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
    <div id="signup_form"
        class="register-form-container flex flex-col h-[700px] w-[400px] max-w-md px-6 py-4 bg-white shadow-lg rounded-lg"
        onclick="event.stopPropagation();">
        @include('frontend/login_sign/customer_signup')
    </div>
</div>
<!-- Forgot Password Overlay -->
<div id="forgot-password-overlay"
    class="overlay-hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
    <div id="forgot-password-form" class="h-[450px] w-[400px] max-w-md px-6 py-4 bg-white shadow-lg rounded-lg"
        onclick="event.stopPropagation();">
        @include('frontend/login_sign/forgot_pass') <!-- Include forgot password form here -->
    </div>
</div>
<style>
    /* public/css/customize.css */

    /* Default hidden state */
    .overlay-hidden {
        display: none;
    }

    /* Show animation for overlays */
    .show {
        display: flex !important;
        animation: fadeIn 0.7s ease forwards;
    }

    /* Fade-out animation without scaling */
    @keyframes fadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
        }
    }

    /* Media query to adjust height */
    @media (min-width: 768px) {
        .md\:h-screen {
            height: auto !important;
        }
    }

    /* Apply the hide animation */
    .hide {
        animation: fadeOut 0.5s ease forwards;
    }

    #login-form,
    #signup_form {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* public/css/customize.css */

    /* Trạng thái ẩn mặc định */
    .overlay-hidden {
        display: none;
    }

    /* Hiển thị overlay */
    .show {
        display: flex !important;
        animation: fadeIn 0.7s ease forwards;
    }
</style>
<script>
    // public/js/customize.js

    // public/js/customize.js
    document.addEventListener('DOMContentLoaded', function () {
        const registerOverlay = document.getElementById('register-overlay');

        // Kiểm tra nếu có lỗi trong session
        @if ($errors->any())
            // Hiển thị form đăng ký nếu có lỗi
            registerOverlay.classList.remove('overlay-hidden');
            registerOverlay.classList.add('show');
        @endif
    });

    document.addEventListener('DOMContentLoaded', function () {
        const loginOverlay = document.getElementById('login-overlay');
        const registerOverlay = document.getElementById('register-overlay');
        const forgotpasswordoverlay = document.getElementById('forgot-password-overlay');


        const loginLink = document.getElementById('loginLink'); // Link "Log in" in sign-up form
        const signUpLink = document.getElementById('signUpLink'); // Link "Sign Up" in login form
        const backToLoginLink = document.getElementById('backToLoginLink'); // Link "Login here" in sign-up form
        const backToLoginLinkFG = document.getElementById('backToLoginLinkFG'); // Link "Login here" in sign-up form

        // Show login overlay with fade-in effect
        loginLink.addEventListener('click', function (event) {
            event.preventDefault();
            registerOverlay.classList.add('overlay-hidden'); // Hide register overlay if open
            registerOverlay.classList.remove('show', 'hide');
            loginOverlay.classList.remove('overlay-hidden', 'hide');
            loginOverlay.classList.add('show');
        });

        // Switch directly to register overlay without fade-in effect
        signUpLink.addEventListener('click', function (event) {
            event.preventDefault();
            loginOverlay.classList.add('overlay-hidden'); // Hide login overlay if open
            loginOverlay.classList.remove('show', 'hide');
            registerOverlay.classList.remove('overlay-hidden');
            registerOverlay.classList.add('show');
        });
        forgotPasswordLink.addEventListener('click', function (event) {
            event.preventDefault();
            loginOverlay.classList.add('overlay-hidden'); // Hide login overlay if open
            loginOverlay.classList.remove('show', 'hide');
            forgotpasswordoverlay.classList.remove('overlay-hidden');
            forgotpasswordoverlay.classList.add('show');
        });
        // Show login overlay from the "Already have an account?" link
        backToLoginLink.addEventListener('click', function (event) {
            event.preventDefault();
            registerOverlay.classList.add('overlay-hidden'); // Hide register overlay
            registerOverlay.classList.remove('show', 'hide');
            loginOverlay.classList.remove('overlay-hidden', 'hide');
            loginOverlay.classList.add('show');
        });
        backToLoginLinkFG.addEventListener('click', function (event) {
            event.preventDefault();
            forgotpasswordoverlay.classList.add('overlay-hidden'); // Hide register overlay
            forgotpasswordoverlay.classList.remove('show', 'hide');
            loginOverlay.classList.remove('overlay-hidden', 'hide');
            loginOverlay.classList.add('show');
        });
        // Hide login overlay with fade-out effect on outside click
        loginOverlay.addEventListener('click', function (event) {
            if (event.target === loginOverlay) {
                loginOverlay.classList.add('hide');
                setTimeout(() => {
                    loginOverlay.classList.remove('show', 'hide');
                    loginOverlay.classList.add('overlay-hidden');
                }, 500); // Delay to allow fade-out animation
            }
        });

        // Hide register overlay with fade-out effect on outside click
        registerOverlay.addEventListener('click', function (event) {
            if (event.target === registerOverlay) {
                registerOverlay.classList.add('hide');
                setTimeout(() => {
                    registerOverlay.classList.remove('show', 'hide');
                    registerOverlay.classList.add('overlay-hidden');
                }, 500);
            }
        });
        forgotpasswordoverlay.addEventListener('click', function (event) {
            if (event.target === forgotpasswordoverlay) {
                forgotpasswordoverlay.classList.add('hide');
                setTimeout(() => {
                    forgotpasswordoverlay.classList.remove('show', 'hide');
                    forgotpasswordoverlay.classList.add('overlay-hidden');
                }, 500);
            }
        });
    });
</script>