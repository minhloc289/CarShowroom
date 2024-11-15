@extends('Backend.dashboard.layout')

@section('content')
    <x-breadcrumbs breadcrumb="user.edit" />

    <div class="container mx-auto mt-10 mb-4">
        <h3 class="mb-4 text-center text-2xl font-bold text-gray-800 uppercase tracking-wider border-b-2 border-blue-500 pb-2 inline-block">
            Edit Member
        </h3>
        
        <!-- Form with enctype for file upload -->
        <form action="{{ route('user.update', $employee->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            @method('POST')
        
            <!-- Row for split layout with increased input size and aligned columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-gray-700 font-semibold">Name</label>
                        <input type="text" id="name" name="name" value="{{ $employee->name }}" readonly class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-gray-700 font-semibold">Phone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}" class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="birthday" class="block text-gray-700 font-semibold">Birthday</label>
                        <input type="date" id="birthday" name="birthday" value="{{ old('birthday', $employee->birthday ? $employee->birthday->format('Y-m-d') : '') }}" class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4 md:pl-4">
                    <div>
                        <label for="email" class="block text-gray-700 font-semibold">Email</label>
                        <input type="email" id="email" name="email" value="{{ $employee->email }}" readonly class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="address" class="block text-gray-700 font-semibold">Address</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $employee->address) }}" class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="level" class="block text-gray-700 font-semibold">Level</label>
                        <select id="level" name="level" required class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Employee" {{ old('level', $employee->is_quanly ? 'Admin' : 'Employee') == 'Employee' ? 'selected' : '' }}>Employee</option>
                            <option value="Admin" {{ old('level', $employee->is_quanly ? 'Admin' : 'Employee') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Photo Upload Field with Current Photo Display -->
            <div class="mt-4">
                <label for="photo" class="block text-gray-700 font-semibold">Upload Photo</label>
                @if ($employee->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $employee->image) }}" alt="Current Photo" width="100" height="100" class="rounded">
                    </div>
                @endif
                <input type="file" id="photo" name="photo" class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <small class="form-text text-muted">Upload a new profile photo if you want to change it.</small>
            </div>

            <!-- Description Field -->
            <div class="mt-4">
                <label for="description" class="block text-gray-700 font-semibold">Description</label>
                <textarea id="description" name="description" rows="3" class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('description', $employee->description) }}</textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full mt-4 p-3 font-bold text-white bg-blue-500 rounded shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Update
            </button>
        </form>
    </div>
@endsection
