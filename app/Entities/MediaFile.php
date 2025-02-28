<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Image;

/**
 * App\Entities\MediaFile
 *
 * @property int $id
 * @property array $path
 * @property array $url
 * @property string $entity
 * @property int $entity_id
 * @property string $file_type
 * @property int $uploaded_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MediaFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MediaFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MediaFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MediaFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MediaFile whereEntity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MediaFile whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MediaFile whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MediaFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MediaFile wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MediaFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MediaFile whereUploadedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MediaFile whereUrl($value)
 * @mixin \Eloquent
 */
class MediaFile extends Model
{
    // file types
    const TYPE_AVATAR = 'TYPE_AVATAR';
    const REVIEW_AVATAR = 'REVIEW_AVATAR';
    const REVIEW_FLAG = 'REVIEW_FLAG';
    const TYPE_ICON = 'TYPE_ICON';
    const TYPE_EVENT = 'TYPE_EVENT';
    const TYPE_ACTION = 'TYPE_ACTION';
    const TYPE_ACTION_REPORT = 'TYPE_ACTION_REPORT';
    const TYPE_SLIDER_PHOTO = 'TYPE_SLIDER_PHOTO';

    protected $table = 'media_files';
    protected $fillable = ['path', 'url', 'entity', 'entity_id', 'file_type'];
    protected $visible = ['url', 'id'];
    protected $casts = [
        'path' => 'array',
        'url' => 'array',
    ];

    private static function getStoragePathByFileType(string $fileType): string
    {
        switch ($fileType) {
            case self::TYPE_SLIDER_PHOTO:
                if (!is_dir(storage_path('app/public/slider'))) {
                    mkdir(storage_path('app/public/slider'));
                }
                return 'slider';
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
            case self::REVIEW_FLAG:
            case self::REVIEW_AVATAR:
                if (!is_dir(storage_path('app/public/review-avatar'))) {
                    mkdir(storage_path('app/public/review-avatar'));
                }
                return 'review-avatar';
            case self::TYPE_EVENT:
                if (!is_dir(storage_path('app/public/event'))) {
                    mkdir(storage_path('app/public/event'));
                }
                return 'event';
            case self::TYPE_ACTION:
                if (!is_dir(storage_path('app/public/action'))) {
                    mkdir(storage_path('app/public/action'));
                }
                return 'action';
            case self::TYPE_ACTION_REPORT:
                if (!is_dir(storage_path('app/public/action_report'))) {
                    mkdir(storage_path('app/public/action_report'));
                }
                return 'action_report';
            default:
                if (!is_dir(storage_path('app/public/common'))) {
                    mkdir(storage_path('app/public/common'));
                }
                return 'common';
        }
    }

    /**
     * @param UploadedFile | string $file
     * @param string|null $fileType
     * @return array
     */
    public static function createFileNameByFileType($file, string $fileType = null): array
    {
        $name = self::getStoragePathByFileType($fileType)
            . '/' . Str::random(20);
        if ($file instanceof \stdClass) {
            $ext = $file->extension;
        } else {
            $ext = $file->extension();
        }
        return [
            $name . '.' . $ext,
            $name . '_small' . '.' . $ext,
        ];
    }

    public static function addFile(string $entityName, int $entityId, string $fileType, array $filePaths): self
    {
        $urls = [];
        $baseUrl = env('APP_URL');
        foreach ($filePaths as $filePath) {
            $urls[] = $baseUrl . \Storage::url($filePath);
        }

        $file = new self([
            'path' => $filePaths,
            'url' => $urls,
            'entity' => $entityName,
            'entity_id' => $entityId,
            'file_type' => $fileType,
        ]);
        $file->uploaded_by = \Auth::user() ? \Auth::user()->id : null;
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
        $mediaFile->deleteWithFiles();
    }

    public function deleteWithFiles()
    {
        foreach($this->path as $path) {
            \Storage::disk('public')->delete($path);
        }
        return $this->delete();
    }
}
