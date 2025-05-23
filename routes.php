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
  '/teacher/classes' => ['controller' => 'TeacherController@classes', 'roles' => ['teacher']],
  '/teacher/subjects' => ['controller' => 'TeacherController@subjects', 'roles' => ['teacher']],
  '/teacher/subject/add' => ['controller' => 'TeacherController@addSubject', 'roles' => ['teacher']],
  '/teacher/subject/update' => ['controller' => 'TeacherController@updateSubject', 'roles' => ['teacher']],
  '/teacher/subject/{subject_id}/delete' => ['controller' => 'TeacherController@deleteSubject', 'roles' => ['teacher']],
  '/teacher/students/{class_id}' => ['controller' => 'TeacherController@students', 'roles' => ['teacher']],
  '/teacher/grades/{student_id}/{class_id}' => ['controller' => 'TeacherController@grades', 'roles' => ['teacher']],
  '/teacher/addGrade' => ['controller' => 'TeacherController@addGrade', 'roles' => ['teacher']],
  '/teacher/updateGrade' => ['controller' => 'TeacherController@updateGrade', 'roles' => ['teacher']],
  '/teacher/deleteGrade/{grade_id}' => ['controller' => 'TeacherController@deleteGrade', 'roles' => ['teacher']],
  '/teacher/class/{class_id}/add-student' => ['controller' => 'TeacherController@showAddStudent', 'roles' => ['teacher']],
  '/teacher/class/{class_id}/add-student-to-class' => ['controller' => 'TeacherController@addStudentToClass', 'roles' => ['teacher']],
  '/teacher/class/{class_id}/remove-student/{student_id}' => ['controller' => 'TeacherController@removeStudentFromClass', 'roles' => ['teacher']],
  '/teacher/student/{student_id}/edit' => ['controller' => 'TeacherController@editStudent', 'roles' => ['teacher']],
  '/teacher/student/{student_id}/update' => ['controller' => 'TeacherController@updateStudent', 'roles' => ['teacher']],
  '/teacher/class/{class_id}/subjects' => ['controller' => 'TeacherController@classSubjects', 'roles' => ['teacher']],

  // Common protected routes
  '/profile' => ['controller' => 'ProfileController@index', 'roles' => ['student', 'teacher']],
  '/profile/edit' => ['controller' => 'ProfileController@edit', 'roles' => ['student', 'teacher']],
  '/profile/update' => ['controller' => 'ProfileController@update', 'roles' => ['student', 'teacher']],
  '/logout' => ['controller' => 'AuthController@logout', 'roles' => ['student', 'teacher']],

  // Default route - redirects based on role
  '/' => ['controller' => 'DashboardController@index', 'roles' => ['student', 'teacher']],

  //users (skolotājs var veidot, editot un dzēst tikai savus skolniekus)
  '/users' => ['controller' => 'UsersController@index', 'roles' => ['teacher']],
  '/users/show' => ['controller' => 'UsersController@show', 'roles' => ['teacher']],
  '/users/edit' => ['controller' => 'UsersController@edit', 'roles' => ['teacher']],
  '/users/create' => ['controller' => 'UsersController@create', 'roles' => ['teacher']],
  '/users/store' => ['controller' => 'UsersController@store', 'roles' => ['teacher']],
  '/users/update' => ['controller' => 'UsersController@update', 'roles' => ['teacher']],
  '/users/destroy' => ['controller' => 'UsersController@destroy', 'roles' => ['teacher']],

  //home
  '/home' => ['controller' => 'StudentController@index', 'roles' => ['student']],
  '/subjects/assign' => ['controller' => 'SubjectsController@assign', 'roles' => ['teacher']],

  //reports
  '/reports/export' => ['controller' => 'ReportsController@export', 'roles' => ['teacher']],

  // Profile routes
  '/profile/update-info' => ['controller' => 'ProfileController@updateInfo', 'roles' => ['student', 'teacher']],
  '/profile/update-picture' => ['controller' => 'ProfileController@updatePicture', 'roles' => ['student', 'teacher']]
];