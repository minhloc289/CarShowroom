<section class="bg-gray-50">
<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
    <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
      <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
      Flowbite
    </a>
      <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
          Create an account
        </h1>
        <form class="space-y-4 md:space-y-6" action="{{ route('sign_up') }}" method="POST">
          @csrf
          <!-- Container flex 2 cột -->
          <div class="flex flex-col md:flex-row gap-4">
            <!-- Cột bên trái -->
            <div class="flex-1">
              <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email hoặc số điện
                  thoại</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 
                     dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 
                     @error('email') border-red-500 @enderror" placeholder="name@company.com" required>
                @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  required="">
              </div>
              <div>
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                  password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5"
                  required="">
              </div>
            </div>
            <!-- Cột bên phải -->
            <div class="flex-1">
              <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Họ và tên</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 
                     dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 
                     @error('name') border-red-500 @enderror" placeholder="Nguyễn Văn A" required>
                @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Số điện thoại</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 
                     dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 
                     @error('phone') border-red-500 @enderror" placeholder="0987654321" required>
                @error('phone')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Địa chỉ</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 
                     dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 
                     @error('address') border-red-500 @enderror" placeholder="123 Đường ABC, Phường XYZ" required>
                @error('address')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>
          <!-- Điều khoản -->
          <div class="flex items-start">
            <div class="flex items-center h-5">
              <input id="terms" aria-describedby="terms" type="checkbox"
                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
                required="">
            </div>
            <div class="ml-3 text-sm">
              <label for="terms" class="font-light text-gray-500 dark:text-gray-300">I accept the <a
                  class="font-medium text-primary-600 hover:underline dark:text-primary-500" href="#">Terms and
                  Conditions</a></label>
            </div>
          </div>
          <!-- Nút đăng ký -->
          <button type="submit"
            class="w-full text-white bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Đăng ký
          </button>
          <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
            Already have an account? <a id="backToLoginLink"
              class="text-primary-600 hover:underline dark:text-primary-500">Login here</a>
          </div>
        </form>
      </div>
  </div>
</section>
