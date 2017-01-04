<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/account', 'AccountController@index');
Route::get('/account/logout', 'AccountController@logout');
Route::post('/account/upload_profile', 'AccountController@upload_profile');
Route::post('/account/remove_profile_pic', 'AccountController@remove_profile_pic');
Route::any('/userprofiles/{user_id}','UserController@user_profile');
Route::any('/userprofiles/{user_id}/{slug}','UserController@user_profile');
Route::get('/my_tasks','UserController@my_tasks');
Route::get('/my_contributions','UserController@my_contribution');
Route::post('/account/withdraw','AccountController@withdraw');
Route::post('/account/paypal_email_check','AccountController@paypal_email_check');
Route::post('/account/update-creditcard','AccountController@update_creditcard');
Route::any('/notification/success','NotificationController@success_payment');
Route::post('/account/update_personal_info','AccountController@update_personal_info');
Route::any('/notification/error','NotificationController@error_payment');
Route::any('/notification/ipn_payment','NotificationController@ipn_payment');
Route::any('/notification/ipn_donation','NotificationController@ipn_donation');
Route::get('/activities','HomeController@global_activities');
Route::get('/get_unit_site_activity_paginate','HomeController@get_unit_site_activity_paginate');
Route::get('/get_site_activity_paginate','HomeController@get_site_activity_paginate');
Route::get('/add_to_watchlist','HomeController@add_to_watchlist');
Route::get('/remove_from_watchlist','HomeController@remove_from_watchlist');
Route::get('/my_watchlist','HomeController@my_watchlist');
Route::any('/site_admin','HomeController@site_admin');
Route::any('/skills/get_skill_paginate','HomeController@get_skill_paginate');
Route::any('/category/get_category_paginate','HomeController@get_category_paginate');
Route::any('/area_of_interest/get_area_of_interest_paginate','HomeController@get_area_of_interest_paginate');

Route::any('job_skills/get_skills','HomeController@get_skills');
Route::any('job_skills/get_next_level_skills','HomeController@get_next_level_skills');
Route::get('job_skills/approve_skill','HomeController@approveSkill');
Route::get('job_skills/discard_skill_changes','HomeController@discard_skill_change');
Route::get('job_skills/browse_skills','HomeController@browse_skills');
Route::any('/job_skills/add','HomeController@skill_add');
Route::any('/job_skills/delete','HomeController@skill_delete');
Route::any('/job_skills/edit','HomeController@skill_edit');

Route::any('unit_category/get_categories','HomeController@get_categories');
Route::any('unit_categories/get_next_level_categories','HomeController@get_next_level_categories');
Route::any('unit_category/add','HomeController@category_add');
Route::any('unit_category/edit','HomeController@category_edit');
Route::any('unit_category/delete','HomeController@category_delete');
Route::get('unit_category/approve_category','HomeController@approve_category');
Route::get('unit_category/discard_category_changes','HomeController@discard_category_changes');
Route::get('unit_category/browse_categories','HomeController@browse_categories');


Route::any('area_of_interest/get_area_of_interest','HomeController@get_area_of_interest');
Route::any('area_of_interest/get_next_level_area_of_interest','HomeController@get_next_level_area_of_interest');
Route::any('area_of_interest/add','HomeController@area_of_interest_add');
Route::any('area_of_interest/edit','HomeController@area_of_interest_edit');
Route::any('area_of_interest/delete','HomeController@area_of_interest_delete');
Route::get('area_of_interest/approve_area_of_interest','HomeController@approve_area_of_interest');
Route::get('area_of_interest/discard_area_of_interest_changes','HomeController@discard_area_of_interest_changes');
Route::get('area_of_interest/browse_area_of_interest','HomeController@browse_area_of_interest');

Route::any('/category/add','HomeController@category_add');

Route::any('/area_of_interest/add','HomeController@area_of_interest_add');
//Route::any('/job_skills/{skill_id}/edit','HomeController@skill_edit');
Route::any('/category/{category_id}/edit','HomeController@category_edit');
Route::any('/area_of_interest/{area_id}/edit','HomeController@area_of_interest_edit');
//Route::get('/job_skills/{skill_id}','HomeController@skill_view');
Route::get('/category/{category_id}','HomeController@category_view');
Route::any('/area_of_interest/{area_id}','HomeController@area_of_interest_view');

Route::auth();


// get all request except login,register, forgot password, reset password and logout method
/*Route::any('{all}', function($all){

    $all = explode("/",$all);
    $method_name = $all[0];
    unset($all[0]);
    $param = array_values($all);

    return App::call('\App\Http\Controllers\UnitsController@' . $method_name, $param);

})->where('all', '(.*)');*/

