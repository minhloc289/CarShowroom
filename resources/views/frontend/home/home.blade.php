@extends('frontend.layouts.App')

@section('content')
<!-- resources/views/components/introduce.blade.php -->


<!-- Content Section -->
<div class="relative mx-auto max-w-2xl py-[20vh] sm:py-[25vh] lg:py-[30vh] z-10">
  <!-- Announcement Section -->
  <div class="hidden sm:mb-[2vh] sm:flex sm:justify-center">
    <div
      class="relative h-[3vh] mt-[-20vh] rounded-full px-[2vw] py-[0.5vh] text-sm text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
      Announcing our next round of funding.
      <a href="javascript:void(0)" class="font-semibold text-indigo-600">
        Read more <span aria-hidden="true">&rarr;</span>
      </a>
    </div>
  </div>
  <!-- Main Content Section -->
  <div class="text-center">
    <h1 class="mt-[-15vh] text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">
      Discover Luxury Cars
    </h1>
    <div class="grid place-items-center h-auto">
    <img class="p-4 w-[200%] h-auto object-contain animate-car" src="{{ asset('assets/img/porsche4.png') }}" alt="Logo">
    </div>
    <p class="text-pretty text-lg font-medium sm:text-xl/8 text-gray-900" style="margin-top: 0vh;">
      Experience the thrill of driving with our exclusive collection of high-performance vehicles.
      Quality and elegance in every model, waiting for you to explore.
    </p>
    <div class=" mt-[5vh] flex items-center justify-center gap-x-[2vw] ">
      <a href="{{ route('CustomerDashBoard.bookingform') }}"
        class="rounded-md bg-indigo-600 px-[2vw] py-[1vh] text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
        Register For Consultation
      </a>
      <a href="{{ route('CustomerDashBoard.introduce') }}" class="text-sm font-semibold text-gray-900 hover:underline" style="color: #4954F4;">
        Learn more <span aria-hidden="true">→</span>
      </a>
    </div>
</div>
</div>


<div class="flex items-center justify-center h-[40vh] bg-white mt-[-300px]">
  <!-- Slider container -->
  <div id="default-carousel" class="relative w-[120%] max-w-2xl bg-white rounded-lg overflow-hidden"
    data-carousel="static">
    <!-- Carousel wrapper -->
    <div class="relative h-80 md:h-80 overflow-hidden" style="width: calc(100% + 20px);">
      <!-- Slide 1 -->
      <div class="duration-700 ease-in-out" data-carousel-item>
        <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
          src="{{ asset('assets/img/porsche1.png') }}" alt="Car Image">
      </div>
      <!-- Slide 2 -->
      <div class="hidden duration-700 ease-in-out" data-carousel-item>
        <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
          src="{{ asset('assets/img/porsche2.png') }}" alt="Car Image">
      </div>
      <div class="hidden duration-700 ease-in-out" data-carousel-item>
        <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
          src="{{ asset('assets/img/porsche3.png') }}" alt="Car Image">
      </div>
      <div class="hidden duration-700 ease-in-out" data-carousel-item>
        <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
          src="{{ asset('assets/img/porsche4.png') }}" alt="Car Image">
      </div>
      <div class="hidden duration-700 ease-in-out" data-carousel-item>
        <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
          src="{{ asset('assets/img/porsche5.png') }}" alt="Car Image">
      </div>
      <div class="hidden duration-700 ease-in-out" data-carousel-item>
        <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
          src="{{ asset('assets/img/porsche6.png') }}" alt="Car Image">
      </div>
      <!-- Add more slides as needed -->
    </div>

    <!-- Slider controls -->
    <button type="button"
      class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-2 cursor-pointer group focus:outline-none"
      data-carousel-prev onclick="updateInfo('prev')">
      <span
        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-600 group-hover:bg-gray-500 focus:ring-2 focus:ring-gray-500 group-focus:outline-none">
        <svg class="w-3 h-3 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 1 1 5l4 4" />
        </svg>
      </span>
      <span class="sr-only">Previous</span>
    </button>
    <button type="button"
      class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-2 cursor-pointer group focus:outline-none"
      data-carousel-next onclick="updateInfo('next')">
      <span
        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-600 group-hover:bg-gray-500 focus:ring-2 focus:ring-gray-500 group-focus:outline-none">
        <svg class="w-3 h-3 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 9 4-4-4-4" />
        </svg>
      </span>
      <span class="sr-only">Next</span>
    </button>
  </div>
