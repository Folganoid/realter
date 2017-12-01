@extends('layouts.main')

@section('content')
    <div class="container">
        <h2>Register</h2>
            <form class="" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <div class="col-6 form-group{{ $errors->has('name') ? ' color_red' : '' }}">
                    <label for="name" class="control-label">Name</label>
                    <input id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required
                           autofocus>
                    @if ($errors->has('name'))
                        <sup>{{ $errors->first('name') }}</sup>
                    @endif
                </div>

                <div class="col-6 form-group{{ $errors->has('surname') ? ' color_red' : '' }}">
                    <label for="surname" class="control-label">Surname</label>
                    <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}"
                           required autofocus>
                    @if ($errors->has('surname'))
                        <sup>{{ $errors->first('surname') }}</sup>
                    @endif
                </div>
                <div class="col-6 form-group">
                    <label for="role" class="control-label"></label>
                    <input type="radio" name="role" value="1" checked>I'm a client<br>
                    <input type="radio" name="role" value="2">I'm a agent<br>
                    <input type="radio" name="role" value="10">I'm a admin<br>

                </div>


                <div class=" col-3 form-group{{ $errors->has('tel') ? ' color_red' : '' }}">
                    <label for="tel" class="control-label">Telephone</label>
                    <input id="tel" type="text" class="form-control form-control-sm" name="tel" value="{{ old('tel') }}" required
                           autofocus>
                    @if ($errors->has('tel'))
                        <sup>{{ $errors->first('tel') }}</sup>
                    @endif
                </div>

                <div class="col-6 form-group{{ $errors->has('email') ? ' color_red' : '' }}">
                    <label for="email" class="control-label">E-Mail Address</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                           required>
                    @if ($errors->has('email'))
                        <sup>{{ $errors->first('email') }}</sup>
                    @endif
                </div>

                <div class="col-3 form-group{{ $errors->has('password') ? ' color_red' : '' }}">
                    <label for="password" class="control-label">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                    @if ($errors->has('password'))
                        <sup>{{ $errors->first('password') }}</sup>
                    @endif
                </div>

                <div class="col-3 form-group">
                    <label for="password-confirm" class="control-label">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Register
                    </button>
                </div>
            </form>
    </div>

@endsection
