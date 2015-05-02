<?php
    return array
    (
        'default' => array
        (
            'type'       => 'MySQLi',
            'connection' => array(
                'hostname'   => 'localhost',
                'username'   => 'username',
                'password'   => 'password',
                'persistent' => FALSE,
                'database'   => 'database',
            ),
            'table_prefix' => '',
            'charset'      => 'utf8',
            'profiling'    => false,
        )
    );
