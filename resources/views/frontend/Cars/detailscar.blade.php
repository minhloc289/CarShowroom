@extends('frontend.layouts.App')

@section('content')

<section class="py-8 bg-white md:py-16 dark:bg-gray-900 antialiased">
<div class="max-w-screen-xl px-4 mx-auto 2xl:px-0" style="padding-top: 1rem;">
      <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
        <div class="shrink-0 max-w-md lg:max-w-lg mx-auto" style="padding-top: 125px;">
          <img class="w-full dark:hidden" src="{{ $car->image_url }}" alt="{{ $car->name }}" />
          <img class="w-full hidden dark:block" src="{{ $car->image_url }}" alt="{{ $car->name }}" />
        </div>

        <div class="mt-6 sm:mt-8 lg:mt-0">
          <h1
            class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"
          >
            {{ $car->brand }} {{ $car->name }} - {{ $car->model }}
          </h1>
          <br>
          <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
            <p
              class="text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white"
            >
              @if ($car->sale)
                ${{ number_format($car->sale->sale_price, 2) }}
              @else
                Not for Sale
              @endif
            </p>

            <div class="flex items-center gap-2 mt-2 sm:mt-0">
              <div class="flex items-center gap-1">
                <svg
                  class="w-4 h-4 text-yellow-300"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
                  />
                </svg>
                <!-- Thêm các SVG khác nếu cần -->
              </div>
              <p
                class="text-sm font-medium leading-none text-gray-500 dark:text-gray-400"
              >
                (4.8)
              </p>
            </div>
          </div>

          <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8">
              <a href="{{ route('car.buy', ['id' => $car->car_id]) }}">
                <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                    Buy
                </button>
              </a>
          </div>

          <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />

          <p class="mb-6 text-gray-500 dark:text-gray-400">
            {{ $car->description ?? 'No description available for this car.' }}
          </p>
          <br><br>
          <p class="text-gray-500 dark:text-gray-400">
            <span class="font-semibold text-gray-900 dark:text-white">Engine Type:</span> {{ $car->engine_type }}<br><br>
            <span class="font-semibold text-gray-900 dark:text-white">Seats:</span> {{ $car->seat_capacity }}<br><br>
            <span class="font-semibold text-gray-900 dark:text-white">Max Speed:</span> {{ $car->max_speed }} km/h<br><br>
            <span class="font-semibold text-gray-900 dark:text-white">Trunk Capacity:</span> {{ $car->trunk_capacity }}
          </p>
        </div>
      </div>
    </div>
  </section>
            <div class="content flex-grow w-full mb-10">
                @yield('content')
            </div>
@endsection
