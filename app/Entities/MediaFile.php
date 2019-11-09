<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class MediaFile extends Model
{
    // file types
    const TYPE_AVATAR = 'TYPE_AVATAR';
    const TYPE_ICON = 'TYPE_ICON';
    const TYPE_EVENT = 'TYPE_EVENT';

    protected $table = 'media_files';
    protected $fillable = ['path', 'url', 'entity', 'entity_id', 'file_type'];
    protected $hidden = ['id', 'entity_id', 'entity', 'file_type', 'path', 'uploaded_by'];
    protected $casts = [
        'path' => 'array',
        'url' => 'array',
    ];

    private static function getStoragePathByFileType(string $fileType): string
    {
        switch ($fileType) {
            case self::TYPE_ICON:
                if (!is_dir(storage_path('app/public/icon'))) {
                    mkdir(storage_path('app/public/icon'));
                }
                return 'icon';
            case self::TYPE_AVATAR:
                if (!is_dir(storage_path('app/public/avatar'))) {
                    mkdir(storage_path('app/public/avatar'));
                }
                return 'avatar';
            case self::TYPE_EVENT:
                if (!is_dir(storage_path('app/public/event'))) {
                    mkdir(storage_path('app/public/event'));
                }
                return 'event';
            default:
                if (!is_dir(storage_path('app/public/common'))) {
                    mkdir(storage_path('app/public/common'));
                }
                return 'common';
        }
    }

    public static function createFileNameByFileType(UploadedFile $file, string $fileType = null): array
    {
        $name = self::getStoragePathByFileType($fileType)
            . '/' . Str::random(20);
        return [
            $name . '.' . $file->extension(),
            $name . '_small' . '.' . $file->extension(),
        ];
    }

    public static function addFile(string $entityName, int $entityId, string $fileType, array $filePaths): self
    {
        $urls = [];
        foreach ($filePaths as $filePath) {
            $urls[] = \Storage::url($filePath);
        }

        $file = new self([
            'path' => $filePaths,
            'url' => $urls,
            'entity' => $entityName,
            'entity_id' => $entityId,
            'file_type' => $fileType,
        ]);
        $file->uploaded_by = \Auth::user()->id;
        $file->save();
        return $file;
    }

    public static function removeFile(string $entityName, int $entityId, string $fileType)
    {
        $mediaFile = static::whereEntity($entityName)
                ->whereEntityId($entityId)
                ->whereFileType($fileType)
                ->first();
        if (!$mediaFile) {
            return;
        }
        foreach($mediaFile->path as $path) {
            \Storage::disk('public')->delete($path);
        }
        $mediaFile->delete();
    }
}
