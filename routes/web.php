<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return ["message" => "All API routes are on {server}/api"];
});

$router->get('/api', function () use ($router) {
    return ["message" => "Welcome to PrimePoll API"];
});

//****************Users Routes**************** */

$router->post('/api/register', 'SignupController@register');
$router->post('api/register/verify', 'VerifyUserController@verifyUser');

$router->post('api/login', 'SignInController@userLogin');

//Tino
$router->post('api/password/reset', 'PasswordController@resetpassword');

$router->put('api/password/change', 'ChangePasswordController@updatepassword');

//****************End Routes****************** */

//JuniCodefire****************Admin Custom Routes**************** */
$router->post('api/admin/login', 'SignInController@adminLogin');
$router->get('api/interest', 'ShowIntrestController@index');
//****************End Routes****************** */


$router->group(['middleware' => 'jwt.auth', 'prefix' => 'api'], function() use ($router)
{
    //Put you controller inside this block for authorization or create a new ground with new prefix
    //This is the Admin Private route(Work here with caution)
    //JuniCodefire************************************* */
    $router->get('admin/profile', 'AdminProfileController@adminData');
    $router->put('admin/password/change', 'AdminProfileController@updatePass');
    $router->post('admin/create/interest', 'CreateIntrestController@store');
    $router->get('admin/show/all/interest', 'CreateIntrestController@index');
    $router->put('admin/edit/interest/{intrest_id}', 'CreateIntrestController@update');
    $router->delete('admin/delete/interest/{intrest_id}', 'CreateIntrestController@destroy');
    //************************************** */

    //This is the Users Public route
    //************************************** */
    //Iro
    $router->put('/edit', 'EditProfileController@editprofile');
    $router->post('/upload', 'EditProfileController@uploadImage');
    //Tino
    $router->post('/polls/create', 'PollController@createpoll');
    //francise 
    $router->put('/complete/registration', 'CompleteRegistrationController@update');
    $router->get('/profile', 'ProfileController@profile');
    //************************************** */
});