Route::post('users/{user_id}/save_page', 'UserWikiController@save_pagedata')->name("user_wiki_save_page")->middleware('auth');
Route::get('users/{slug}/{user_id}/wiki', 'UserWikiController@home')->name("user_wiki_home");
Route::get('users/{slug}/{user_id}/wiki/recent_changes', 'UserWikiController@recent_changes')->name("user_wiki_recent_changes");
Route::get('users/{slug}/{user_id}/wiki/pages', 'UserWikiController@pagelist')->name("user_wiki_page_list");
Route::get('users/{slug}/{user_id}/wiki/history/{page_id}', 'UserWikiController@page_history')->name("user_wiki_history");
Route::get('users/{slug}/{user_id}/wiki/diff/{rev1?}/{rev2?}', 'UserWikiController@page_diff')->name("user_wiki_rev_diff");
Route::get('users/{slug}/{user_id}/wiki/new_page/{page_id?}', 'UserWikiController@page_create')->name("user_wiki_newpage")->middleware('auth');
Route::get('users/{slug}/{user_id}/wiki/edit_page/{page_id}', 'UserWikiController@page_create')->name("user_wiki_editpage")->middleware('auth');
Route::get('users/{slug}/{page_id}/wiki/{page_slug}', 'UserWikiController@view')->name("user_wiki_view");


// unit controller route
Route::any('units/add', 'UnitsController@create');
Route::get('units/{unitid}/revison', 'UnitsController@revison')->name('unit_revison');
Route::get('units/{unitid}/diff/{rev1}/{rev2}', 'UnitsController@diff')->name('unit_revison_cmp');
Route::get('unit/set_featured_unit','UnitsController@set_featured_unit');
Route::any('units/{unitid}/edit', 'UnitsController@edit');
Route::post('units/get_state', 'UnitsController@get_state');
Route::post('units/get_city', 'UnitsController@get_city');
Route::post('units/get_featured_unit','UnitsController@get_featured_unit');
Route::get('units/delete_unit', 'UnitsController@delete_unit');
Route::get('units/available_bid/{unit_id}','UnitsController@available_bids');
Route::any('units/{unitid}/{slug}', 'UnitsController@view');
Route::get('units/get_units_paginate', 'UnitsController@get_units_paginate');


// objective controller route
Route::any('objectives/add','ObjectivesController@create');
Route::get('objectives/{objectiveid}/revison', 'ObjectivesController@revison')->name('objectives_revison');
Route::get('objectives/{objectiveid}/diff/{rev1}/{rev2}', 'ObjectivesController@diff')->name('objectives_revison_cmp');

Route::any('objectives/{unitid}/add', 'ObjectivesController@create');
Route::any('objectives/{objectiveid}/edit', 'ObjectivesController@edit');
Route::post('objectives/importance', 'ObjectivesController@add_importance');
Route::get('objectives/delete_objective', 'ObjectivesController@delete_objective');
Route::get('objectives/{unitid}/lists', 'ObjectivesController@lists');
Route::any('objectives/{objectiveid}/{slug}', 'ObjectivesController@view');
Route::get('objectives/get_objectives_paginate', 'ObjectivesController@get_objectives_paginate');

// chat controller route
Route::get('chat', 'ChatController@index');
Route::post('chat/create_room', 'ChatController@create_room');
Route::post('chat/sendmsg', 'ChatController@sendmsg');
Route::post('chat/loaduser/{flag?}', 'ChatController@loaduser');
Route::post('chat/loadmsg', 'ChatController@loadmsg');
Route::post('chat/online', 'ChatController@online');
Route::get('chat/{roomid}', 'ChatController@chatroom');
// message controller route
Route::get('inbox', 'MessageController@inbox');
Route::get('message/sent', 'MessageController@sent');
Route::get('message/view/{message_id}', 'MessageController@view');
Route::any('message/send/{user_id?}', 'MessageController@send');
// wiki controller route
Route::get('wiki/home/{unit_id}/{slug}', 'WikiController@home');
Route::get('wiki/menu/{unit_id}/{slug}', 'WikiController@menu');
Route::get('wiki/all_pages/{unit_id}/{slug}', 'WikiController@pages');
//Route::get('wiki/view_history/{unit_id}/{slug}', 'WikiController@changes');
Route::any('wiki/edit/{unit_id}/{slug}/{wiki_page_id?}', 'WikiController@edit');
Route::any('wiki/edit_revision/{unit_id}/{slug}/{wiki_page_rev_id?}', 'WikiController@edit_revision');
Route::get('wiki/diff/{unit_id}/{revision_id}/{slug}', 'WikiController@difference');
Route::get('wiki/diff/{unit_id}/{revision_id}/{compare_id}/{slug}', 'WikiController@difference_selected');
Route::get('wiki/revision_view/{unit_id}/{revision_id}/{slug}', 'WikiController@revision_view');
Route::get('wiki/recent_changes/{unit_id}/{slug}', 'WikiController@changes');
Route::get('wiki/history/{unit_id}/{wiki_page_id}/{slug}', 'WikiController@history_single_page');
Route::get('wiki/{unit_id}/{wiki_page_id}/{slug}', 'WikiController@view');
Route::any('wiki/history/{unit_id?}/{slug}', 'WikiController@history');

