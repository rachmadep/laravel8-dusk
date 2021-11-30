<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskChromeTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TenantBookingTest extends DuskChromeTestCase
{

    /**
    * @test
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

    /**
    * @test
    * @group tenantBooking
    */
    public function testTenantBookingKost()
    {
        $this->browse(function ($browser) {
            $browser->visit('/room/kost-kost-campur-murah-kost-zahira-papua')
                ->assertSee('Kost Zahira Papua Yogyakarta')
                ->assertVisible('.booking-card')
                ->with('.booking-card', function($card) {
                    $card->assertVisible('.track_request_booking')
                        ->click('.track_request_booking')
                        ->assertVisible('.booking-input-checkin-content')
                        ->click('span.cell.day.today')
                        ->waitFor('.booking-rent-type__options')
                        ->assertVisible('.booking-rent-type__options')
                        ->with('.booking-rent-type__options', function($card) {
                            $card->click('[data-path="rdb_quarterlyBookingOption"]');
                        })
                        ->assertSee('Untuk hitungan sewa per 3 bulan, minimal durasi ngekos adalah 6 bulan.')
                        ->assertVisible('button.track_request_booking')
                        ->click('button.track_request_booking');
                })
                ->waitFor('#bookingContainer')
                ->assertVisible('#bookingContainer')
                ->with('#bookingContainer', function($card) {
                    $card->assertVisible('.track_next_booking')
                        ->waitUntilMissing('div.swal2-container')
                        ->click('.track_next_booking');
                })
                ->assertVisible('.booking-summary__tnc')
                ->assertVisible('#infoTnC_check')
                // ->with('.booking-summary__tnc', function($card) {
                //     $card->assertVisible('input#infoTnC_check')
                //         ->check('#infoTnC_check');
                // })
                // ->assertVisible('.booking-summary__tnc')
                ;
                // ->press('.track_request_booking')
                // ->waitFor('.booking-input-checkin-content')
                // ->assertSee('Waktu mulai ngekos terdekat: di hari H setelah pengajuan sewa.');
        });
    }
}
