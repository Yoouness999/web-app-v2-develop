<?php

/**
 * Test the whole Invoice Process
 *
 * @comment php vendor/phpunit/phpunit/phpunit tests/ApiUserTest
 */

use App\User;

class SponsorshipProcessTest extends TestCase
{
    /**
     * Test the sponsorship flow
     *
     * @test
     */
    public function testCouponFlow()
    {
        $this->resetUsers();

        $godfather = User::firstOrCreate([
            'email' => 'godfather@cherrypulp.com',
            'first_name' => 'Godfather',
            'last_name' => "Test"
        ]);

        /**
         * @see \App\Handlers\Events\UserInviteFriendHandler
         * @var $invite \App\Invite
         */
        $invite = event(new \App\Events\UserInviteFriendEvent($godfather, 'godson@cherrypulp.com', true));

        $this->assertNotNull($invite);
    }

    public function resetUsers(){
        # Delete users
        $testUsers = User::withTrashed()->whereIn('email', ['godfather@cherrypulp.com', 'godson@cherrypulp.com'])->get();

        if($testUsers){
            foreach ($testUsers as $user) {
                echo "delete {$user->email} #{$user->id} \n";
                \App\Api::deleteUser($user->id);
            }
        }
    }
}
