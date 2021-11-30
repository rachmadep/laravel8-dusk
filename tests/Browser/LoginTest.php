<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskChromeTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskChromeTestCase
{

    public function testAccessHomePage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Mau cari kos?')
                    ->assertSee('Dapatkan infonya dan langsung sewa di Mamikos.');
        });
    }

    // /**
    // * @test
    // * @group login
    // */
    // public function testLoginOwner()
    // {
    //     $this->browse(function ($browser) {
    //         $browser->visit('/login-pemilik')
    //                 ->type('Nomor Handphone', '089112312306')
    //                 ->type('Password', 'qwerty123')
    //                 ->press('Login')
    //                 ->waitForLocation('/')
    //                 ->assertPathIs('/');
    //     });

    //     $this->browse(function (Browser $browser) {
    //         $browser->driver->manage()->deleteAllCookies();
    //     });
    // }

    /**
    * @test
    * @group login
    * @group loginTenant
    */
    public function testLoginTenant()
    {
        $this->browse(function ($browser) {
            $browser->visit('/')
                ->assertSee('Mau cari kos?')
                ->click('.nav-login-button')
                ->assertVisible('#loginModal')
                ->press('div.login-role-selection__item')
                ->waitFor('.form-login')
                ->with('.form-login', function($modal) {
                    $modal->assertSee('Login Pencari Kos')
                        ->type('[name="Nomor Handphone"]', '085884253517')
                        ->type('[name="Password"]', 'password')
                        ->press('Login');
                })
                ->waitFor('.user-profil-img')
                ->click('.user-profil-img')
                ->assertSee('Keluar');
        });
    }
}
