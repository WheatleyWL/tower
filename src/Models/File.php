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
    ];

    public function news()
    {
        return $this->morphedByMany(News::class, 'attachable');
    }

}