// chat controller route
//Route::get('forum/{unit_id}/{section_id}', 'ForumController@view');
Route::get('forum', 'ForumController@index');
Route::post('forum/submit', 'ForumController@submit');
Route::post('forum/submitauto', 'ForumController@submitauto');
Route::post('forum/loadObjectiveComment', 'ForumController@loadObjectiveComment');
Route::post('forum/postSubmit', 'ForumController@postSubmit');
Route::post('forum/postLoad', 'ForumController@postLoad');
Route::post('forum/postUpDown', 'ForumController@postUpDown');
Route::post('forum/ideapoint', 'ForumController@ideapoint');
Route::post('forum/post_ideapoint', 'ForumController@post_ideapoint');
Route::post('forum/topicUpDown', 'ForumController@topicUpDown');
Route::get('forum/create/{unit_id}/{section_id}', 'ForumController@create');
Route::get('forum/post/{unit_id}/{slug}', 'ForumController@post');
Route::get('forum/{unit_id}', 'ForumController@index');
Route::get('forum/{unit_id}/{section_id}', 'ForumController@view');


// tasks controller route
Route::any('tasks/add', 'TasksController@create');
Route::get('tasks/{taskid}/revison', 'TasksController@revison')->name('tasks_revison');
Route::get('tasks/{taskid}/diff/{rev1}/{rev2}', 'TasksController@diff')->name('tasks_revison_cmp');
Route::any('tasks/{unitid}/{objectiveid}/add', 'TasksController@create');
Route::post('tasks/get_objective', 'TasksController@get_objective');
Route::post('tasks/get_tasks', 'TasksController@get_tasks');
Route::get('tasks/get_biding_details','TasksController@get_biding_details');
Route::get('tasks/check_assigned_task', 'TasksController@check_assigned_task');
Route::get('tasks/accept_offer', 'TasksController@accept_offer');
Route::get('tasks/reject_offer', 'TasksController@reject_offer');
Route::any('tasks/remove_task_document', 'TasksController@remove_task_documents');
Route::any('tasks/submit_for_approval', 'TasksController@submit_for_approval');
Route::get('tasks/delete_task', 'TasksController@delete_task');
Route::get('tasks/assign', 'TasksController@assign_task');
Route::any('tasks/cancel_task/{task_id}','TasksController@cancel_task');
Route::any('tasks/complete_task/{task_id}','TasksController@complete_task');
Route::any('tasks/re_assign/{task_id}','TasksController@re_assign');
Route::post('tasks/mark_task_complete/{task_id}','TasksController@mark_as_complete');
Route::any('tasks/{taskid}/edit', 'TasksController@edit');
Route::any('tasks/bid_now/{task_id}','TasksController@bid_now');
Route::get('tasks/{unitid}/lists', 'TasksController@lists');
Route::any('tasks/{taskid}/{slug}', 'TasksController@view');
Route::get('tasks/get_tasks_paginate', 'TasksController@get_tasks_paginate');


Route::get('funds/donate/unit/{unit_id}','FundsController@donate_to_unit_objective_task');
Route::get('funds/donate/objective/{objective_id}','FundsController@donate_to_unit_objective_task');
Route::get('funds/donate/task/{task_id}','FundsController@donate_to_unit_objective_task');
Route::get('funds/donate/user/{user_id}','FundsController@donate_to_unit_objective_task');
Route::get('funds/get-card-name','FundsController@get_card_name');
Route::post('funds/donate-amount','FundsController@donate_amount');
Route::get('funds/success','FundsController@success');
Route::get('funds/cancel','FundsController@cancel');

Route::get('issues/remove_issue_document','IssuesController@remove_document');
Route::get('issues/{taskid}/revison', 'IssuesController@revison')->name('issues_revison');
Route::get('issues/{taskid}/diff/{rev1}/{rev2}', 'IssuesController@diff')->name('issues_revison_cmp');
Route::get('/issues/get_issues_paginate','IssuesController@get_issues_paginate');
Route::any('/issues/add','IssuesController@add');
Route::post('issues/importance','IssuesController@add_importance');
Route::post('issues/sort_issue','IssuesController@sort_issues');
Route::any('issues/{unit_id}/add','IssuesController@create');
Route::any('issues/{unit_id}/lists','IssuesController@lists');
Route::any('issues/{issue_id}/view','IssuesController@view');
Route::any('issues/{issue_id}/edit','IssuesController@edit');
Route::any('issues/{unit_id}/{objective_id}/add','IssuesController@create');
Route::any('issues/{unit_id}/{objective_id}/{task_id}/add','IssuesController@create');


Route::post('alerts/set_alert','AlertsController@set_alert');

Route::resource('/issues','IssuesController');
Route::resource('/objectives','ObjectivesController');
Route::resource('/tasks','TasksController');
Route::resource('/units','UnitsController');
Route::resource('/user','UserController');
Route::resource('/funds','FundsController');
Route::resource('/alerts','AlertsController');




