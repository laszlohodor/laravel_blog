<?php


namespace App\Http\ViewModel\Provider;


use App\Http\ViewModel\Menu;

interface MenuProvider
{
    /**
     * Return a Menu built for sidebar
     *
     * @return Menu
     */
    function provide();

}
