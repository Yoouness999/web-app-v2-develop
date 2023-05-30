@extends('layouts.default')

@section('content')
    <section class="section-login" style="background-image: url({{ asset('assets/img/bg-banner.jpg') }})">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading"><?= lg("auth.Reset your password") ?></div>
                        <div class="panel-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <?php
                            if (!isset($formAction)) {
                                $formAction = "/reset-password";
                            }
                            ?>
                            <form class="form-horizontal" role="form" method="POST" action="<?= $formAction; ?>">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?= lg("auth.Email Address") ?></label>

                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="email"
                                               value="{{ old('email') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?= lg("auth.Password") ?></label>

                                    <div class="col-md-6">
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?= lg("auth.Confirm Password") ?></label>
                                    <div class="col-md-6">
                                        <input type="password" class="form-control" name="password_confirmation">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="mt-0 btn btn-block btn-primary">
                                            <?= lg("auth.Reset your password") ?>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
