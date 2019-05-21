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
$router->post('api/user/login', 'SignInController@userLogin');


// This controller completes user registration
$router->put('api/complete', 'CompleteRegistrationController@update');

//Tino
$router->post('api/password/reset', 'PasswordController@resetpassword');
$router->put('api/password/change', 'ChangePasswordController@updatepassword');

//****************End Routes****************** */

//JuniCodefire****************Admin Custom Routes**************** */
$router->post('api/admin/login', 'SignInController@adminLogin');
//****************End Routes****************** */


$router->group(['middleware' => 'jwt.auth', 'prefix' => 'api'], function() use ($router)
{
    //Put you controller inside this block for authorization or create a new ground with new prefix
    //This is the Admin Private route(Work here with caution)
    //JuniCodefire************************************* */
    $router->get('admin/profile', 'AdminProfileController@adminData');
    $router->put('admin/password/change', 'AdminProfileController@updatePass');
    $router->post('admin/create/interest', 'AdminInterestController@store');
    $router->get('admin/show/all/interest', 'AdminInterestController@index');
    $router->put('admin/edit/interest/{interest_id}', 'AdminInterestController@update');
    $router->delete('admin/delete/interest/{interest_id}', 'AdminInterestController@destroy');
    //************************************** */

    //for admin******************************Jeremiahiro******************************start/
    $router->get('api/admin/users', 'AdminController@users');
    $router->get('api/admin/polls', 'AdminController@polls');
    $router->get('api/admin/trending', 'AdminController@trending');
    //for admin******************************Jeremiahiro******************************end here/



    //This is the Users Public route
    //************************************** */
   
    //for users******************************Jeremiahiro******************************start/
    $router->put('/edit', 'UserProfileController@editprofile');
    $router->post('/upload', 'UserProfileController@uploadImage');

            // show all existing interest as created by admin
            $router->get('/interest', 'UserInterestController@showAllInterest');

            // show all existing interest as created by admin and their polls as created by users
            $router->get('/{interest_id}/poll', 'UserInterestController@showAllIntrerestPoll');
            
            // show all interest selected by a user
            $router->get('/user/interest', 'UserInterestController@index');

            // show a single interest selected interest
            $router->get('/user/interest/{id}', 'UserInterestController@show');

            // a user can deselect an interest
            $router->delete('/user/interest/{id}', 'UserInterestController@destroy');


                    // a user can create poll under an interest
                    $router->post('/{userinterest_id}/poll', 'UserPollController@create');

                    // show all poll a user has created, their options and total vote count
                    $router->get('/poll', 'UserPollController@index');
                
                    // show one poll a user has created, their options and total vote count
                    $router->get('/poll/{id}', 'UserPollController@show');

                    // a user can edit/update a poll he created
                    $router->put('/poll/{id}', 'UserPollController@update');

                    // a user can delete a poll he created
                    $router->delete('/poll/{id}', 'UserPollController@destroy');
                    


                            // show single options of a poll and their vote count
                            $router->get('/{option_id}/option', 'UserOptionsController@show');

                            // edit single option of a poll
                            $router->put('/{option_id}/option', 'UserOptionsController@update');

                            // delete single option of a poll
                            $router->delete('/{option_id}/option', 'UserOptionsController@destroy');

                                    // a user can vote
                                     $router->post('/{poll_id}/vote', 'UserVotesController@create');
 
    //for users******************************Jeremiahiro******************************end here/


    //Tino


    //francise 
    $router->put('/complete/registration', 'UserCompleteRegistrationController@update');
    $router->get('/profile', 'UserProfileController@index');
    //************************************** */
});