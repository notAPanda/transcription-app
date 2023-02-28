<?php

namespace App\Services;

use App\Models\File;
use Aws\S3\S3Client;
use Illuminate\Support\Str;

class FileService
{

    public static function createS3Object(File $file)
    {
        $s3Client = new S3Client([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => '2006-03-01',
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $filename = Str::slug($file->name);
        $random = Str::random(6);
        $key = "{$file->user_id}/{$filename}_{$random}.{$file->extension}";

        $cmd = $s3Client->getCommand('PutObject', [
            'Bucket' => env('AWS_BUCKET'),
            'Key' => $key,
        ]);

        $upload_url = $s3Client->createPresignedRequest($cmd, '+20 minutes')->getUri()->__toString();

        $file->s3_path = $key;
        $file->save();

        return [
            'upload_url' => $upload_url,
            'download_url' => $key,
        ];
    }
}
