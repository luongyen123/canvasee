@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                <input id="lat" type="hidden" class="form-control" name="lat" required>
                                <input id="lng" type="hidden" class="form-control " name="lng" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('/theme/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyAXXK6payVxC8Rwi7flykuz2IBl2SkSOxg" async=""defer="defer" type="text/javascript"></script>
{{-- <script src="https://maps.google.com/maps/api/js?sensor=false"></script> --}}
    <script type="text/javascript">
        // lấy vi trí hiện tại
        $(document).ready(function() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(geo_success,geo_error);
          } else {
            alert('Rất tiếc trình duyệt của bạn không hỗ trợ chia sẻ vị trí vệ tinh');
          }
        });

        window.app_info = {};

        function geo_success(pos) {
            var coord = pos.coords;
            window.app_info.myLng = coord.longitude;
            window.app_info.myLat  = coord.latitude;
            console.log(window.app_info.myLat);
            console.log(window.app_info.myLng);
            $('#lat').val(window.app_info.myLat);
            $('#lng').val(window.app_info.myLng);
        }

        function geo_error() {
          //hiển thị thông báo lỗi ở đây
        }

    </script>
@endsection
