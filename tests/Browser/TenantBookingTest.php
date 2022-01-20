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
    * @group tenantBooking
    * @group tenantCancleBooking
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
            $browser->visit('/room/kost-kota-yogyakarta-kost-putra-eksklusif-kos-duwa-tipe-1-tegalrejo-yogyakarta')
                ->assertSee('Kos Duwa Tipe 1 Tegalrejo Yogyakarta')
                ->assertVisible('.booking-card')

                // Booking Card
                ->with('.booking-card', function($card) {
                    $card->assertVisible('.track_request_booking')
                        ->click('.track_request_booking')
                        ->assertVisible('.booking-input-checkin-content')
                        ->click('span.cell.day.today')
                        ->waitFor('.booking-rent-type__options')
                        ->assertVisible('.booking-rent-type__options')
                        ->with('.booking-rent-type__options', function($card) {
                            $card->click('[data-path="rdb_monthlyBookingOption"]');
                        })
                        ->assertVisible('button.track_request_booking')
                        ->click('button.track_request_booking');
                })

                // Booking Container
                ->waitFor('#bookingContainer')
                ->assertVisible('#bookingContainer')
                ->with('#bookingContainer', function($card) {
                    $card->assertVisible('.track_next_booking')
                        ->waitUntilMissing('div.swal2-container');
                        // ->click('.track_next_booking');
                })
                ->waitFor('.booking-summary__tnc')
                ->assertVisible('.booking-summary__tnc')
                
                ->with('.booking-summary__tnc', function($card) {
                    $card->assertVisible('.bg-c-checkbox');
                })

                // Check TnC
                ->with('.bg-c-checkbox', function($card) {
                    $card->click('.bg-c-checkbox__icon');
                })

                // Click Ajukan Sewa
                ->with('.booking-summary__booking-action', function($card) {
                    $card->waitFor('.bg-c-button')
                    ->assertVisible('.bg-c-button');
                    $card->press('.bg-c-button')->pause('3000');
                })
                ;
        });
    }

    /**
    * @test
    * @group tenantCancleBooking
    */
    public function testTenantCancleBookingKost()
    {
        $this->browse(function ($browser) {
            $browser->visit('/user/booking')
                ->waitFor('.profile-container')
                ->assertVisible('.profile-container')
                ->assertVisible('.user-booking-list')
                ->waitFor('.booking-list-card')
                ->assertVisible('.booking-list-card')
                ->with('.booking-list-card', function($card) {
                    $card->assertSee('Tunggu Konfirmasi');
                    $card->assertSee('Kos Duwa Tipe 1 Tegalrejo Yogyakarta');
                    $card->click('.hidden-xs')
                    ->assertVisible('.detail-cancel')
                    ->with('.detail-cancel', function($cardCancel) {
                        $cardCancel->waitFor('.btn-success')
                            ->scrollIntoView('.btn-success')
                            ->pause('300')
                            ->click('.btn-success');
                    });
                })
                ->pause('2000')
                ->assertSee('Berikan alasan pembatalan booking terhadap pemilik kost')
                ->assertSee('Ya, Batalkan')
                ->press('Ya, Batalkan')
                ->waitForText('Booking Kamu Dibatalkan')
                ->pause('2000');
        });
    }
}
