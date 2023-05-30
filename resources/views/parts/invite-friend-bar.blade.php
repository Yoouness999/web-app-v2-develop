@if(isset($user, $user->invitation_code))
<?php
$invitation_link = url('/redirect/invitation?' . http_build_query(['invitation_code' => $user->invitation_code]));
$title = lg("common.invitation_message");
?>
    <!-- invite-friend-banner -->
    <section class="invite-friend-bar hidden-sm hidden-xs">
        <p class="invite-friend-text">Invite a friend, both get €20</p>
        <div class="invite-friend-link">
            <input class="invite-friend-field form-control" type="text" value="<?= $invitation_link; ?>"
                   onClick="this.setSelectionRange(0, this.value.length)">
        </div>
        <div class="invite-friend-social">
            <span st_title="<?= e($title); ?>" st_url="<?= $invitation_link; ?>" class='st_sharethis_large'
                  displayText='ShareThis'></span>
            <span st_title="<?= e($title); ?>" st_url="<?= $invitation_link; ?>" class='st_facebook_large'
                  displayText='Facebook'></span>
            <span st_title="<?= e($title); ?>" st_url="<?= $invitation_link; ?>" class='st_twitter_large'
                  displayText='Tweet'></span>
            <span st_title="<?= e($title); ?>" st_url="<?= $invitation_link; ?>" class='st_linkedin_large'
                  displayText='LinkedIn'></span>
            <span st_title="<?= e($title); ?>" st_url="<?= $invitation_link; ?>" class='st_pinterest_large'
                  displayText='Pinterest'></span>
            <span st_title="<?= e($title); ?>" st_url="<?= $invitation_link; ?>" class='st_email_large'
                  displayText='Email'></span>
        </div>
    </section><!-- / invite-friend-banner -->
@endif
