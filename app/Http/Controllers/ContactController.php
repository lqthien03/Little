<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contact()
    {
        return view('contact');
    }


    public function sendContact(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'messeger' => 'required',
        ], [
            'name.required' => 'Tên không được bỏ trống',
            'phone.required' => 'Số điện thoại không được bỏ trống',
            'email.required' => 'Email không được bỏ trống',
            'email.email' => 'Email không hợp lệ',
            'address.required' => 'Địa chỉ không được bỏ trống',
            'message.required' => 'Tin nhắn không được bỏ trống',

        ]);

        $name = trim(strip_tags($validatedData['name']));
        $phone = trim(strip_tags($validatedData['phone']));
        $email = trim(strip_tags($validatedData['email']));
        $address = trim(strip_tags($validatedData['address']));
        $messeger = trim(strip_tags($validatedData['messeger']));
        $adminEmail = 'quocthien0404@gmail.com';

        Mail::mailer('smtp')->to($adminEmail)
            ->send(new ContactEmail($name, $phone, $email, $address, $messeger));

        return view('contact')->with(['adminEmail' => $adminEmail]);
    }
}
