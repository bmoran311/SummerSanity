<?php


error_reporting(E_ERROR | E_PARSE);

define('LARAVEL_START', microtime(true));

require_once __DIR__ . '/../autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';

class VsCodeLaravel extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        config([
            'logging.channels.null' => [
                'driver' => 'monolog',
                'handler' => \Monolog\Handler\NullHandler::class,
            ],
            'logging.default' => 'null',
        ]);
    }
}

function vsCodeToRelativePath($path)
{
    if (!str_contains($path, base_path())) {
        return (string) $path;
    }

    return ltrim(str_replace(base_path(), '', realpath($path)), DIRECTORY_SEPARATOR);
}

$app->register(new VsCodeLaravel($app));
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo '__VSCODE_LARAVEL_START_OUTPUT__';

$local = collect(glob(config_path("/*.php")))
  ->merge(glob(config_path("**/*.php")))
  ->map(fn ($path) => [
      (string) \Illuminate\Support\Str::of($path)
        ->replace([config_path('/'), ".php"], "")
        ->replace(DIRECTORY_SEPARATOR, "."),
      $path
    ]);

$vendor = collect(glob(base_path("vendor/**/**/config/*.php")))->map(fn (
  $path
) => [
    (string) \Illuminate\Support\Str::of($path)
      ->afterLast(DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR)
      ->replace(".php", "")
      ->replace(DIRECTORY_SEPARATOR, "."),
    $path
  ]);

$configPaths = $local
  ->merge($vendor)
  ->groupBy(0)
  ->map(fn ($items)=>$items->pluck(1));

$cachedContents = [];
$cachedParsed = [];

function vsCodeGetConfigValue($value, $key, $configPaths) {
    $parts = explode(".", $key);
    $toFind = $key;
    $found = null;

    while (count($parts) > 0) {
      $toFind = implode(".", $parts);

      if ($configPaths->has($toFind)) {
        $found = $toFind;
        break;
      }

      array_pop($parts);
    }

    if ($found === null) {
      return null;
    }

    $file = null;
    $line = null;

    if ($found === $key) {
      $file = $configPaths->get($found)[0];
    } else {
      foreach ($configPaths->get($found) as $path) {
        $cachedContents[$path] ??= file_get_contents($path);
        $cachedParsed[$path] ??= token_get_all($cachedContents[$path]);

        $keysToFind = \Illuminate\Support\Str::of($key)
          ->replaceFirst($found, "")
          ->ltrim(".")
          ->explode(".");

        if (is_numeric($keysToFind->last())) {
          $index = $keysToFind->pop();

          if ($index !== "0") {
            return null;
          }

          $key = collect(explode(".", $key));
          $key->pop();
          $key = $key->implode(".");
          $value = "array(...)";
        }

        $nextKey = $keysToFind->shift();
        $expectedDepth = 1;

        $depth = 0;

        foreach ($cachedParsed[$path] as $token) {
          if ($token === "[") {
            $depth++;
          }

          if ($token === "]") {
            $depth--;
          }

          if (!is_array($token)) {
            continue;
          }

          $str = trim($token[1], '"\'');

          if (
            $str === $nextKey &&
            $depth === $expectedDepth &&
            $token[0] === T_CONSTANT_ENCAPSED_STRING
          ) {
            $nextKey = $keysToFind->shift();
            $expectedDepth++;

            if ($nextKey === null) {
              $file = $path;
              $line = $token[2];
              break;
            }
          }
        }

        if ($file) {
          break;
        }
      }
    }

    return [
      "name" => $key,
      "value" => $value,
      "file" => $file === null ? null : str_replace(base_path(DIRECTORY_SEPARATOR), '', $file),
      "line" => $line
    ];
}

function vsCodeUnpackDottedKey($value, $key) {
  $arr = [$key => $value];
  $parts = explode('.', $key);
  array_pop($parts);

  while (count($parts)) {
    $arr[implode('.', $parts)] = 'array(...)';
    array_pop($parts);
  }

  return $arr;
}

echo collect(\Illuminate\Support\Arr::dot(config()->all()))
  ->mapWithKeys(fn($value, $key) => vsCodeUnpackDottedKey($value, $key))
  ->map(fn ($value, $key) => vsCodeGetConfigValue($value, $key, $configPaths))
  ->filter()
  ->values()
  ->toJson();
;
echo '__VSCODE_LARAVEL_END_OUTPUT__';

exit(0);