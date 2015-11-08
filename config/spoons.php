<?php

return [

    'jsonUrl' => 'http://www.jdwetherspoon.co.uk/home/ajax/layout_find_pubs',
    'jsonDir' => base_path() . DIRECTORY_SEPARATOR . 'jsonFiles',
    'googleApi' => env('googleApi', false),

];
