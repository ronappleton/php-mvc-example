<?php

declare(strict_types=1);

namespace CarClub\Helpers;

/**
 * Class Request
 * @package CarClub\Helpers
 */
class Input
{
    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get(string $key, $default = null): mixed
    {
        return $this->arrayGet($key, $_GET, $default);
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function post(string $key, $default = null): mixed
    {
        return $this->arrayGet($key, $_POST, $default);
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function server(string $key, $default = null): mixed
    {
        return $this->arrayGet($key, $_SERVER, $default);
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function request(string $key, $default = null): mixed
    {
        return $this->arrayGet($key, $_REQUEST, $default);
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function files(string $key, $default = null): mixed
    {
        return $this->arrayGet($key, $_FILES, $default);
    }

    /**
     * @param string $key
     * @param array $data
     * @param null $default
     * @return mixed
     */
    private function arrayGet(string $key, array $data, $default = null): mixed
    {
        if (!is_string($key) || empty($key) || !count($data))
        {
            return $default;
        }

        if (str_contains($key, '.')) {
            $keys = explode('.', $key);

            foreach ($keys as $innerKey) {
                if (!array_key_exists($innerKey, $data)) {
                    return $default;
                }
                $data = $data[$innerKey];
            }

            return $data;
        }

        return array_key_exists($key, $data) ? $data[$key] : $default;
    }
}
