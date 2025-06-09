<?php

$directory = __DIR__;
$keywords = ['poker', 'toto', '4d', 'slot', 'casino', 'warung99', 'karmatoto', 'republik', 'bandar', 'judi', 'jackpot'];
$extensions = ['php', 'html', 'blade.php'];

function scanFiles($dir, $keywords, $extensions)
{
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

    foreach ($rii as $file) {
        if ($file->isDir()) continue;

        $filename = $file->getPathname();

        foreach ($extensions as $ext) {
            if (endsWith($filename, $ext)) {
                $contents = file_get_contents($filename);
                foreach ($keywords as $keyword) {
                    if (stripos($contents, $keyword) !== false) {
                        echo "🚨 Ditemukan kata '$keyword' di file: $filename\n";
                    }
                }
                break;
            }
        }
    }
}

function endsWith($haystack, $needle)
{
    // Pakai fungsi bawaan jika ada
    if (function_exists('str_ends_with')) {
        return str_ends_with($haystack, $needle);
    }
    // Manual fallback
    return substr($haystack, -strlen($needle)) === $needle;
}

echo "Memindai folder: $directory\n\n";
scanFiles($directory, $keywords, $extensions);
echo "\n✅ Selesai.\n";