</div>

<!-- Information display container -->
<div id="car-info" class="relative text-center mt-4 z-10">
  <p><strong>Model</strong>: Porsche 911 Carrera</p>
  <p><strong>Seats</strong>: 4 seats</p>
  <p><strong>Range</strong>: ~ 350 km (NEDC)</p>
  <p><strong>Starting Price</strong>: 2,500,000,000 VND</p>
  <div class="flex justify-center space-x-4 mt-4">
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Reserve</button>
    <button class="border border-blue-600 text-blue-600 px-4 py-2 rounded">View Details</button>
  </div>
</div> 


<div class="flex items-center p-8 text-white h-[800px] rounded-[20px]"
  style="background: radial-gradient(circle, rgb(35, 35, 35), rgb(26, 26, 26), rgb(9, 9, 9)); margin-top: 20px ">
  <!-- Image Section -->
  <div class="w-1/2 flex justify-center">
    <img
      src="https://neural.love/cdn/thumbnails/1eef60c8-a379-6e16-b43a-9d0e90677367/5384d998-bcbe-5327-aa14-1f9899fb6a35.webp?Expires=1767225599&Signature=k6NLH79SYrfPbHP1zL05MaV18uTjg1ZTEVr04DlMSmN~0fCsyMNXvFoS8UHyHFS2OFEUVClRlsI8wiIN7wy7PbBdJ1fmXDpRCs-FjFwqhsPzpkWz21MRCFytaRt0ZW2lHjIBS1YCqSk7Hpo0cLA1BdEY5wob1CepbB3usk6-umcpT4NUlAfvvGcSDOB9fTcSSJAQgcqUwsw4KBjnIR5-qGn-ISCKpCYEs7et4FTheHgGtiZ44tMLe1bmAq7RMlMIUjL8lo9RobC0a6hwQBUJDVfUbEfTHzaOHwk5w4hWUJcJr0~CaaohRAjoXiJi4m85l7xH8tXIJDLLJG1AX8STpg__&Key-Pair-Id=K2RFTOXRBNSROX"
      alt="Profile Image" class="w-[600px] h-[300px] object-cover rounded-full">
  </div>
  <!-- Text Section -->
  <div class="w-1/2 pl-8">
    <p class="text-3xl font-semibold text-center mb-4">"Experience the Pinnacle of Luxury and Unmatched Speed"</p>
    <p class="text-gray-400 text-center">
      The powerful engine allows you to experience breathtaking speed, gliding effortlessly yet powerfully along
      any road. Its responsive and precise handling gives you a sense of stability and safety, even when
      conquering the most challenging curves. Every ride in the Porsche 911 Carrera is a journey of
      self-discovery, where you can fully embrace your passion for speed and perfection.<br><br>
    </p>
    <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
    <p class="font-bold">Design and Elegance</p>
    <p class="text-gray-400 mb-4">Emphasizes the meticulous craftsmanship and luxurious interior, portraying the
      car as a style statement.</p>

    <p class="font-bold">Power and Performance</p>
    <p class="text-gray-400 mb-4">Describes the powerful engine and smooth performance, appealing to the thrill of
      driving.</p>

    <p class="font-bold">Self-Discovery and Passion</p>
    <p class="text-gray-400 mb-4">Frames each journey as a path to self-exploration, embodying a passion for speed
      and excellence.</p>
  </div>
</div>

