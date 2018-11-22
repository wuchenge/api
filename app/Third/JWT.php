<?php

/**
 * @Author: wuchenge
 * @Date: 2018-11-22 15:57:59
 */

namespace App\Third;

class JWT
{
    /**
     * create JWT
     *
     * @param  array    $payload    payload
     * @param  string   $key        secret key
     * @param  string   $alg        algorithm
     * @return string
     */
    public static function encode(array $payload, string $key, string $alg = 'SHA256')
    {
        $key = md5($key);
        $jwt = self::urlsafeB64Encode(json_encode(['typ' => 'JWT', 'alg' => $alg])) . '.' . self::urlsafeB64Encode(json_encode($payload));
        return $jwt . '.' . self::signature($jwt, $key, $alg);
    }

    /**
     * validate and decode JWT
     *
     * @param  string   $jwt    JWT
     * @param  string   $key    secret key
     * @return payload / false
     */
    public static function decode(string $jwt, string $key)
    {
        $tokens = explode('.', $jwt);
        $key    = md5($key);

        if (count($tokens) != 3) {
            return false;
        }

        list($header64, $payload64, $sign) = $tokens;

        $header = json_decode(self::urlsafeB64Decode($header64), JSON_OBJECT_AS_ARRAY);
        if (empty($header['alg'])) {
            return false;
        }

        if (self::signature($header64 . '.' . $payload64, $key, $header['alg']) !== $sign) {
            return false;
        }

        $payload = json_decode(self::urlsafeB64Decode($payload64), JSON_OBJECT_AS_ARRAY);

        $time = $_SERVER['REQUEST_TIME'];
        if (isset($payload['iat']) && $payload['iat'] > $time) {
            return false;
        }

        if (isset($payload['exp']) && $payload['exp'] < $time) {
            return false;
        }

        return $payload;
    }

    /**
     * create signature
     *
     * @param  string   $input  input
     * @param  string   $key    secret key
     * @param  string   $alg    algorithm
     * @return string
     */
    public static function signature(string $input, string $key, string $alg)
    {
        return hash_hmac($alg, $input, $key);
    }

    /**
    * Encode a string with URL-safe Base64.
    *
    * @param string $input The string you want encoded
    * @return string The base64 encode of what you passed in
    */
    public static function urlsafeB64Encode(string $input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    /**
    * Decode a string with URL-safe Base64.
    *
    * @param string $input A Base64 encoded string
    * @return string A decoded string
    */
    public static function urlsafeB64Decode(string $input)
    {
        $remainder = strlen($input) % 4;

        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }

        return base64_decode(strtr($input, '-_', '+/'));
    }
}
