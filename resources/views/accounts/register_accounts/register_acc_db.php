<?php

require __DIR__ . '/../../../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../../../bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

// for date
date_default_timezone_set('UTC');

$created_at = date(DATE_RFC2822);
$updated_at = date(DATE_RFC2822);

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
    echo "NO";
}

// Hash the password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

//--------------------
//set the data in the database
//--------------------
try {
    DB::table('users')->insert([
        'created_at' => $created_at,
        'updated_at' => $updated_at,
        'name' => $name,
        'email' => $email,
        'login' => $login,
        'password' => $hashedPassword,
        'isBan' => $isBan,
        'isAdmin' => false
    ]);
    
    header("Location: ../register.php?success=1");
    exit;
    
} catch (Exception $e) {
    // Handle database errors
    header("Location: ../register.php?error=database");
    //echo $e;
    exit;
}

// try to changed the created_at and updated_at in the timestamps
?>