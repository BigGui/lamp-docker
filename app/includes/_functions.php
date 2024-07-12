<?php

/**
 * Get HTML script to load front-end assets defined in the manifest.json file for entry points given.
 *
 * @param array $entries - A list of JS files to load.
 * @return string
 */
function loadAssets(array $entries): string
{
    $html = '';

    if ($_ENV['ENV_TYPE'] === 'dev') {
        // Developement integration for vite with run dev
        $html = '<script type="module" src="' . $_ENV['VITE_DEV_URL'] . '@vite/client"></script>';
        $html .= implode(
            array_map(
                fn ($file) => '<script type="module" src="' . $_ENV['VITE_DEV_URL'] . $file . '"></script>',
                $entries
            )
        );
    } else if ($_ENV['ENV_TYPE'] === 'prod') {
        // Production integration for vite with run build
        if (!file_exists('.vite/manifest.json')) return $html;

        $assets = json_decode(file_get_contents('.vite/manifest.json'), true);

        foreach ($entries as $entry) {
            if (!array_key_exists($entry, $assets)) continue;

            $html .= '<script type="module" src="' . $assets[$entry]['file'] . '"></script>';
            if (isset($assets[$entry]['css']) && is_array($assets[$entry]['css'])) {
                $html .= implode(
                    array_map(
                        fn ($file) => '<link rel="stylesheet" href="' . $file . '">',
                        $assets[$entry]['css']
                    )
                );
            }
        }

        // Try this way to load assets from manifest.json
        // https://github.com/andrefelipe/vite-php-setup
    }

    return $html;
}
