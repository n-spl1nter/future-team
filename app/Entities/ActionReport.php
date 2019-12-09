<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\Entities\ActionReport
 *
 * @property int $id
 * @property int $action_id
 * @property array $video_links
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entities\Action $action
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActionReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActionReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActionReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActionReport whereActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActionReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActionReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActionReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActionReport whereVideoLinks($value)
 * @mixin \Eloquent
 */
class ActionReport extends Model
{
    use HasImage;

    protected $table = 'action_reports';
    protected $casts = [
        'video_links' => 'array',
    ];

    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id', 'id');
    }

    public function toArray()
    {
        return [
            'video_links' => $this->video_links,
            'images' => $this->getImages(MediaFile::TYPE_ACTION_REPORT)->pluck('url')->toArray(),
        ];
    }



    public static function add(Action $action, Request $request)
    {
        \DB::transaction(function () use ($request, $action) {
            $report = new self();
            $report->video_links = $request->get('video_links');
            $report->action_id = $action->id;
            $report->save();
            $report->setImage($request->file('photos'), MediaFile::TYPE_ACTION_REPORT);
        });
    }
}
