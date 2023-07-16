@extends('layout.master')
@section('content')
    <div style="height: 500px">
        <img src="https://res.cloudinary.com/dbgqqupsw/image/upload/v1688477821/Alex_AR_Lay_Do_shadow_2_agm5gz.svg"
            alt="" style="position: absolute; bottom: 15%; left:0; z-index: 100; width: 13%">
        <div class="infomation-form-container">
            <p id="event-name">Liên hệ</p>
        </div>
        <div class="row infomation-form-contact ">
            <div class="col-8 ">
                <div class="row" id="event-content">
                    <form action="/send-contact" method="post">
                        @csrf
                        <label for="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ac mollis
                            justo. Etiam volutpat tellus quis risus volutpat, ut posuere ex facilisis. </label>
                        <div class="row mb-3 mt-3">
                            <div class="col-4"><input type="text" class="form-control" placeholder="Tên" name="name">
                            </div>

                            <div class="col-8"><input type="text" class="form-control" placeholder="Email"
                                    name="email"></div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><input type="text" class="form-control" placeholder="Số điện thoại"
                                    name="phone">
                            </div>

                            <div class="col-8"><input type="text" class="form-control" placeholder="Địa chỉ"
                                    name="address"></div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <textarea class="form-control" name="messeger" placeholder="Nhập lời nhắn" rows="4"></textarea>

                            </div>
                        </div>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('messeger')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        <div class="d-flex align-items-center justify-content-center w-50 m-auto">
                            <button type="submit" class="btn btn-primary mt-3" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Gửi liên hệ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-4">
                <div class="form-item mb-4">
                    <div class="row m-auto" id="event-contact">
                        <div class="col-3 d-flex justify-content-center align-items-center">
                            <img src="https://res.cloudinary.com/dvgudlkak/image/upload/v1688441213/Group2_gkojbw.svg"
                                alt="">
                        </div>
                        <div class="col-9">
                            <p class="fw-bold">Địa chỉ:</p>
                            <p>86/33 Âu Cơ, Phường 9, Quận Tân Bình, TP. Hồ Chí Minh</p>
                        </div>
                    </div>
                </div>
                <div class="form-item mb-4 ">
                    <div class="row m-auto" id="event-contact">
                        <div class="col-3 d-flex justify-content-center align-items-center">
                            <img src="https://res.cloudinary.com/dvgudlkak/image/upload/v1688441212/Group_gewlcr.svg"
                                alt="">
                        </div>
                        <div class="col-9">
                            <p class="fw-bold">Email:</p>
                            <p>quocthien0404@gmail.com</p>
                        </div>
                    </div>
                </div>
                <div class="form-item">
                    <div class="row m-auto" id="event-contact">
                        <div class="col-3 d-flex justify-content-center align-items-center">
                            <img src="https://res.cloudinary.com/dvgudlkak/image/upload/v1688441212/Group3_ury12n.svg"
                                alt="">
                        </div>
                        <div class="col-9">
                            <p class="fw-bold">Điện thoại:</p>
                            <p>0363008204</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
