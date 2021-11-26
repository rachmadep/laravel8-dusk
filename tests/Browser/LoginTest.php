<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskChromeTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskChromeTestCase
{

    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Mau cari kos?');
        });
    }

    /**
    * @test
    * @group login
    */
    public function testLogin()
    {
        // $user = User::factory()->create();

        $this->browse(function ($browser) {
            $browser->visit('/login-pemilik')
                    ->type('Nomor Handphone', '089112312306')
                    ->type('Password', 'qwerty123')
                    ->press('Login')
                    ->waitForLocation('/')
                    // ->waitUntilSee('Pendapatan')
                    // ->assertSee('Pendapatan')
                    // ->assertUrlIs('https://owner-jambu.kerupux.com/');
                    ->assertPathIs('/');
        });
    }
}