<div class="container mx-auto px-6 py-12">
  <!-- Title Section -->
  <div class="text-center">
    <h1 class="text-4xl font-bold mb-4">Love in Every Detail</h1>
    <p class="text-lg text-gray-400">Immerse yourself in luxury with our meticulous detailing packages tailored to
      your car's unique needs.</p>
  </div>
  <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">

  <!-- Card Section -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
    <!-- Entry-Level Detail -->
    <div class=" rounded-lg shadow-lg overflow-hidden">
      <img src="https://imgd.aeplcdn.com/664x374/n/o2bupsa_1476812.jpg?q=80" alt="Entry-level detail"
        class="w-full h-auto object-cover">
      <div class="p-6">
        <h3 class="text-2xl font-bold mb-2">Entry-level Detail</h3>
        <p class="text-gray-400 mb-4">Treat your car to our entry-level detail, perfect for maintaining everyday
          elegance.</p>
        <a href="#" class="text-blue-500 hover:underline">Learn More →</a>
      </div>
    </div>

    <!-- Maintenance Detail -->
    <div class="rounded-lg shadow-lg overflow-hidden">
      <img
        src="https://pictures.porsche.com/rtt/iris?COSY-EU-100-1711cYLvsi60rFkXqXUnBEgAHYByY9AJ%25OggSPvuB1pkbgI7DMJphteDkrNqLHn45pXnfZYovIS0rhO3RMFYqwhXjbWBbaoD2OFmI1BSCAW%25k4Zo9Zs1l2PY6QzpFCjspAnPKWbiZJyNSWFctBvotwvf8dXF2iqPED6uvpzN9nReRpMo4y7z8LtF%25vUq4ykuWXsOB3iZJyN4vv39h7nw%25Xj4AUP1S6a0LDpUuBLTugatwlg2dEheSY0lILHnH"
        alt="Maintenance detail" class="w-full h-auto object-cover">
      <div class="p-6">
        <h3 class="text-2xl font-bold mb-2">Maintenance Detail</h3>
        <p class="text-gray-400 mb-4">Keep your car looking pristine with our maintenance detailing package. </p>
        <a href="#" class="text-blue-500 hover:underline">Learn More →</a>
      </div>
    </div>

    <!-- Full Detail -->
    <div class="rounded-lg shadow-lg overflow-hidden">
      <img
        src="https://pictures.porsche.com/rtt/iris?COSY-EU-100-1711coMvsi60AAt5FwcmBEgA4qP8iBUDxPE3LUUEssTugNTb7gKOCl3UBb%25cUzW1TipaIKyGZPm21CS9ctLD6L8T7wG2Epk6a0vDdgBWTJWFk4wq1fx5%253dkF%25vUqjdTuWXsOB3iZJyN4vv39h7nw%25Xjbkdl7FJkOFmjZrgmTB8VuKQbgLk0D0UlS7h%258XsXb1qG"
        alt="Full detail" class="w-full h-auto object-cover">
      <div class="p-6">
        <h3 class="text-2xl font-bold mb-2">Full Detail</h3>
        <p class="text-gray-400 mb-4">Experience the ultimate transformation with our full-detail package.</p>
        <a href="#" class="text-blue-500 hover:underline">Learn More →</a>
      </div>
    </div>
  </div>
</div>

