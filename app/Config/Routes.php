<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
| AUTH ROUTES
*/
$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/auth', 'Auth::auth');
$routes->get('/logout', 'Auth::logout');
$routes->get('/unauthorized', 'Error::unauthorized');

/*
| DASHBOARD (ALL LOGGED IN USERS)
*/
$routes->get('/dashboard', 'Dashboard::index');


/*
| ADMIN ONLY ROUTES
| (users + logs + full system control)
*/
$routes->group('', ['filter' => 'rolefilter:admin,doctor'], function ($routes) {

    // Users / Accounts
    $routes->get('/users', 'Users::index');
    $routes->post('users/save', 'Users::save');
    $routes->get('users/edit/(:segment)', 'Users::edit/$1');
    $routes->post('users/update', 'Users::update');
    $routes->delete('users/delete/(:num)', 'Users::delete/$1');
    $routes->post('users/fetchRecords', 'Users::fetchRecords');

    // Logs
    $routes->get('/log', 'Logs::log');
});

/*
| CLINIC MODULE (ADMIN + DOCTOR + NURSE)
*/
$routes->group('', ['filter' => 'rolefilter:admin,doctor,nurse'], function ($routes) {

    // Patients
    $routes->get('/patient', 'Patient::index');
    $routes->post('patient/save', 'Patient::save');
    $routes->get('patient/edit/(:segment)', 'Patient::edit/$1');
    $routes->post('patient/update', 'Patient::update');
    $routes->delete('patient/delete/(:num)', 'Patient::delete/$1');
    $routes->post('patient/fetchRecords', 'Patient::fetchRecords');
    $routes->get('patient/view/(:num)', 'Patient::view/$1');
    $routes->get('patient/print/(:num)', 'Patient::print/$1');

    // Guardians / Parents
    $routes->get('/guardian', 'Guardian::index');
    $routes->post('guardian/save', 'Guardian::save');
    $routes->get('guardian/edit/(:segment)', 'Guardian::edit/$1');
    $routes->post('guardian/update', 'Guardian::update');
    $routes->delete('guardian/delete/(:num)', 'Guardian::delete/$1');
    $routes->post('guardian/fetchRecords', 'Guardian::fetchRecords');

    // Appointments
    $routes->get('/appointment', 'Appointment::index');
    $routes->post('appointment/save', 'Appointment::save');
    $routes->get('appointment/edit/(:segment)', 'Appointment::edit/$1');
    $routes->post('appointment/update', 'Appointment::update');
    $routes->delete('appointment/delete/(:num)', 'Appointment::delete/$1');
    $routes->post('appointment/fetchRecords', 'Appointment::fetchRecords');
    $routes->post('appointment/updateStatus',  'Appointment::updateStatus');
    $routes->get('appointment/calendarData',   'Appointment::calendarData');

    // Medical Records
    $routes->get('/medical_record',                       'MedicalRecord::index');
    $routes->post('medical_record/save',                  'MedicalRecord::save');
    $routes->get('medical_record/edit/(:num)',            'MedicalRecord::edit/$1');
    $routes->post('medical_record/update',                'MedicalRecord::update');
    $routes->delete('medical_record/delete/(:num)',       'MedicalRecord::delete/$1');
    $routes->post('medical_record/fetchRecords',          'MedicalRecord::fetchRecords');
    $routes->get('medical_record/view/(:num)',            'MedicalRecord::view/$1');
    $routes->get('medical_record/print/(:num)',           'MedicalRecord::print/$1');


    //Filters
    $routes->get('doctors', 'Users::doctors', ['filter' => 'rolefilter:admin']);
    $routes->get('nurses', 'Users::nurses', ['filter' => 'rolefilter:admin']);
});

/*
| MEDICINE & EQUIPMENT
| (Admin + Doctor only - optional restriction)
*/
$routes->group('', ['filter' => 'rolefilter:admin,doctor,nurse'], function ($routes) {

    // Medicines
    $routes->get('/medicine', 'Medicine::index');
    $routes->post('medicine/save', 'Medicine::save');
    $routes->get('medicine/edit/(:segment)', 'Medicine::edit/$1');
    $routes->post('medicine/update', 'Medicine::update');
    $routes->delete('medicine/delete/(:num)', 'Medicine::delete/$1');
    $routes->post('medicine/fetchRecords', 'Medicine::fetchRecords');
    $routes->post('medicine/adjustStock', 'Medicine::adjustStock');

    // Equipment
    $routes->get('/equipment', 'Equipment::index');
    $routes->post('equipment/save', 'Equipment::save');
    $routes->get('equipment/edit/(:segment)', 'Equipment::edit/$1');
    $routes->post('equipment/update', 'Equipment::update');
    $routes->delete('equipment/delete/(:num)', 'Equipment::delete/$1');
    $routes->post('equipment/fetchRecords', 'Equipment::fetchRecords');
});
