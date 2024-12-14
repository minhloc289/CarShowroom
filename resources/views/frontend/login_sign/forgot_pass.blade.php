<main id="content" role="main" class="w-full h-[90%] max-w-lg mx-auto p-6">
  <div class="mt-7 bg-white rounded-lg shadow-lg border border-gray-300 h-full flex items-center justify-center">
    <div class="p-6 space-y-4 h-[80%] flex flex-col justify-center">
      <!-- Title -->
      <div class="text-center">
        <h1 class="text-2xl font-bold text-gray-900">Forgot password?</h1>
        <p class="my-2 text-sm text-gray-600">
          Remember your password?
        </p>
        <div class="text-sm my-2  font-medium text-gray-600">
          Already have an account? 
          <a id="backToLoginLinkFG" href="#" class="text-indigo-600 hover:underline">Login here</a>
        </div>
      </div>

      <!-- Form -->
      <form action="{{ route('forget.password.post') }}" method="POST" class="space-y-4">
        @csrf
        <!-- Email field -->
        <div>
          <label for="email" class="block text-sm mb-2 font-medium text-gray-900">Email address</label>
          <input
            type="email"
            id="email"
            name="email"
            class="block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-sm"
            required
            aria-describedby="email-error"
          >
        </div>

        <!-- Submit button -->
        <button
          type="submit"
          class="flex w-full justify-center rounded-md bg-black px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
          Reset password
        </button>
      </form>
    </div>
  </div>
</main>
