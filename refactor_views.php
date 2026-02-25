<?php
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('resources/views'));
$count = 0;
foreach ($files as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
        $content = file_get_contents($file->getPathname());
        $newContent = preg_replace("/asset\(\s*['\"]storage\/['\"]\s*\.\s*([^\)]+)\)/", "Storage::disk('s3')->url($1)", $content);
        if ($content !== $newContent) {
            file_put_contents($file->getPathname(), $newContent);
            echo "Modified " . $file->getPathname() . "\n";
            $count++;
        }
    }
}
echo "Total templates modified: $count\n";
