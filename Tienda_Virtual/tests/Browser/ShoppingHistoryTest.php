<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use tiendaVirtual\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;

class ShoppingHistoryTest extends DuskTestCase
{
    protected $user;
    protected $password;
    protected $categoria;
    protected $producto;

    public function setUp() {
      parent::setUp();
      $this->user = 'b@mail.com';
      $this->password = 'qwert123';
    }

    /** @test */
    public function CheckOrder_AnOrderIsInList_WordVerInOrderPage()
    {
        $countProductos = count(DB::select('call getProductos()'));
        $this->browse(function (Browser $browser) use ($countProductos){
            $browser->visit('/cliente/')
                    ->click('#iniciarSesion')
                    ->type('correo', $this->user)
                    ->type('contrasena', $this->password)
                    ->press('Iniciar Sesión')
                    ->mouseover('#welcomeUser')
                    ->click('#ordenes')
                    ->assertSeeIn('.button', 'Ver');
        });
    }
}
