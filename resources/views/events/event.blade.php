@extends('layout.master')
@section('content')
    <img src="https://res.cloudinary.com/dbgqqupsw/image/upload/v1688568499/Frame_entzej.svg" alt=""
        style="position: absolute; top: 10%; left: 0;width:30%">
    <img src="https://res.cloudinary.com/dbgqqupsw/image/upload/v1688568500/Frame2_hrfrrk.svg" alt=""
        style="position: absolute; top: 2%; right: 0;width:30%">
    <div class="row infomation-form-container">
        <p id="event-name">Sự kiện nổi bật</p>
    </div>
    <div class="row d-flex justify-content-center" id="box-event">
        @foreach ($events as $item)
            <div class="card" style="width: 18rem;">
                <img src="{{ $item->url }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h3 class="card-title">{{ $item->name }}</h3>
                    <p class="card-text">{{ $item->location }}</p>
                    <p><i class='bx bx-calendar' style="color: #FFB809"></i>{{ $item->time_start }} - {{ $item->time_end }}
                    </p>

                    <p class="card-price">{{ $item->price }} VNĐ</p>
                    <a href="/event-detail/{id}" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        @endforeach
        {{-- <div class="card" style="width: 18rem;">
            <img src="https://res.cloudinary.com/dvgudlkak/image/upload/v1688393475/Rectangle_3_p0nit6.svg"
                class="card-img-top" alt="...">
            <div class="card-body">
                <h3 class="card-title">Sự kiện 1</h3>
                <p class="card-text">Đầm sen Park</p>
                <p><i class='bx bx-calendar' style="color: #FFB809"></i>30/05/2023 - 01/06/2023</p>

                <p class="card-price">25.000 VNĐ</p>
                <a href="/event-detail/{id}" class="btn btn-primary">Xem chi tiết</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="https://res.cloudinary.com/dvgudlkak/image/upload/v1688393475/Rectangle_3_p0nit6.svg"
                class="card-img-top" alt="...">
            <div class="card-body">
                <h3 class="card-title">Sự kiện 1</h3>
                <p class="card-text">Đầm sen Park</p>
                <p><i class='bx bx-calendar' style="color: #FFB809"></i>30/05/2023 - 01/06/2023</p>
                <p class="card-price">25.000 VNĐ</p>
                <a href="/event-detail/{id}" class="btn btn-primary">Xem chi tiết</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="https://res.cloudinary.com/dvgudlkak/image/upload/v1688393475/Rectangle_3_p0nit6.svg"
                class="card-img-top" alt="...">
            <div class="card-body">
                <h3 class="card-title">Sự kiện 1</h3>
                <p class="card-text">Đầm sen Park</p>
                <p><i class='bx bx-calendar' style="color: #FFB809"></i>30/05/2023 - 01/06/2023</p>
                <p class="card-price">25.000 VNĐ</p>
                <a href="/event-detail/{id}" class="btn btn-primary">Xem chi tiết</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="https://res.cloudinary.com/dvgudlkak/image/upload/v1688393475/Rectangle_3_p0nit6.svg"
                class="card-img-top" alt="...">
            <div class="card-body">
                <h3 class="card-title">Sự kiện 1</h3>
                <p class="card-text">Đầm sen Park</p>
                <p><i class='bx bx-calendar' style="color: #FFB809"></i>30/05/2023 - 01/06/2023</p>
                <p class="card-price">25.000 VNĐ</p>
                <a href="/event-detail/{id}" class="btn btn-primary">Xem chi tiết</a>
            </div>
        </div> --}}
    </div>
@endsection
