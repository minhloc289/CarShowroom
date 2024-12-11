<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Accessories;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        try {
            $user = Auth::guard('account')->user();

            // Kiểm tra nếu người dùng đã đăng nhập
            if (!$user) {
                return response()->json([
                    'message' => 'You must be logged in to add items to the cart.',
                    'redirect_url' => route('customer.login'), // Chuyển hướng tới trang login
                ], 401);
            }

            // Kiểm tra dữ liệu gửi lên (accessory_id và quantity)
            $validated = $request->validate([
                'accessory_id' => 'required|exists:accessories,accessory_id',
                'quantity' => 'required|integer|min:1',
            ]);

            // Lấy thông tin sản phẩm từ cơ sở dữ liệu (chỉ lấy tên và giá)
            $accessory = Accessories::find($validated['accessory_id']);
            if (!$accessory) {
                return response()->json([
                    'message' => 'Accessory not found.',
                ], 404);
            }

            // Kiểm tra giỏ hàng trong database
            $cart = Cart::where('account_id', $user->id)
                        ->where('accessory_id', $validated['accessory_id'])
                        ->first();

            if ($cart) {
                // Nếu có, tăng số lượng
                $cart->quantity += $validated['quantity'];
                $cart->save();
            } else {
                // Nếu không có, thêm mới sản phẩm vào giỏ
                Cart::create([
                    'account_id' => $user->id,
                    'accessory_id' => $validated['accessory_id'],
                    'quantity' => $validated['quantity'],
                ]);
            }

            // Tính tổng số lượng trong giỏ hàng từ database
            $cartCount = Cart::where('account_id', $user->id)->sum('quantity');

            return response()->json([
                'message' => 'Product added to cart.',
                'cart_count' => $cartCount,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while adding to the cart.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
public function getCartCount()
{
    // Kiểm tra người dùng đã đăng nhập chưa
    if (!Auth::guard('account')->check()) {
        return response()->json([
            'cart_count' => 0,
        ]);
    }

    $user = Auth::guard('account')->user();
    $cartCount = Cart::where('account_id', $user->id)->sum('quantity');

    return response()->json([
        'cart_count' => $cartCount,
    ]);
}

public function updateQuantity(Request $request)
{
    $request->validate([
        'accessory_id' => 'required|exists:carts,accessory_id',
        'quantity' => 'required|integer|min:1',
    ]);

    $user = Auth::guard('account')->user();
    $cartItem = Cart::where('account_id', $user->id)
                    ->where('accessory_id', $request->accessory_id)
                    ->first();

    if (!$cartItem) {
        return response()->json(['error' => 'Cart item not found'], 404);
    }

    // Cập nhật số lượng
    $cartItem->quantity = $request->quantity;
    $cartItem->save();

    // Tính tổng tiền của sản phẩm
    $itemTotal = $cartItem->accessory->price * $cartItem->quantity;

    return response()->json([
        'message' => 'Quantity updated successfully',
        'item_total' => $itemTotal,
    ]);
}


public function getTotalPrice()
{
    $user = Auth::guard('account')->user();
    $totalPrice = Cart::where('account_id', $user->id)
        ->join('accessories', 'carts.accessory_id', '=', 'accessories.accessory_id')
        ->sum(DB::raw('carts.quantity * accessories.price'));

    return response()->json(['total_price' => $totalPrice]);
}

public function removeItem($id)
{
    try {
        // Lấy mục giỏ hàng dựa trên accessory_id
        $cartItem = Cart::where('accessory_id', $id)->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }

        // Xóa mục trong giỏ hàng
        $cartItem->delete();

        // Lấy danh sách giỏ hàng mới
        $updatedCart = Cart::with('accessory')->get();

        // Tính lại tổng giá
        $totalPrice = $updatedCart->sum(function ($item) {
            return $item->accessory ? $item->accessory->price * $item->quantity : 0;
        });

        return response()->json([
            'success' => true,
            'cartItems' => $updatedCart,
            'newTotalPrice' => number_format($totalPrice, 0, ',', '.')
        ]);
    } catch (\Exception $e) {
        \Log::error('Error removing item from cart: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
    }
}


public function getCartItems()
{
    try {
        // Lấy tất cả các mục trong giỏ hàng
        $cartItems = Cart::with('accessory')->get();

        // Map dữ liệu để trả về đúng định dạng JSON
        $response = $cartItems->map(function ($item) {
            return [
                'accessory' => [
                    'accessory_id' => $item->accessory->accessory_id,
                    'name' => $item->accessory->name,
                    'price' => $item->accessory->price,
                    'image_url' => $item->accessory->image_url,
                ],
                'quantity' => $item->quantity,
            ];
        });

        // Tính tổng giá trị giỏ hàng
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->accessory ? $item->accessory->price * $item->quantity : 0;
        });

        return response()->json([
            'success' => true,
            'cartItems' => $response,
            'totalPrice' => number_format($totalPrice, 0, ',', '.'),
        ]);
    } catch (\Exception $e) {
        \Log::error('Error fetching cart items: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while fetching cart items',
        ], 500);
    }
}

}
