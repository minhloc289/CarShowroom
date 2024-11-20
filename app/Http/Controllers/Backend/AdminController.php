<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\CreateRequest;
class AdminController extends Controller
{
    public function __construct()
    {
        
    }

    public function loadUserPage()
    {
        $employees = User::orderBy('created_at', 'desc')->paginate(4);
        return view('Backend.user.index', compact('employees'));
    }

    public function loadUserCreatePage()
    {
        return view('Backend.user.createUser');
    }

    public function loadUserEditPage($id)
    {
        $employee = User::findOrFail($id);
        return view('Backend.user.editUser', compact('employee'));
    }

    public function deleteUser($id) {
        // Find the user
        $employee = User::findOrFail($id);

        // Delete the user's photo if it exists
        if ($employee->image) {
            Storage::disk('public')->delete($employee->image);
        }

        // Delete the user
        $employee->delete();

        // Redirect back with success message
        toastr()->success('Xóa nhân viên thành công!');
        return redirect()->route('user');
    }

    public function editUser(Request $request, $id)
    {
        // Validate the input data
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'level' => 'required|string|in:Employee,Admin',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the photo
        ]);

        // Find the user
        $employee = User::findOrFail($id);

        // Check if a new photo has been uploaded
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($employee->image) {
                Storage::disk('public')->delete($employee->image);
            }
            
            // Store the new photo
            $photoPath = $request->file('photo')->store('photos', 'public');
            $employee->image = $photoPath;
        }

        // Update fields
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->birthday = $request->birthday;
        $employee->is_quanly = $request->level == 'Admin' ? 1 : 0;
        $employee->description = $request->description;

        // Save the updated user
        $employee->save();

        // Redirect back with success message
        toastr()->success('Cập nhật thông tin nhân viên thành công!');
        return redirect()->route('user', $employee->id);
    }

    public function createUser(CreateRequest $request)
    {
        try {
            // Lấy dữ liệu đã được validate
            $validated = $request->validated();

            // Xử lý upload ảnh
            $imagePath = null; // Ảnh mặc định
            if ($request->hasFile('image')) { // Nếu có upload ảnh
                $imagePath = $request->file('image')->store('photos', 'public');
            }

            // Set is_quanly based on level
            $is_quanly = ($validated['level'] === 'Admin') ? 1 : 0;

            // Create the user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'birthday' => $validated['birthday'] ?? null,
                'image' => $imagePath,
                'description' => $validated['description'] ?? null,
                'user_agent' => $request->header('User-Agent'),
                'is_quanly' => $is_quanly,
                'password' => Hash::make('minhlocdeptrai'),
            ]);

            toastr()->success('Thêm mới nhân viên thành công!');
            return redirect()->route('user');

        } catch (\Exception $e) {
            toastr()->error('Có lỗi xảy ra khi tạo nhân viên!');
            return back()->withInput();
        }
    }

    public function loadUserDetails($id)
    {
        $employee = User::findOrFail($id);
        return response()->json($employee);
    }


}
