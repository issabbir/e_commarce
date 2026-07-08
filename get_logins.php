<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "### Super Admin Login ###\n";
$admin = App\Models\Admin::first();
if ($admin) {
    echo "Email: " . $admin->email . "\n";
    echo "Password: password\n";
    echo "URL: /superadmin/login\n";
} else {
    echo "No Super Admin found.\n";
}

echo "\n### Company/Vendor Login ###\n";
$users = App\Models\User::take(2)->get();
if ($users->count() > 0) {
    foreach($users as $u) {
        echo "Email: " . $u->email . "\n";
        echo "Password: password\n";
        echo "URL: /login\n\n";
    }
} else {
    echo "No Standard Users found.\n";
}
