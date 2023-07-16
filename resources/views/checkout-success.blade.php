@extends('layout.master')
@section('content')
    <style>
        .contact-form-item {
            margin-top: 20px;
            background-color: #fff6d4;
            border-radius: 10px;
            border: 3px dashed #ffb489;
            min-height: 400px;
            padding: 10px;
        }

        .content-container {
            margin-top: 150px;
        }
    </style>
    {{-- <p class="page-title tilte-custom">Thanh toán thành công</p> --}}
    <div class="infomation-form-container">
        <p id="event-name">Thanh toán thành công</p>
    </div>
    <img src="https://res.cloudinary.com/dpobeimdp/image/upload/v1688357585/Alvin_Arnold_Votay1_1_jxd9rr.svg"
        style="position: absolute; bottom: 15%; left:0; z-index: 100; width: 13%">
    <div class="d-flex justify-content-center align-items-center content-container">
        <div class="row w-75 mt-5">
            <div class="col-12 form-item">
                <div class="contact-form-item row m-auto">
                    @for ($i = 1; $i <= ((int) $data['quantity'] > 4 ? 4 : (int) $data['quantity']); $i++)
                        <div class='col-3'>
                            <div class="card">
                                <div class="card-body text-center">
                                    {!! QrCode::generate($data['string_to_qr']) !!} 
                                    <p class="fw-bold fs-4 mt-2">{{ $data['string_to_qr'] }}</p>
                                    <p class="fw-bold fs-5">{{ $data['ticket_name'] }}</p>
                                    <p><b>---</b></p>
                                    <p class="fs-6">Ngày sử dụng: {{ $data['date_order'] }}</p>
                                    <p><i class='bx bxs-check-circle bx-md' style='color:#44c4a1'></i></p>
                                </div>
                            </div>
                        </div>
                    @endfor
                    <p class="">Số lượng vé: {{ $data['quantity'] }}</p>
                </div>
            </div>
            <form action="{{ route('save') }}" method="post">
                @csrf
                <input type="hidden" name="session_id" value="{{ $_GET['session_id'] }}">
                <input type="hidden" name="string_to_qr" value="{{ $data['string_to_qr'] }}">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="w-25 row mt-3">
                        <button class="btn btn-primary col me-4" name="save" type="submit">Tải vé</button>
                        <button class="btn btn-primary col" name="mail" type="submit">Gửi mail</button>
                    </div>
                </div>
            </form>
        </div>
    @endsection
