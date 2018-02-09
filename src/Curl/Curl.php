<?php declare(strict_types=1);

namespace App\Curl;

final class Curl
{
    /**
     * @param mixed[] $getParams
     * @param mixed[] $postParams
     * @param mixed[] $headers
     */
    public function post(string $url, array $getParams, array $postParams, array $headers = []): void
    {
        $ch = curl_init(sprintf('%s?%s', $url, http_build_query($getParams)));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postParams));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_exec($ch);
        curl_close($ch);
    }
}
