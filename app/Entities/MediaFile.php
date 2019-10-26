<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * App\Entities\MediaFile
 *
 * @property int $id
 * @property string $path
 * @property string $url
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

    protected $table = 'media_files';
    protected $fillable = ['path', 'url', 'entity', 'entity_id',];
    protected $hidden = ['entity_id', 'entity', 'file_type', 'path'];

    private static function getStoragePathByFileType(string $fileType): string
    {
        switch ($fileType) {
            case self::TYPE_AVATAR:
                return storage_path('avatar');
            default:
                return storage_path('common');
        }
    }

    public static function createFileNameByFilePath(UploadedFile $file, string $fileType): string
    {
        return self::getStoragePathByFileType($fileType)
            . '/' . Str::random(20)
            . '.' . $file->extension();
    }

    public static function addImage(string $filePath, string $entityName, int $entityId, string $fileType): self
    {
        $file = new self([
            'path' => $filePath,
            'url' => \Storage::url($filePath),
            'entity' => $entityName,
            'entity_id' => $entityId,
            'file_type' => $fileType,
        ]);
        $file->uploaded_by = \Auth::user()->id;
        $file->save();
        return $file;
    }
}
