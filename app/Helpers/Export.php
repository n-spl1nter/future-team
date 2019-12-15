<?php

namespace App\Helpers;

class Export
{
    /**
     * @param string $filename
     * @return array
     */
    protected static function getCSVHeaders(string $filename): array
    {
        return [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];
    }

    public static function getExportStream(callable $callBack, string $fileName)
    {
        return \Response::stream($callBack, 200, self::getCSVHeaders($fileName));
    }
}
