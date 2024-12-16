@extends('Backend.dashboard.layout')

@section('content')
    <x-breadcrumbs breadcrumb="user.create" />
    <div class="container mx-auto mt-10 mb-4">
        <h3 class="mb-4 text-center text-2xl font-bold text-gray-800 uppercase tracking-wider border-b-2 border-blue-500 pb-2 inline-block">
            Add New Member
        </h3>
        
        <!-- Form with enctype for file upload -->
        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf

            <!-- Row for split layout with increased input size and aligned columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-gray-700 font-semibold">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-gray-700 font-semibold">Phone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="birthday" class="block text-gray-700 font-semibold">Birthday</label>
                        <input type="date" id="birthday" name="birthday" value="{{ old('birthday') }}" class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4 md:pl-4">
                    <div>
                        <label for="email" class="block text-gray-700 font-semibold">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="address" class="block text-gray-700 font-semibold">Address</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}" class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="level" class="block text-gray-700 font-semibold">Level</label>
                        <select id="level" name="level" required class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Nhân viên" {{ old('level') == 'Nhân viên' ? 'selected' : '' }}>Nhân viên</option>
                            <option value="Admin" {{ old('level') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Photo Upload Field -->
            <div class="mt-4">
                <label for="photo" class="block text-gray-700 font-semibold">Upload Photo</label>
                <input type="file" id="photo" name="photo" class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Description Field -->
            <div class="mt-4">
                <label for="description" class="block text-gray-700 font-semibold">Description</label>
                <textarea id="description" name="description" rows="3" class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('description') }}</textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full mt-4 p-3 font-bold text-white bg-blue-500 rounded shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Save
            </button>
        </form>
    </div>
@endsection
