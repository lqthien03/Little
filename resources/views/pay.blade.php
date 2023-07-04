@extends('layout.master')
@section('content')
    <p class="page-title tilte-custom">Thanh toán</p>
    <img src="https://res.cloudinary.com/dbgqqupsw/image/upload/v1688477816/Trini_Arnold_Votay1_2_wpebb1.svg" alt=""
        style="position: absolute; bottom: 15%; left:0; z-index: 100; width: 13%">
    <form action="" method="post" class="row infomation-form-container infomation-form-container1">
        @csrf
        <input type="hidden" name="id_user" value="">
        <input type="hidden" name="id_ticket" value="">
        <input type="hidden" name="remain" value="">
        <div class="col-8 infomation-item">
            <div id="index-content" class="bfp-p">
                <div class="form-caption-container form-caption-container1">
                    <div class="form-caption text-center p-2 text-white">VÉ GIA ĐÌNH</div>
                </div>
                <div class="row">
                    <div class="mb-3 col-5">
                        <label for="total_price" class="form-label">Số tiền thanh toán</label>
                        <input readonly type="text" class="form-control" name="total_price" id="total_price"
                            value="">
                    </div>
                    <div class="mb-3 col-2">
                        <label for="quantity" class="form-label">Số vé</label>
                        <input readonly type="text" class="form-control" name="quantity" id="quantity" value="">
                    </div>
                    <div class="mb-3 col-5">
                        <label for="date_order" class="form-label">Ngày sử dụng</label>
                        <input readonly type="date" class="form-control" name="date_order" id="date_order"
                            value="">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Thông tin liên hệ</label>
                    <input readonly type="text" class="form-control" name="name" id="name" value="">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Điện thoại</label>
                    <input readonly type="text" class="form-control" name="phone" id="phone" value="">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input readonly type="email" class="form-control" name="email" id="email" value="">
                </div>
            </div>
        </div>
        <div class="col-4 form-item">
            <div id="index-form">
                <div class="form-caption-container form-caption-container2">
                    <div class="form-caption text-center p-2 text-white">Thông tin thanh toán</div>
                </div>
                <div class="mb-3">
                    <label for="card_id" class="form-label">Số thẻ</label>
                    <input type="text" class="form-control" name="" id="card_id">
                </div>
                <div class="mb-3">
                    <label for="card_owner_name" class="form-label">Họ tên chủ thẻ</label>
                    <input type="text" class="form-control" name="" id="card_owner_name">
                </div>
                <div class="mb-3">
                    <label for="card_end_date" class="form-label">Ngày hết hạn</label>
                    <input type="date" class="form-control" name="" id="card_end_date">
                </div>
                <div class="mb-3">
                    <label for="card_cvv_cvc" class="form-label">CVV/CVC</label>
                    <input type="password" class="form-control" name="" id="card_cvv_cvc">
                </div>
                <div class="d-flex align-items-center justify-content-center pb-2">
                    <button class="btn btn-primary" type="submit">Thanh toán</button>
                </div>
            </div>
        </div>
        </div>
    </form>
@endsection
