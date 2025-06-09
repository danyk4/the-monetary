<?php

namespace App;

use App\Contracts\SessionInterface;
use App\DataObjects\SessionConfig;
use App\Exception\SessionException;

class Session implements SessionInterface
{
    public function __construct(private readonly SessionConfig $options)
    {
        //
    }

    public function start(): void
    {
        if ($this->isActive()) {
            throw new SessionException('Session already started.');
        }

        if (headers_sent($fileName, $line)) {
            throw new SessionException('Headers already sent by ' . $fileName . ':' . $line);
        }

        session_set_cookie_params(
            [
                'secure' => $this->options->secure,
                'httponly' => $this->options->httponly,
                'samesite' => $this->options->samesite->value,
            ],
        );

        if (! empty($this->options->name)) {
            session_name($this->options->name);
        }

        if (! session_start()) {
            throw new SessionException('Failed to start session.');
        }
    }

    public function save(): void
    {
        session_write_close();
    }

    public function isActive(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function get(string $key, $default = null): mixed
    {
        return $this->has($key) ? $_SESSION[$key] : $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function regenerate(): bool
    {
        return session_regenerate_id();
    }

    public function put(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
