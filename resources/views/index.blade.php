@extends('layout.master')
@section('title', 'Trang chủ')
@section('content')
    {{-- @include('layouts.index-context') --}}
    <img src="https://res.cloudinary.com/dpobeimdp/image/upload/v1688358523/image_2_mzjbow.svg" id="damsen-logo">
    <p id="damsen-name" class="tilte-custom">Đầm sen <br> park</p>
    <img src="https://res.cloudinary.com/dpobeimdp/image/upload/v1688357583/Lisa_Arnold_Lay_Do_F2_3_xrphdg.svg"id="context1">
    <img src="https://res.cloudinary.com/dpobeimdp/image/upload/v1688357580/18451_Converted_-06_1_eh6nzi.svg" id="context2">
    <img src="https://res.cloudinary.com/dpobeimdp/image/upload/v1688357580/18451_Converted_-04_1_axp9av.svg" id="context3">
    <img src="https://res.cloudinary.com/dpobeimdp/image/upload/v1688357586/18451_Converted_-03_1_mrin8x.svg"id="context4">
    <img src="https://res.cloudinary.com/dpobeimdp/image/upload/v1688357578/18451_Converted_-02_1_jj14bl.svg"id="context5">
    <img src="https://res.cloudinary.com/dpobeimdp/image/upload/v1688357582/render_fix_hair_1_vnao4j.svg" id="context6">
    <img src="https://res.cloudinary.com/dpobeimdp/image/upload/v1688357576/18451_Converted_-05_1_mqb5vv.svg"id="context7">
    <img src="https://res.cloudinary.com/dpobeimdp/image/upload/v1688357576/18451_Converted_-03_2_xmqy9u.svg"id="context8">
    <div class="row infomation-form-container">
        <div class="col-8 infomation-item">
            <div id="index-content">
                <p>Chào mừng đến với Little And Little</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima officia necessitatibus doloribus placeat,
                    ab voluptates laborum sequi consectetur accusamus explicabo commodi numquam magni quo praesentium
                    tempora assumenda deserunt totam consequatur.</p>

                <ul>
                    <li>Số vé phải nhiều hơn 1</li>
                    <li>Ngày đặt phải sau hoặc trong hôm nay</li>
                    <li>Số điện thoại của bạn dùng để tra hóa đơn khi bạn làm mất vé</li>
                    <li>Vé sẽ được gửi về mail bạn nhập</li>
                </ul>
            </div>
        </div>
        <div class="col-4 form-item">
            <form action="{{ route('beforepay') }}" method="post" id="index-form">
                @csrf
                <div class="form-caption-container form-caption-container-index">
                    <div class="form-caption text-center p-2 text-white">Vé của bạn</div>
                </div>

                <select name="ticket" id="ticket" class="form-control mt-3">
                    @foreach ($tickets as $item)
                        <option value="{{ $item->id }}"> {{ $item->name }} </option>
                    @endforeach
                </select>
                <div class="row col-12">
                    <div class="col-5">
                        <input class="form-control mt-3 pe-0" placeholder="Số lượng vé" type="number" name="quantity"
                            id="quantity" value="{{ old('quantity') }}" required>
                        @error('quantity')
                            <em class="text-danger fs-6">
                                {{ $message }}
                            </em>
                        @enderror
                    </div>

                    <div class="col-7 ps-0">
                        <input class="form-control mt-3" placeholder="Ngày đặt vé" type="date" name="date_order"
                            id="date_order" value="{{ old('date_order') }}" required>
                        @error('date_order')
                            <em class="text-danger fs-6">   
                                {{ $message }}
                            </em>
                        @enderror
                    </div>
                </div>
                <input class="form-control mt-3" placeholder="Họ và tên" type="text" name="name" id="name"
                    value="{{ old('name') }}" required>
                @error('name')
                    <em class="text-danger fs-6">
                        {{ $message }}
                    </em>
                @enderror
                <input class="form-control mt-3" placeholder="Số điện thoại" type="text" name="phone" id="phone"
                    value="{{ old('phone') }}" required>
                @error('phone')
                    <em class="text-danger fs-6">
                        {{ $message }}
                    </em>
                @enderror
                <input class="form-control mt-3" placeholder="Email" type="email" name="email" id="email"
                    value="{{ old('phone') }}" required>
                <div class="d-flex align-items-center justify-content-center">
                    <button class="btn btn-primary mt-3" type="submit">Đặt vé</button>
                </div>
            </form>
        </div>
    </div>

@endsection
