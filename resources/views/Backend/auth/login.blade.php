<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link rel="shortcut icon" href="/assets/img/logo (2).png" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="max-w-md mx-auto bg-white dark:bg-gray-900 rounded-lg shadow-lg p-8">
          <div class="text-center">
            <img class="h-20 w-auto mx-auto" src="{{ asset('assets/img/logo (2).png') }}" alt="Logo">
            <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Sign in to your account</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
              Don't have an account?
              <a href="/" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-300">Sign Up →</a>
            </p>
          </div>
      
          <form method="post" class="space-y-6 mt-8" action="{{ route('auth.login') }}" autocomplete="on">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="email">Email address</label>
                <div class="mt-1">
                    <input class="appearance-none block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none sm:text-sm border-gray-300 placeholder-gray-400 dark:bg-gray-800 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500" 
                        id="email" 
                        name="email" 
                        type="text" 
                        autocomplete="off"
                        placeholder="your@email.com" 
                        value="{{ old('email') }}"
                    >
                </div>
                <!-- Error message for email in italic -->
                @error('email')
                    <div class="text-red-500 text-sm mt-1 italic">* {{ $message }}</div>
                @enderror
            </div>
        
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="password">Password</label>
                <div class="mt-1">
                    <input class="appearance-none block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none sm:text-sm border-gray-300 placeholder-gray-400 dark:bg-gray-800 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500" 
                           id="password" 
                           name="password" 
                           type="password" 
                           autocomplete="new-password"
                           placeholder="••••••••" 
                           >
                </div>
                <!-- Error message for password in italic -->
                @error('password')
                    <div class="text-red-500 text-sm mt-1 italic">* {{ $message }}</div>
                @enderror
            </div>
        
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Remember me</label>
                </div>
                <div class="text-sm">
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-300">Forgot your password?</a>
                </div>
            </div>
        
            <div>
                <button type="submit" class="inline-flex items-center border font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 px-4 py-2 text-base bg-black font-medium text-white hover:bg-gray-800 border border-black focus:ring-black w-full justify-center">Sign in</button>
            </div>
        </form>
        
        </div>
      </div>            
</body>
</html>