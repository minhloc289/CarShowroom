<?php
namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\RentalCustomer;

class RegisterTestDrive extends Controller
{

    public function storeRentalCustomer(Request $request)
    {
        $validatedData = $request->only([
            'car_id',
            'customer_name',
            'phone_number',
            'email',
            'test_drive_date',
            'other_request',
        ]);
    
        return RentalCustomer::create($validatedData); // Trả về đối tượng vừa tạo
    }
    
    public function registerTestDrive(Request $request)
{
    $request->validate([
        'customer_name' => 'required|max:80',
        'phone_number' => 'required',
        'email' => 'required|email',
        'car_type' => 'required',
        'car_model' => 'required',
        'test_drive_date' => 'required|date',
        'other_request' => 'nullable|max:255',
        'car_url' => 'required',
        'car_id' => 'required',
    ]);
     
    $this->storeRentalCustomer($request);

    $data = $request->only(['customer_name', 'email', 'car_type', 'car_model', 'test_drive_date', 'other_request', 'car_url']);

    // Gửi email
    Mail::send('emails.testDriveMail', compact('data'), function ($message) use ($request) {
        $message->to($request->email)->subject('Test Drive Registration Confirmation');
    });
    
    toastr()->success("Gửi xác nhận thành công. Vui lòng kiểm tra email của bạn.");
    // Trả về thông báo thành công
    return redirect()->back();
}

}
