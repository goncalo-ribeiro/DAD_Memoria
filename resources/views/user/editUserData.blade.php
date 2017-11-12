@extends('master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit User Data</div>
                    <div class="panel-body">
                        <form action="{{route('updateData')}}" method="post" class="form-group"
                              enctype="multipart/form-data" id="data-form">
                            <div class="form-group">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="control-label">Name</label>
                                    <input
                                            type="text" class="form-control"
                                            name="name" id="name"
                                            value="{{old('name', Auth::user()->name)}}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('nickname') ? ' has-error' : '' }}">
                                    <label for="nickname" class="control-label">Nickname</label>
                                    <input
                                            type="text" class="form-control"
                                            name="nickname" id="nickname" value="{{old('nickname', Auth::user()->nickname)}}" required autofocus>
                                    @if ($errors->has('nickname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nickname') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">E-Mail</label>
                                    <input
                                            type="text" class="form-control"
                                            name="email" id="email"
                                            placeholder="Name" value="{{old('email', Auth::user()->email)}}" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary side-offset">Save</button>
                                <a class="btn btn-default" href="{{route('home')}}">Cancel</a>
                                <a class="btn btn-warning" href='javascript:showPassword()' style="float:right;">Change
                                    Password</a>
                            </div>
                        </form>
                        <form action="{{route('updatePassword')}}" method="post" class="form-group"
                              id="password-form" style="display:none">
                            {{method_field('PUT')}}
                            <div class="form-group">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('oldPassword') ? ' has-error' : '' }}">
                                    <label for="inputPassword" class="control-label">Original Password</label>
                                    <input type="password" class="form-control" name="oldPassword" id="inputPassword"
                                           placeholder="Password" required>
                                    @if ($errors->has('oldPassword'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('oldPassword') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('newPassword') ? ' has-error' : '' }}">
                                    <label for="inputNewPassword" class="control-label">New Password</label>
                                    <input type="password" class="form-control" name="newPassword" id="inputNewPassword"
                                           placeholder="Password" required>
                                    @if ($errors->has('newPassword'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('newPassword') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('newPasswordConfirmation') ? ' has-error' : '' }}">
                                    <label for="inputPasswordConfirmation" class="control-label">New Password
                                        Confirmation</label>
                                    <input type="password" class="form-control" name="newPasswordConfirmation"
                                           id="inputPasswordConfirmation" placeholder="Password Confirmation" required>
                                    @if ($errors->has('newPasswordConfirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('newPasswordConfirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary side-offset">Save Password</button>
                                <a class="btn btn-default" href='javascript:hidePassword()'>Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(count($errors))
        @if($errors->has('oldPassword') || $errors->has('newPassword') || $errors->has('newPasswordConfirmation'))
            <script type='text/javascript'>window.onload = showPassword();</script>
        @endif
    @endif
    <script>
        function showPassword() {
            $('#data-form').hide();
            $('#password-form').show();

        }
        function hidePassword() {
            $('#password-form').hide();
            $('#data-form').show();
        }
    </script>
@endsection