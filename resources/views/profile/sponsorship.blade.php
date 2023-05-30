@extends('layouts.profile')


@section('js')
@parent
@if($results && count($results))
    <div class="modal fade" id="modal-confirmation">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button class="close" type="button" data-dismiss="modal"></button>
                    <img class="center-block" src="<?= asset(lg('sponsorship.modal.image')) ?>" alt="<?= lg('sponsorship.modal.title') ?>">
                    <h4><?= trans_choice('sponsorship.modal.title', count($results) - count($exists)) ?>
                </div>
                @if (count($exists))
                    <div class="modal-footer">
                        <h5><?= trans_choice('sponsorship.modal.sub-title', count($exists)) ?></h5>
                        @foreach($exists as $email => $result)
                            <?= $email ?><br>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        jQuery('#modal-confirmation').modal('show');
    </script>
@endif
@stop


@section('subcontent')
<section class="section section--sponsorship">
    <div class="row">
        <div class="col-xs-12">

            <div class="section__header">
                <h1><?= lg('sponsorship.title') ?></h1>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">

                    <ul class="profile-nav">
                        <li class="active">
                            <a href="#sponsorship" data-toggle="tab">
                                <?= lg('sponsorship.tabs.sponsorship') ?>
                            </a>
                        </li>
                        <li>
                            <a href="#my_sponsorship" data-toggle="tab">
                                <?= lg('sponsorship.tabs.my_sponsorship') ?>
                            </a>
                        </li>
                    </ul>

                    <div class="divider divider--hidden divider--x2" aria-hidden="true"></div>

                    <div class="tab-content">
                        <div class="tab-pane active" id="sponsorship">
                            <p>
                                <?= lg('sponsorship.sponsorship.intro') ?>
                            </p>

                            @if($godfather)
                                <h2>
                                    <?= shortcode(lg('sponsorship.sponsorship.link.title'), ['user' => $godfather]) ?>
                                </h2>
                            @endif

                            <div class="row">
                                <label for="sponsorship_link" class="col-sm-4">
                                    <?= lg('sponsorship.sponsorship.link.your_link') ?>
                                </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input class="form-control" id="sponsorship_link" type="text" name="sponsorship_link" value="{!! $sponsorship_link !!}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary btn-block js-clipboard" type="button" data-clipboard-target="#sponsorship_link">
                                                <?= lg('sponsorship.sponsorship.link.button') ?>
                                            </button>
                                        </span>
                                    </div>

                                    <div class="divider divider--hidden" aria-hidden="true"></div>

                                    <ul class="list-inline">
                                        <li>
                                            <a class="btn btn-facebook" href="<?= str_replace('{url}', $sponsorship_link, lg('sponsorship.share.facebook.link')) ?>" target="_blank">
                                                <i class="fa fa-facebook" aria-hidden="true"></i> <?= lg('sponsorship.share.facebook.text') ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="btn btn-twitter" href="<?= str_replace('{url}', $sponsorship_link, lg('sponsorship.share.twitter.link')) ?>" target="_blank">
                                                <i class="fa fa-twitter" aria-hidden="true"></i> <?= lg('sponsorship.share.twitter.text') ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="divider divider--hidden divider--x2" aria-hidden="true"></div>

                            <form class="form-horizontal js-repeater" action="" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <fieldset>
                                    <legend><?= lg('sponsorship.sponsorship.invitation.title') ?></legend>

                                    <div data-repeater-list="invitations">
                                        <div class="form-group" data-repeater-item>
                                            <label for="email" class="col-sm-4"><?= lg('sponsorship.sponsorship.invitation.email.label') ?></label>
                                            <div class="col-sm-8">
                                                <div class="input-repeated">
                                                    <input class="form-control" id="email" type="email" name="email" value="" placeholder="<?= lg('sponsorship.sponsorship.invitation.email.placeholder') ?>" required>
                                                    <button class="btn btn-white" type="button" data-repeater-delete>
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4"><?= lg('sponsorship.sponsorship.invitation.add') ?></label>
                                        <div class="col-sm-8">
                                            <button class="btn btn-white btn-icon" type="button" data-repeater-create>
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="divider divider--hidden" aria-hidden="true"></div>

                                <div class="text-right">
                                    <button class="btn btn-primary" type="submit">
                                        <?= lg('sponsorship.sponsorship.invitation.submit') ?>
                                    </button>
                                </div>
                            </form>
                        </div>


                        <div class="tab-pane" id="my_sponsorship">

                            <?php
                                if($user->godfather):
                            ?>
                            <h2><?= shortcode(lg('sponsorship.my_sponsorship.title'), ['user' => $user->godfather->toArray()]) ?></h2>
                            <?php
                                endif;
                            ?>

                            @if(isset($invites) && count($invites))
                                <table class="table">
                                    <tr>
                                        <th><?= lg('sponsorship.my_sponsorship.table.referrals') ?></th>
                                        <th><?= lg('sponsorship.my_sponsorship.table.validation') ?></th>
                                        <th><?= lg('sponsorship.my_sponsorship.table.coupon') ?></th>
                                        <th><?= lg('sponsorship.my_sponsorship.table.resend') ?></th>
                                    </tr>
                                    @foreach($invites as $invite)
                                        <tr>
                                            <td>
                                                <?= $invite['email']; ?>
                                            </td>
                                            <td>
                                                @if ($invite->isClaimed())
                                                    <span class="text-success"><?= lg('sponsorship.status.valid') ?></span>
                                                @elseif($invite->isAlreadyClaimed())
                                                    <span class="text-danger"><?= lg('sponsorship.status.already_claimed') ?></span>
                                                @elseif($invite->isExpired())
                                                    <span class="text-danger"><?= lg('sponsorship.status.expired') ?></span>
                                                @else
                                                    <span class="text-danger"><?= lg('sponsorship.status.not_valid') ?></span>
                                                @endif
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>
                                                @if ($invite->isClaimed())
                                                    <span class="text-muted"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                                @else
                                                    <a href=""><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                <div class="alert alert-info">
                                    <?= lg('sponsorship.my_sponsorship.is_empty') ?>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
@stop
