<?php

namespace EbanxChallenge\Core\Web
{
    class Mime
    {
        private const EXTENSIONS = [
            'bin'  => 'application/octet-stream',
            'css'  => 'text/css; charset=utf-8"',
            'csv'  => 'text/csv; charset=utf-8"',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'htm'  => 'text/html; charset=utf-8"',
            'html' => 'text/html; charset=utf-8"',
            'ics'  => 'text/calendar; charset=utf-8"',
            'js'   => 'application/javascript',
            'json' => 'application/json',
            'odp'  => 'application/vnd.oasis.opendocument.presentation',
            'ods'  => 'application/vnd.oasis.opendocument.spreadsheet',
            'odt'  => 'application/vnd.oasis.opendocument.text',
            'pdf'  => 'application/pdf',
            'ppt'  => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'rtf'  => 'application/rtf',
            'xhtml' => 'application/xhtml+xml',
            'xls'  => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'zip'  => 'application/zip',
        ];

        public static function getFromPath(string $path) : string
        {
            $extension = strtoupper(pathinfo($path, PATHINFO_EXTENSION));
            $constantName = "IMAGETYPE_{$extension}";
            $mime = null;

            if(defined($constantName))
            {
                $mime = image_type_to_mime_type(constant($constantName));
            }
            else
            {
                $extension = strtolower($extension);
                if(array_key_exists($extension, self::EXTENSIONS)) 
                {
                    $mime = self::EXTENSIONS[$extension];
                }
                else
                {
                    $mime = mime_content_type($path);

                    if(\str_starts_with($mime, 'text'))
                    {
                        $mime = "{$mime}; charset=utf-8";
                    }
                }
            }
            return $mime;
        }
    }
}