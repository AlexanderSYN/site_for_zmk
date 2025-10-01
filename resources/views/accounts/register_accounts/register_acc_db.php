<?php

require __DIR__ . '/../../../../vendor/autoload.php';

require '../../helpers/helpers.php';

$app = require_once __DIR__ . '/../../../../bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;


//-------------------
// helper
//-------------------
$msg = new messages();
$helper = new helpers();

$name = $_POST['name'];
$email = $_POST['email'];
$login = $_POST['login'];
$password = $_POST['password'];

$isBan = false;

//------------------------------
//to check for exists accounts
//------------------------------
$exists_email = DB::table('users')->where('email', $email)->exists();
$exists_name = DB::table('users')->where('login', $login)->exists();

if ($exists_email || $exists_name) {
    // Handle duplicate account - redirect with error message
    $msg->setMessage('error', 'the email or name already exists!');
    $helper->redirect("../register");
}

// Hash the password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

//-----------------------------
//set the data in the database
//-----------------------------
try {
    DB::table('users')->insert([
        'created_at' => now(),
        'updated_at' => now(),
        'name' => $name,
        'email' => $email,
        'login' => $login,
        'password' => $hashedPassword,
        'isBan' => $isBan,
        'isAdmin' => false
    ]);
    
    $msg->setMessage('success', 'account has been created successfully!');
    $helper->redirect("../register");
    exit;
    
} catch (Exception $e) {
    // Handle database errors
    $helper->redirect("../register");
    exit;
}

?>