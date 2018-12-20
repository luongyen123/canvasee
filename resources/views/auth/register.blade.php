@extends('layouts.app')

@section('content')
<div class="container" onload="initialize()">
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

//get address by gg map api
 {{--<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyAXXK6payVxC8Rwi7flykuz2IBl2SkSOxg" async defer type="text/javascript"></script>--}}
{{-- <script src="https://maps.google.com/maps/api/js?sensor=false"></script> --}}
{{--<script type="text/javascript" src="http://maps.googleapis.com/maps/api/geocode/json?address=bucharest&sensor=false "></script>--}}
    {{--<script type="text/javascript">--}}
        {{--window.onload = function () {--}}
            {{--var startPos;--}}
            {{--var geoOptions = {--}}
                {{--maximumAge: 5 * 60 * 1000,--}}
                {{--timeout: 10 * 1000,--}}
                {{--enableHighAccuracy: true--}}
            {{--}--}}


            {{--var geoSuccess = function (position) {--}}
                {{--startPos = position;--}}
                {{--geocodeLatLng(startPos.coords.latitude, startPos.coords.longitude);--}}

            {{--};--}}
            {{--var geoError = function (error) {--}}
                {{--console.log('Error occurred. Error code: ' + error.code);--}}
                {{--// error.code can be:--}}
                {{--//   0: unknown error--}}
                {{--//   1: permission denied--}}
                {{--//   2: position unavailable (error response from location provider)--}}
                {{--//   3: timed out--}}
            {{--};--}}

            {{--navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions);--}}
        {{--};--}}
        {{--function geocodeLatLng(lat, lng) {--}}
            {{--var geocoder = new google.maps.Geocoder;--}}
            {{--var latlng = {lat: parseFloat(lat), lng: parseFloat(lng)};--}}
            {{--console.log( parseFloat(lat));--}}
            {{--console.log( parseFloat(lng));--}}
            {{--document.getElementById('lat').innerHTML =parseFloat(lat);--}}
            {{--document.getElementById('lng').innerHTML =parseFloat(lng);--}}
            {{--geocoder.geocode({'location': latlng}, function (results, status) {--}}
                {{--if (status === 'OK') {--}}
                    {{--console.log(results)--}}
                    {{--if (results[0]) {--}}
{{--//                        document.getElementById('location').innerHTML = results[0].formatted_address;--}}
                        {{--var street = "";--}}
                        {{--var city = "";--}}
                        {{--var state = "";--}}
                        {{--var country = "";--}}
                        {{--var zipcode = "";--}}
                        {{--var short_name = "";--}}
                        {{--for (var i = 0; i < results.length; i++) {--}}
                            {{--if (results[i].types[0] === "political") {--}}
                                {{--city = results[i].address_components[2].long_name;--}}
                                {{--state = results[i].address_components[2].long_name;--}}

                            {{--}--}}
                            {{--if (results[i].types[0] === "postal_code" && zipcode == "") {--}}
                                {{--zipcode = results[i].plus_code.global_code;--}}

                            {{--}--}}
                            {{--if (results[i].types[0] === "country") {--}}
                                {{--country = results[i].address_components[0].long_name;--}}
                                {{--short_name = results[i].address_components[0].short_name;--}}

                            {{--}--}}
                            {{--if (results[i].types[0] === "route" && street == "") {--}}

                                {{--for (var j = 0; j < 4; j++) {--}}
                                    {{--if (j == 0) {--}}
                                        {{--street = results[i].address_components[j].long_name;--}}
                                    {{--} else {--}}
                                        {{--street += ", " + results[i].address_components[j].long_name;--}}
                                    {{--}--}}
                                {{--}--}}

                            {{--}--}}
                            {{--if (results[i].types[0] === "street_address") {--}}
                                {{--for (var j = 0; j < 4; j++) {--}}
                                    {{--if (j == 0) {--}}
                                        {{--street = results[i].address_components[j].long_name;--}}
                                    {{--} else {--}}
                                        {{--street += ", " + results[i].address_components[j].long_name;--}}
                                    {{--}--}}
                                {{--}--}}

                            {{--}--}}
                        {{--}--}}
                        {{--if (zipcode == "") {--}}
                            {{--if (typeof results[0].address_components[8] !== 'undefined') {--}}
                                {{--zipcode = results[0].address_components[8].long_name;--}}
                            {{--}--}}
                        {{--}--}}
                        {{--if (country == "") {--}}
                            {{--if (typeof results[0].address_components[7] !== 'undefined') {--}}
                                {{--country = results[0].address_components[7].long_name;--}}
                            {{--}--}}
                        {{--}--}}
                        {{--if (state == "") {--}}
                            {{--if (typeof results[0].address_components[6] !== 'undefined') {--}}
                                {{--state = results[0].address_components[6].long_name;--}}
                            {{--}--}}
                        {{--}--}}
                        {{--if (city == "") {--}}
                            {{--if (typeof results[0].address_components[5] !== 'undefined') {--}}
                                {{--city = results[0].address_components[5].long_name;--}}
                            {{--}--}}
                        {{--}--}}

                        {{--var address = {--}}
                            {{--"street": street,--}}
                            {{--"city": city,--}}
                            {{--"state": state,--}}
                            {{--"country": country,--}}
                            {{--"zipcode": zipcode,--}}
                            {{--"shortname":short_name--}}
                        {{--};--}}

{{--//                        document.getElementById('location').innerHTML = document.getElementById('location').innerHTML + "<br/>Street : " + address.street + "<br/>City : " + address.city + "<br/>State : " + address.state + "<br/>Country : " + address.country + "<br/>zipcode : " + address.zipcode;--}}
                        {{--console.log(address);--}}
                    {{--} else {--}}
                        {{--window.alert('No results found');--}}
                    {{--}--}}
                {{--} else {--}}
                    {{--window.alert('Geocoder failed due to: ' + status);--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}

    {{--</script>--}}

@endsection
