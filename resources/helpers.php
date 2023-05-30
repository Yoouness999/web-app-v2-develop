<?php
/**
 * Apply Shortcodes here
 */

use Blok\Utils\Str;

require_once __DIR__ . '/shortcodes.php';

/**
 * Converting attribute name
 *
 * @param $key
 * @return mixed
 */
if (!function_exists('\__')) {
    /**
     * @param $key
     * @param string $mGroup
     * @param array $params
     * @param null $locale
     * @return mixed
     * @internal param $value
     * @internal param string $context
     */
    function lg($key, $mGroup = '', $params = [], $locale = null)
    {
        return Label::get($key, $mGroup, $params, $locale);
    }
}

if (!function_exists('\lg')) {
    /**
     * @param $key
     * @param string $mGroup
     * @param array $params
     * @param null $locale
     * @return mixed
     * @internal param $value
     * @internal param string $context
     */
    function lg($key, $mGroup = '', $params = [], $locale = null)
    {
        return Label::get($key, $mGroup, $params, $locale);
    }
}

/**
 * Get CDN URL of boxify project
 *
 * @see _config.php
 */
if (!function_exists('\cdn_url')) {
    function cdn_url($path)
    {
        return CDN_URL . Str::mustBeginWith('/', $path);
    }
}

if (!function_exists('\shortcode')) {
    function shortcode($string, $data = [], $params = ['nl2br' => false, 'delimiters' => ['{', '}']])
    {

        \Blok\Utils\Arr::mergeWithDefaultParams($params);

        if ($params['nl2br']) {
            $string = nl2br($string);
        }

        $data = array_dot($data);

        $string = Utils::smrtr($string, $data, $params['delimiters']);

        $string = \Shortcode::compile($string);

        return $string;
    }
}

if (!function_exists('\mix')) {
    // mix('css/app.css')
    // mix('js/app.js')
    function mix($path, $manifest = false, $shouldHotReload = false)
    {
        if (!$manifest) static $manifest;
        if (!$shouldHotReload) static $shouldHotReload;
        if (!$manifest) {
            $manifestPath = public_path('mix-manifest.json');
            $shouldHotReload = file_exists(public_path('hot'));
            if (!file_exists($manifestPath)) {
                throw new Exception('The Laravel Mix manifest file does not exist. ' . 'Please run "npm run webpack" and try again.');
            }
            $manifest = json_decode(file_get_contents($manifestPath), true);
        }
        if (!starts_with($path, '/')) $path = "/{$path}";
        if (!array_key_exists($path, $manifest)) {
            return $shouldHotReload ? "http://localhost:8080{$path}" : url($path);
            //throw new Exception("Unknown Laravel Mix file path: {$path}. Please check your requested " . "webpack.mix.js output path, and try again.");
        }

        return $shouldHotReload ? "http://localhost:8080{$manifest[$path]}" : url($manifest[$path]);
    }
}

if (!function_exists('\cp_html_table')) {

    function cp_html_table($data, $firstRowIsKey = true, $output = false)
    {
        $html = '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
';
        $html .=  "<div class='table-responsive'><table class='table table-bordered'>";

        if ($firstRowIsKey) {
            $html .= "<tr>";

            if (isset($data[0])) {
                foreach ((array) $data[0] as $key => $value) {
                    $html .= "<td>".@$key."</td>";
                }
            }

            $html .= "</tr>";
        }

        foreach ($data as $row) {
            $html .= "<tr>";
            foreach ((array)$row as $key => $value) {
                if (is_array($value)) {
                    $html .= "<td>".var_dump($value)."</td>";

                } else {
                    $html .= "<td>".@$value."</td>";
                }
            }
            $html .= "</tr>";
        }

        $html .= "</table></div>";

        if ($output) {
            echo $html;
        }

        return $html;
    }
}
