<?php

return [
  //dashboard
  '/' => 'DashboardController@index',

  //auth
  '/register' => 'AuthController@register',
  '/logout' => 'AuthController@logout',
  '/login' => 'AuthController@login',
  '/registerUser' => 'AuthController@registerUser',

  //users (skolotājs var veidot, editot un dzēst tikai savus skolniekus)
  '/users' => 'UsersController@index',
  '/users/show' => 'UsersController@show',
  '/users/edit' => 'UsersController@edit', // Corrected route
  '/users/create' => 'UsersController@create',
  '/users/store' => 'UsersController@store',
  '/users/update' => 'UsersController@update', // Corrected route
  '/users/destroy' => 'UsersController@destroy',

  //subjects
  '/subjects' => 'SubjectsController@index',

  '/profile' => 'ProfileController@index',
  '/profile/edit' => 'ProfileController@edit',
  '/profile/update' => 'ProfileController@update',

  //reports
  '/repotts/export' => 'ReportsController@export', // Typo: should be /reports/export?
];