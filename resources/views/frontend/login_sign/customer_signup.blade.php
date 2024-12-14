<section class="bg-gray-50">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
    <!-- Logo -->
    <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900">
      <img class="w-8 h-8 mr-2" src="{{ asset('assets/img/logo (2).png') }}" alt="logo">
      Merus
    </a>

    <!-- Form container -->
    <div class="w-full bg-white rounded-lg shadow-lg border sm:max-w-md xl:p-0">
      <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <!-- Title -->
        <h1 class="text-2xl font-bold leading-tight tracking-tight text-gray-900 text-center">
          Create an account
        </h1>

        <!-- Form -->
        <form class="space-y-4 md:space-y-6" action="{{ route('sign_up') }}" method="POST">
          @csrf
          <!-- Flex container for two columns -->
          <div class="flex flex-col md:flex-row gap-6">
            <!-- Left column -->
            <div class="flex-1">
              <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 @error('email') border-red-500 @enderror" placeholder="name@company.com" required>
                @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="password" class="block my-2 text-sm font-medium text-gray-900">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5" required>
              </div>
              <div>
                <label for="password_confirmation" class="block my-2 text-sm font-medium text-gray-900">Confirm password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5" required>
              </div>
            </div>

            <!-- Right column -->
            <div class="flex-1">
              <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Full name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 @error('name') border-red-500 @enderror" placeholder="Nguyễn Văn A" required>
                @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="phone" class="block my-2 text-sm font-medium text-gray-900">Phone number</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 @error('phone') border-red-500 @enderror" placeholder="0987654321" required>
                @error('phone')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="address" class="block my-2 text-sm font-medium text-gray-900">Address</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 @error('address') border-red-500 @enderror" placeholder="123 Đường ABC, Phường XYZ" required>
                @error('address')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>

          <!-- Terms -->
          <div class="flex items-start">
            <div class="flex items-center h-5">
              <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-indigo-600" required>
            </div>
            <div class="ml-3 text-sm">
              <label for="terms" class="font-light text-gray-600">I accept the <a class="font-medium text-indigo-600 hover:underline" href="#">Terms and Conditions</a></label>
            </div>
          </div>

          <!-- Submit button -->
          <button type="submit" class="w-full text-white bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Sign up
          </button>
          <div class="text-sm font-medium text-gray-600">
            Already have an account? <a id="backToLoginLink" href="#" class="text-indigo-600 hover:underline">Login here</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
