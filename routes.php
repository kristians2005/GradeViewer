<?php

return [
  //dashboard
  '/' => 'DashboardController@index',

  //inventory
  '/inventory' => 'InventoryController@index',
  '/inventory/show/(:num)' => 'InventoryController@show',
  '/inventory/create' => 'InventoryController@create',
  '/inventory/store' => 'InventoryController@store',
  '/inventory/edit/(:num)' => 'InventoryController@edit',
  '/inventory/update/(:num)' => 'InventoryController@update',
  '/inventory/destroy/(:num)' => 'InventoryController@destroy',

  // Products
  '/products' => 'ProductsController@index',
  '/products/create' => 'ProductsController@create',
  '/products/store' => 'ProductsController@store',
  '/products/edit/(:num)' => 'ProductsController@edit',
  '/products/update/(:num)' => 'ProductsController@update',
  '/products/show/(:num)' => 'ProductsController@show',
  '/products/destroy/(:num)' => 'ProductsController@destroy',

  //auth
  '/login' => 'AuthController@login',
  '/register' => 'AuthController@register',
  '/logout' => 'AuthController@logout',
  '/authenticate' => 'AuthController@authenticate',
  '/registerUser' => 'AuthController@registerUser',

  //users
  '/users' => 'UsersController@index',
  '/users/show' => 'UsersController@show',
  '/users/edit' => 'UsersController@edit', // Corrected route
  '/users/create' => 'UsersController@create',
  '/users/store' => 'UsersController@store',
  '/users/update' => 'UsersController@update', // Corrected route
  '/users/destroy' => 'UsersController@destroy',

  //orders
  '/orders' => 'OrdersController@index',
  '/orders/show' => 'OrdersController@show', // Fixed: Added (:num) for product ID
  '/orders/store' => 'OrdersController@store',
  '/orders/order' => 'OrdersController@order',     // Added for the new order view
  '/orders/updateStatus' => 'OrdersController@updateStatus',

  //reports
  '/reports/orders' => 'ReportsController@generateOrdersReport',
  '/repotts/export' => 'ReportsController@export', // Typo: should be /reports/export?
  '/reports/show' => 'ReportsController@show',
];