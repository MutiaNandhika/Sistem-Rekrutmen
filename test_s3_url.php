<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Storage;
use App\Models\Upload;

try {
    $upload = Upload::create(['name' => 'test_db_entry_2', 'file_path' => 'uploads/test_file.jpg']);
    $url = Storage::disk('s3')->url($upload->file_path);
    echo "Generated URL: " . $url . "\n";
}
catch (\Exception $e) {
    echo "Failed: " . $e->getMessage() . "\n";
}
