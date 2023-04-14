<?php


namespace zedsh\tower\Models;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class File extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'files';

    protected $fillable = [
        'path',
        'title',
        'alt',
        'uid',
        'name',
        'ext',
        'inputFieldName'
    ];

    public function news()
    {
        return $this->morphedByMany(News::class, 'attachable');
    }

    public function isImage()
    {
        $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd','webp'];

        return in_array($this->ext, $imageExtensions);
    }

}
