<?php 

session_start();

require_once("vendor/autoload.php");

use \Slin\Slin;

use \Hcode\Page;

use \Hcode\PageAdmin;

use\Hcode\Model\User;

$app = new \Slim\Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index");

});

$app->get('/admin', function() {
    
    User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("index");

});

$app->get('/admin/login', function() {

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");

});

$app->post('/admin/login', function(){

	user::login($_POST["login"], $_POST["password"]);

	header("Location: /admin");
	exit;
});

$app->get('/admin/logout', function() {

	User::logout();

	header("Location: /admin/login");
	exit;
});

$app->get("/admin/users", function()){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users");
}

$app->get("/admin/users/create", function()){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-create");
}

$app->get("/admin/users/:iduser", function($isuder)){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-update");
}


$app->run();

?>