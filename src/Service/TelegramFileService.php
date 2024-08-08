<?php

declare(strict_types=1);

namespace App\Service;

class TelegramFileService implements TelegramFileServiceInterface
{
    private const TG_FILEPATH = 'https://api.telegram.org/file/bot%s/%s';

    public function downloadFile(string $tgFilePath): string
    {
        $url = sprintf(self::TG_FILEPATH, $_ENV['TG_API_TOKEN'], $tgFilePath);
        $filename = basename($url);
        $downloadedFilePath = sys_get_temp_dir().'/'.$filename;
        stream_copy_to_stream(
            fopen($url, 'r'),
            fopen($downloadedFilePath, 'w'),
        );

        return $downloadedFilePath;
    }
}
