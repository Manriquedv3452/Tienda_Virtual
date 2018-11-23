<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RateTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/cliente/')
                    ->type('buscador', 'c')
                    ->press('.header_search_button')
                    ->mouseover('#sorter')
                    ->click('#byRate')
                    ->assertSeeIn('#product_price_17', '$15.85');
        });
    }
}
