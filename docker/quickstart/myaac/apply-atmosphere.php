<?php

declare(strict_types=1);

// Build-time only: scope the stylesheet to the two supported public templates.
$root = '/var/www/html';
$templates = [
    'templates/tibiacom/index.php',
    'templates/kathrine/template.php',
];
$marker = 'data-eldra-atmosphere="1"';
$link = '<link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/eldra-atmosphere.css?v=1" />';

foreach ($templates as $relative) {
    $path = $root . '/' . $relative;
    $source = file_get_contents($path);
    if ($source === false) {
        throw new RuntimeException('Cannot read public template: ' . $relative);
    }
    if (str_contains($source, $marker)) {
        continue;
    }
    if (preg_match('/<body\b/i', $source) !== 1 || substr_count($source, '</head>') !== 1) {
        throw new RuntimeException('Unsupported template structure: ' . $relative);
    }
    $patched = preg_replace('/<body\b/i', '<body ' . $marker, $source, 1, $bodyCount);
    if ($patched === null || $bodyCount !== 1) {
        throw new RuntimeException('Cannot scope public template: ' . $relative);
    }
    $patched = str_replace('</head>', $link . "\n</head>", $patched);
    if (file_put_contents($path, $patched) === false) {
        throw new RuntimeException('Cannot update public template: ' . $relative);
    }
}
