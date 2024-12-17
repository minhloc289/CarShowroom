<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Accessories;
use Illuminate\Http\Request;

class AccessoryController extends Controller
{
    public function index()
    {
        $accessories = Accessories::all(); // Lấy tất cả phụ kiện
        $categories = Accessories::distinct()->pluck('category'); // Lấy danh mục không trùng lặp
        return view('Backend.Product.Accessories.accessoriesOverview', compact('accessories', 'categories'));
    }

    public function create()
    {
        return view('Backend.Product.Accessories.accessoriesCreate'); // Form thêm mới phụ kiện
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'image_url' => 'required|url',
            'category' => 'required|string|in:Interior,Exterior,Car Care', // Chỉ cho phép các danh mục cụ thể
            'quantity' => 'required|integer|min:0', // Validation số lượng
        ]);

        // Tạo phụ kiện mới
        $accessory = new Accessories([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image_url' => $request->image_url,
            'category' => $request->category,
        ]);

        // Lưu phụ kiện và cập nhật số lượng thông qua phương thức increaseQuantity
        $accessory->save(); // Lưu trước để lấy ID
        $accessory->increaseQuantity($request->quantity);

        toastr()->success('Thêm phụ kiện thành công!');
        return redirect()->route('accessories.index');
    }


    public function edit($id)
    {
        $accessory = Accessories::findOrFail($id);
        return view('Backend.Product.Accessories.accessoriesEdit', compact('accessory'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:2000',
            'image_url' => 'required|url',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0', // Validation số lượng
        ]);

        $accessory = Accessories::findOrFail($id);
        $accessory->update($validated);

        toastr()->success('Accessory updated successfully');
        return redirect()->route('accessories.index');
    }

    public function destroy($id)
    {
        $accessory = Accessories::findOrFail($id);
        $accessory->delete();

        toastr()->success('Xóa phụ kiện thành công!');
        return redirect()->route('accessories.index');
    }

    // Phương thức cập nhật số lượng
    public function updateQuantity(Request $request, $id)
    {
        $accessory = Accessories::findOrFail($id);

        $request->validate([
            'amount' => 'required|integer',
        ]);

        try {
            if ($request->amount > 0) {
                $accessory->increaseQuantity($request->amount);
                toastr()->success('Tăng số lượng thành công!');
            } else {
                $accessory->decreaseQuantity(abs($request->amount));
                toastr()->success('Giảm số lượng thành công!');
            }
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
        }

        return redirect()->route('accessories.index');
    }


    public function showUploadForm()
    {
        return view('Backend.Product.Accessories.Upload');
    }

    public function showDetails($id)
{
    // Lấy phụ kiện từ database theo ID
    $accessory = Accessories::findOrFail($id);

    // Trả về view hiển thị chi tiết phụ kiện
    return view('Backend.Product.Accessories.accessoriesDetails', compact('accessory'));
}
}
