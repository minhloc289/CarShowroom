<!-- 

@section('content')
<div id="login-overlay" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
    <div id="login-form" class="flex flex-col h-auto w-[400px] max-w-md px-6 py-4 bg-white shadow-lg rounded-lg" onclick="event.stopPropagation();">
        <div class="text-center mb-6">
            <img class="mx-auto h-16 w-auto" src="/assets/img/logo(2).png" alt="Your Company">
            <h2 class="mt-2 text-xl font-extrabold text-gray-800">Sign in to your account</h2>
            <p class="text-gray-500 mt-2">Don't have an account? <a id="signUpLink" href="{{ route('customer.sign_up') }}" class="text-blue-600 font-semibold hover:text-blue-500">Sign Up →</a></p>
        </div>

        <form class="space-y-4" action="{{ route('customer.login') }}" method="POST">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-900">Email address</label>
                <input id="email" name="email" type="email" required class="block w-full rounded-md border border-gray-300 py-1.5 pl-3 text-gray-900 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-sm" placeholder="your@email.com">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                <input id="password" name="password" type="password" required class="block w-full rounded-md border border-gray-300 py-1.5 pl-3 text-gray-900 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-sm" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full justify-center rounded-md bg-black px-4 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-800">Sign in</button>
        </form>
    </div>
</div>

  -->
  <section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
          <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
          Flowbite    
      </a>
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  Sign in to your account
              </h1>
              <form class="space-y-4 md:space-y-6" action="{{ route('login') }}" method="POST">
              @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900">Email address</label>
                    <input id="email" name="email" type="email" required class="block w-full rounded-md border border-gray-300 py-1.5 pl-3 text-gray-900 shadow-sm focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600 sm:text-sm" placeholder="your@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                    <input id="password" name="password" type="password" required class="block w-full rounded-md border border-gray-300 py-1.5 pl-3 text-gray-900 shadow-sm focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600 sm:text-sm" placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                    </div>

                    <div class="text-sm">
                        <a id="forgotPasswordLink" href="" class="font-semibold text-blue-600 hover:text-blue-500">Forgot your password?</a>
                    </div>
                </div>
                  <button type="submit" class="flex w-full justify-center rounded-md bg-black px-4 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">Sign in</button>
                  <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                      Don’t have an account yet? <a id="signUpLink" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</a>
                  </p>
              </form>
          </div>
      </div>
  </div>

</section>