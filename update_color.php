<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\App\Models\SiteSetting::updateOrCreate(['key' => 'primary_color'], ['value' => '#4f46e5']);
echo "Primary color updated to #4f46e5\n";
