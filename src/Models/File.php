<?php


namespace zedsh\tower\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;


class File extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $fillable = [
        'path',
        'name',
        'extension',
        'title',
        'alt',
        'size',
    ];

    protected $appends = [
        'url',
    ];

    protected $hidden = [
        'path',
        'name',
        'extension',
        'created_at',
        'updated_at',
        'deleted_at',
        'size',
        'pivot',
    ];

    public function isImage(): bool
    {
        $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief',
            'jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd','webp'];

        return in_array($this->extension, $imageExtensions);
    }

    public function getEditUrlAttribute(): ?string
    {
        if(!$this->exists) {
            return null;
        }

        return route('tower::innate::file.update', ['file' => $this->id]);
    }

    public function getDeleteUrlAttribute(): ?string
    {
        if(!$this->exists) {
            return null;
        }

        return route('tower::innate::file.destroy', ['file' => $this->id]);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->path);
    }
}
