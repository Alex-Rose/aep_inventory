<?php

Route::set('auth', '<action>(/<id>)', ['action' => '(login|logout|register|forgot)'])
    ->defaults(array(
        'controller' => 'Auth',
        'action'     => 'login',
    ));
Route::set('default', '(<controller>(/<action>(/<id>(/<option>(/<option1>)))))')
        ->defaults(array(
            'controller' => 'home',
            'action'     => 'index',
        ));
