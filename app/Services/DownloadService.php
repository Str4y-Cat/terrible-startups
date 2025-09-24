<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadService
{
    public function exportAsJson(array $data, string $filename = 'export'): StreamedResponse
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);

        return response()->streamDownload(
            function () use ($json) {
                echo $json;
            },
            "$filename.json",
            [
                'Content-Type' => 'application/json'
            ]
        );
    }
}
