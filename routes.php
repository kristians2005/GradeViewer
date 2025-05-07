<?php

return [
  // Public routes
  '/welcome' => ['controller' => 'DashboardController@index', 'roles' => []],
  '/login' => ['controller' => 'AuthController@login', 'roles' => []],
  '/register' => ['controller' => 'AuthController@register', 'roles' => []],
  '/registerUser' => ['controller' => 'AuthController@registerUser', 'roles' => []],

  // Protected routes - Student
  '/student/dashboard' => ['controller' => 'StudentController@dashboard', 'roles' => ['student']],
  '/student/grades' => ['controller' => 'StudentController@grades', 'roles' => ['student']],
  '/student/subjects' => ['controller' => 'StudentController@subjects', 'roles' => ['student']],

  // Protected routes - Teacher
  '/teacher/dashboard' => ['controller' => 'TeacherController@dashboard', 'roles' => ['teacher']],
  '/teacher/students' => ['controller' => 'TeacherController@students', 'roles' => ['teacher']],
  '/teacher/grades' => ['controller' => 'TeacherController@grades', 'roles' => ['teacher']],
  '/teacher/subjects' => ['controller' => 'TeacherController@subjects', 'roles' => ['teacher']],

  // Common protected routes
  '/profile' => ['controller' => 'ProfileController@index', 'roles' => ['student', 'teacher']],
  '/profile/edit' => ['controller' => 'ProfileController@edit', 'roles' => ['student', 'teacher']],
  '/profile/update' => ['controller' => 'ProfileController@update', 'roles' => ['student', 'teacher']],
  '/logout' => ['controller' => 'AuthController@logout', 'roles' => ['student', 'teacher']],

  // Default route - redirects based on role
  '/' => ['controller' => 'DashboardController@index', 'roles' => ['student', 'teacher']],

  //users (skolotājs var veidot, editot un dzēst tikai savus skolniekus)
  '/users' => 'UsersController@index',
  '/users/show' => 'UsersController@show',
  '/users/edit' => 'UsersController@edit', // Corrected route
  '/users/create' => 'UsersController@create',
  '/users/store' => 'UsersController@store',
  '/users/update' => 'UsersController@update', // Corrected route
  '/users/destroy' => 'UsersController@destroy',

  //home
  '/home' => 'StudentController@index',
  '/subjects/assign' => 'SubjectsController@assign',

  //reports
  '/repotts/export' => 'ReportsController@export', // Typo: should be /reports/export?
];