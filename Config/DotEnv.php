<?php declare(strict_types=1);

class DotEnv {
    protected $path;

    public function __construct(string $path) {
        if (!file_exists($path)) {
            // throw exception
            return 'file not found';
        }
        $this->path = $path;
    }

    public function load() : void {
        if (!is_readable($this->path)) {
            // throw exception
        }

        $lines = file($this->path , FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach($lines as $line) {
            if (strpos(trim($line), '#') === 0 ) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }

}