@extends('layouts.default')

@section('content')
    <!-- section-signup -->
    <section class="section-login" style="background-image: url(<?= asset('assets/img/bg-banner.jpg') ?>)">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

                    <div class="panel panel-default">

                        <div class="panel-heading"><?= lg("common.Login") ?></div>

                        <div class="panel-body">
                            @if($errors->any())
                                @if ($errors->first("email"))
                                    <div class="form-error">
                                        <p>
                                            <?= lg("auth.These credentials do not match our records") ?>
                                        </p>
                                    </div>
                                @elseif ($errors->first("attempts"))
                                    <div class="form-error">
                                        <p>
                                            <?= lg("auth.Too many attempts") ?>
                                        </p>
                                    </div>
                                @endif
                            @endif

                            <form role="form" method="POST" action="/auth/login">
                                @csrf

                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" value="<?= e(old('email')) ?>"
                                           placeholder="<?= lg("common.Email") ?>" required>
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" name="password"
                                           placeholder="<?= lg("auth.Password") ?>" required>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> <?= lg("auth.Remember Me") ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit"
                                            class="btn btn-primary btn-block"><?= lg("common.Login") ?></button>
                                </div>

                                <div class="form-group">
                                    <a href="/password/email">
                                        <small><?= lg("auth.Forgot Your Password?") ?></small>
                                    </a>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </div>

    </section><!-- / section-signup -->

@stop


