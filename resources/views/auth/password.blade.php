@extends('layouts.default')

@section('content')
    <section class="section-login" style="background-image: url({{ asset('assets/img/bg-banner.jpg') }})">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?= lg("auth.Reset your password") ?>
                        </div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    <?= lg("auth.We have e-mailed your password reset link!") ?>
                                </div>
                            @endif

                            <form class="form-horizontal" role="form" method="POST" action="/password/email">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?= lg("auth.Email Address") ?></label>

                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="email"
                                               value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit"  class="mt-0 btn btn-block btn-primary">
                                            <?= lg("auth.Reset my password") ?>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @if($errors->any())
                                <div class="alert alert-danger text-left">
                                    <?= lg("common.Some fields are mandatory") ?><br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
