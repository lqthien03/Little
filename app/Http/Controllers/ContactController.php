<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // public function sendContact(Request $request)
    // {
    //     $arr = request()->post();
    //     $name = trim(strip_tags($arr['name']));
    //     $phone = trim(strip_tags($arr['phone']));
    //     $email = trim(strip_tags($arr['email']));
    //     $address = trim(strip_tags($arr['address']));
    //     $messeger = trim(strip_tags($arr['messeger']));
    //     $adminEmail = 'quocthien0404@gmail.com';

    //     Mail::mailer('smtp')->to($adminEmail)
    //         ->send(new ContactEmail($name, $phone, $email, $address, $messeger));

    //     return view('contact')->with(['adminEmail' => $adminEmail]);
    // }
    public function sendContact(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'messeger' => 'required',
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
