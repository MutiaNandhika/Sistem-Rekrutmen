<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

try {
    $file = UploadedFile::fake()->image('test_s3_upload.jpg');
    $path = $file->store('uploads', 's3');
    var_dump($path);
}
catch (\Exception $e) {
    echo "Upload failed: " . $e->getMessage() . "\n";
    while ($e = $e->getPrevious()) {
        echo "Previous: " . $e->getMessage() . "\n";
    }
}
