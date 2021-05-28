<?php

namespace Pharaonic\Laravel\Images;

use Illuminate\Database\Eloquent\Model;
use Pharaonic\Laravel\Uploader\Upload;

/**
 * Image Model
 *
 * @version 2.0
 * @author Moamen Eltouny (Raggi) <raggi@raggitech.com>
 */
class Image extends Model
{
    /**
     * Fillable Columns
     *
     * @var array
     */
    protected $fillable = ['sort', 'upload_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(Upload::class, 'upload_id');
    }

    /**
     * Get Url Directly
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->file->url;
    }

    /**
     * Get Thumbnail
     *
     * @return string
     */
    public function getThumbnailAttribute()
    {
        return $this->file->thumbnail ?? null;
    }

    /**
     * Set Sort Index
     */
    public function setSort($value)
    {
        $this->sort = $value;
        $this->save();

        return $this;
    }

    /**
     * Get the owning model.
     */
    public function model()
    {
        return $this->morphTo();
    }
}
