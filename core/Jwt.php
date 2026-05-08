<?php

class Jwt
{
    public static function encode(array $payload, string $secret): string
    {
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256',
        ];

        $segments = [
            self::base64UrlEncode(json_encode($header)),
            self::base64UrlEncode(json_encode($payload)),
        ];

        $signature = hash_hmac('sha256', implode('.', $segments), $secret, true);
        $segments[] = self::base64UrlEncode($signature);

        return implode('.', $segments);
    }

    public static function decode(string $jwt, string $secret): array
    {
        $parts = explode('.', $jwt);

        if (count($parts) !== 3) {
            throw new Exception('Invalid token');
        }

        [$encodedHeader, $encodedPayload, $encodedSignature] = $parts;
        $header = json_decode(self::base64UrlDecode($encodedHeader), true);
        $payload = json_decode(self::base64UrlDecode($encodedPayload), true);

        if (!is_array($header) || !is_array($payload) || ($header['alg'] ?? null) !== 'HS256') {
            throw new Exception('Invalid token');
        }

        $expectedSignature = self::base64UrlEncode(
            hash_hmac('sha256', $encodedHeader . '.' . $encodedPayload, $secret, true)
        );

        if (!hash_equals($expectedSignature, $encodedSignature)) {
            throw new Exception('Invalid token signature');
        }

        if (isset($payload['exp']) && time() >= $payload['exp']) {
            throw new Exception('Token expired');
        }

        return $payload;
    }

    public static function getBearerToken(): ?string
    {
        $header = $_SERVER['HTTP_AUTHORIZATION']
            ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION']
            ?? null;

        if (!$header && function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            $header = $headers['Authorization'] ?? $headers['authorization'] ?? null;
        }

        if (!$header || !preg_match('/Bearer\s+(\S+)/', $header, $matches)) {
            return null;
        }

        return $matches[1];
    }

    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $data): string
    {
        $remainder = strlen($data) % 4;

        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }

        return base64_decode(strtr($data, '-_', '+/'));
    }
}
