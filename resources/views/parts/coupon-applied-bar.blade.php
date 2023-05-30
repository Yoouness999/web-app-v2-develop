@if(!$user && Cookie::has('invitation_code') || !$user->godfather_id && Cookie::has('invitation_code'))
    <section class="invite-friend-bar hidden-sm hidden-xs">
        <p class="invite-friend-text"><?= lg("invitation_accepted_message"); ?></p>
    </section><!-- / invite-friend-banner -->
@endif
