<?php

use CarClub\Router;

Router::addRoute('/', 'get', 'HomepageController@index');
Router::addRoute('/name/{firstname}/[{lastname}]', 'get', 'NameController@echoName');