<!--  -->
<div class=" items-center p-8 text-white h-[800px] rounded-[20px] "
  style="background: radial-gradient(circle, rgb(35, 35, 35), rgb(26, 26, 26), rgb(9, 9, 9)); margin-top: 20px">
  <div class="max-w-7xl mx-auto h-max px-6 md:px-12 xl:px-6 ">
    <div class="md:w-2/3 lg:w-1/2">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-100">
        <path fill-rule="evenodd"
          d="M9 4.5a.75.75 0 01.721.544l.813 2.846a3.75 3.75 0 002.576 2.576l2.846.813a.75.75 0 010 1.442l-2.846.813a3.75 3.75 0 00-2.576 2.576l-.813 2.846a.75.75 0 01-1.442 0l-.813-2.846a3.75 3.75 0 00-2.576-2.576l-2.846-.813a.75.75 0 010-1.442l2.846-.813A3.75 3.75 0 007.466 7.89l.813-2.846A.75.75 0 019 4.5zM18 1.5a.75.75 0 01.728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 010 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 01-1.456 0l-.258-1.036a2.625 2.625 0 00-1.91-1.91l-1.036-.258a.75.75 0 010-1.456l1.036-.258a2.625 2.625 0 001.91-1.91l.258-1.036A.75.75 0 0118 1.5zM16.5 15a.75.75 0 01.712.513l.394 1.183c.15.447.5.799.948.948l1.183.395a.75.75 0 010 1.422l-1.183.395c-.447.15-.799.5-.948.948l-.395 1.183a.75.75 0 01-1.422 0l-.395-1.183a1.5 1.5 0 00-.948-.948l-1.183-.395a.75.75 0 010-1.422l1.183-.395c.447-.15.799-.5.948-.948l.395-1.183A.75.75 0 0116.5 15z"
          clip-rule="evenodd"></path>
      </svg>
      <h2 class="my-8 text-2xl font-bold text-white md:text-4xl">How we work?</h2>
      <p class="text-gray-300">We follow our process to get you started as quickly as possible</p>
    </div>
    <div
      class="mt-16 grid divide-x divide-y  divide-gray-700 overflow-hidden rounded-3xl border text-gray-600 border-gray-700 sm:grid-cols-2 lg:grid-cols-4  lg:divide-y-0 xl:grid-cols-4">
      <div class="group relative bg-gray-800 transition hover:z-[1] hover:shadow-2xl hover:shadow-gray-600/10">
        <div class="relative space-y-8 py-12 p-8">
          <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
            stroke-linejoin="round" color="white" style="color:white" height="50" width="50"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path
              d="M19.875 6.27a2.225 2.225 0 0 1 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z">
            </path>
            <path d="M10 10l2 -2v8"></path>
          </svg>
          <div class="space-y-2">
            <h5 class="text-xl font-semibold text-white transition">Initial Discussion</h5>
            <p class="text-gray-300">We will have discussions on the requirements to ensure your MVP
              (Minimum Viable
              Product) is ready for the initial launch</p>
          </div>
        </div>
      </div>
      <div class="group relative bg-gray-800 transition hover:z-[1] hover:shadow-2xl hover:shadow-gray-600/10">
        <div class="relative space-y-8 py-12 p-8">
          <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
            stroke-linejoin="round" color="white" style="color:white" height="50" width="50"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path
              d="M19.875 6.27a2.225 2.225 0 0 1 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z">
            </path>
            <path d="M10 8h3a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-2a1 1 0 0 0 -1 1v2a1 1 0 0 0 1 1h3"></path>
          </svg>
          <div class="space-y-2">
            <h5 class="text-xl font-semibold text-white transition group-hover:text-secondary">Deal
              Finalized</h5>
            <p class="text-gray-300">Once we agree on what to build, We will start working on it right
              away.</p>
          </div>
        </div>
      </div>
      <div class="group relative bg-gray-800 transition hover:z-[1] hover:shadow-2xl hover:shadow-gray-600/10">
        <div class="relative space-y-8 py-12 p-8">
          <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
            stroke-linejoin="round" color="white" style="color:white" height="50" width="50"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path
              d="M19.875 6.27a2.225 2.225 0 0 1 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z">
            </path>
            <path
              d="M10 9a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-2h2a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1">
            </path>
          </svg>
          <div class="space-y-2">
            <h5 class="text-xl font-semibold text-white transition group-hover:text-secondary">Product
              Delivery</h5>
            <p class="text-gray-300">We will develop your product MVP in 15 days (more time required
              depending on the
              complexity of the project)</p>
          </div>
        </div>
      </div>
      <div class="group relative bg-gray-800 transition hover:z-[1] hover:shadow-2xl hover:shadow-gray-600/10">
        <div class="relative space-y-8 py-12 p-8">
          <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
            stroke-linejoin="round" color="white" style="color:white" height="50" width="50"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path
              d="M19.875 6.27a2.225 2.225 0 0 1 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z">
            </path>
            <path d="M10 8v3a1 1 0 0 0 1 1h3"></path>
            <path d="M14 8v8"></path>
          </svg>
          <div class="space-y-2">
            <h5 class="text-xl font-semibold text-white transition group-hover:text-secondary">Celebrate
              your Launch
            </h5>
            <p class="text-gray-300">We love Celebrations. We will celebrate your launch on our Social
              Profiles.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--  -->
<div class="container mx-auto py-12">
  <div class="flex flex-col md:flex-row items-center justify-center space-y-8 md:space-y-0 md:space-x-12">
    <!-- Stat 1 -->
    <div class="text-center">
      <h2 class="text-4xl font-bold">25+</h2>
      <p class="text-gray-400">Satisfied clients</p>
    </div>

    <!-- Divider -->
    <div class="hidden md:block h-12 border-l border-gray-600"></div>

    <!-- Stat 2 -->
    <div class="text-center">
      <h2 class="text-4xl font-bold">1M+</h2>
      <p class="text-gray-400">Customers acquired</p>
    </div>

    <!-- Divider -->
    <div class="hidden md:block h-12 border-l border-gray-600"></div>

    <!-- Stat 3 -->
    <div class="text-center">
      <h2 class="text-4xl font-bold">$90M</h2>
      <p class="text-gray-400">Generated revenue</p>
    </div>
  </div>
</div>
@endsection