@extends('frontend.layouts.App')

@section('content')

<video 
    id="video" 
    class="w-full -mt-20   h-full object-cover" 
    autoplay 
    muted 
    loop 
    disablePictureInPicture 
    playsinline>
    <source src="{{ asset('assets/videos/introduce.mp4') }}" type="video/mp4">
    Trình duyệt của bạn không hỗ trợ video.
</video>

       <!-- Tiêu đề và mô tả -->
       <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white z-10">
        <h1 class="text-4xl font-bold drop-shadow-lg">Welcome to Our Car Showroom</h1>
        <p class="mt-4 text-lg drop-shadow-lg">
            Experience the future of driving with our luxury and performance cars.
        </p>
        <a href="#learnMore" class="mt-6 px-6 py-3 bg-blue-600 rounded-full text-white hover:bg-blue-800 transition">
            Learn More
        </a>
    </div>
</div>

<!-- Section: Featured Image -->
<section id="learnMore" class="w-full bg-gray-50 py-16">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <!-- Phần Văn Bản -->
        <div>
            <h2 class="text-4xl font-bold" style="color: #0C6478">The perfect balance of luxury and performance</h2>
            <p class="text-xl font-semibold text-gray-800 mt-5">
                Discover perfection in every detail with 
                <a href="#" class="text-indigo-500 hover:text-indigo-800 font-bold ">
                    Porsche Panamera
                </a> 
                a seamless blend of outstanding performance and sophisticated design, delivering an inspiring driving experience.
            </p>
        </div>

        <!-- Phần Hình Ảnh -->
        <div class="flex justify-center">
            <img 
                src="{{ asset('assets/img/porsche_panamera.jpg') }}" 
                alt="Porsche Panamera" 
                class="w-full max-w-2lg rounded-lg shadow-lg">
        </div>
    </div>
</section>


<!-- Section: Highlights -->
<section class="bg-gray-50 py-16 mt-10">
    <h2 class="text-4xl font-bold text-center mb-8" style="color: #0C6478">Why Choose Us</h2>
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center group relative overflow-hidden">
            <img 
                src="{{ asset('assets/img/lux_design.png') }}" 
                alt="Porsche" 
                class="w-full h-56 object-cover rounded-lg shadow-lg transform transition duration-500 group-hover:scale-110">
            <h3 class="text-xl font-bold mt-5">Luxury Design</h3>
            <p class="mt-2 text-gray-600">Elegant interiors and striking exteriors to match your lifestyle.</p>
        </div>
        
        <!-- Powerful Performance -->
        <div class="text-center group relative overflow-hidden">
            <img 
                src="{{ asset('assets/img/power_porsche.png') }}" 
                alt="Porsche" 
                class="w-full h-56 object-cover rounded-lg shadow-lg transform transition duration-500 group-hover:scale-110">
            <h3 class="text-xl font-bold mt-5">Powerful Performance</h3>
            <p class="mt-2 text-gray-600">Engineered for speed, power, and superior handling.</p>
        </div>
        
        <!-- Advanced Safety -->
        <div class="text-center group relative overflow-hidden">
            <img 
                src="{{ asset('assets/img/safety_porsche.jpg') }}" 
                alt="Porsche" 
                class="w-full h-56 object-cover rounded-lg shadow-lg transform transition duration-500 group-hover:scale-110">
            <h3 class="text-xl font-bold mt-5">Advanced Safety</h3>
            <p class="mt-2 text-gray-600">Equipped with the latest technology to ensure your safety.</p>
        </div>
        
    </div>
</section>

<!-- Section: Call to Action -->
<section class="relative bg-cover bg-center" style="background-image: url('{{ asset('assets/img/porsche_background.jpg') }}'); height: 600px;">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div> <!-- Overlay -->

    <div class="relative container mx-auto flex flex-col lg:flex-row items-stretch pt-96 text-white h-full px-6 lg:px-12 gap-y-8 lg:gap-x-16 ">
        <!-- Vision -->
        <div class="text-center lg:text-left max-w-sm">
            <h3 class="text-2xl font-bold mb-4" style="color: #90CAF9">Vision</h3>
            <p class="text-sm lg:text-base">
                To become the leading luxury sports car brand, delivering top-tier driving experiences and unparalleled inspiration.
            </p>
        </div>

        <!-- Divider -->
        <div class="hidden lg:block h-40 w-0.5 bg-gray-300"></div>

        <!-- Mission -->
        <div class="text-center lg:text-left max-w-sm">
            <h3 class="text-2xl font-bold mb-4" style="color: #90CAF9">Mission</h3>
            <p class="text-sm lg:text-base">
                To create vehicles that are not only powerful but also sustainable, for a greener future.
            </p>
        </div>

        <!-- Divider -->
        <div class="hidden lg:block h-40 w-0.5 bg-gray-300"></div>

        <!-- Brand Philosophy -->
        <div class="text-center lg:text-left max-w-sm">
            <h3 class="text-2xl font-bold mb-4" style="color: #90CAF9">Brand Philosophy</h3>
            <p class="text-sm lg:text-base">
                Placing customers at the center, Porsche continually innovates to deliver perfection in every product.
            </p>
        </div>

        <!-- Divider -->
        <div class="hidden lg:block h-40 w-0.5 bg-gray-300"></div>

        <!-- Core Values -->
        <div class="text-center lg:text-left max-w-sm">
            <h3 class="text-2xl font-bold mb-4" style="color: #90CAF9">Core Values</h3>
            <p class="text-sm lg:text-base">
                Excellence, exceptional performance, and world-class customer service.
            </p>
        </div>
    </div>
</section>
@endsection