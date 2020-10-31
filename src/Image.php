<?php

namespace Pharaonic\Laravel\Images;

use Illuminate\Database\Eloquent\Model;
use Pharaonic\Laravel\Uploader\Upload;

/**
 * Image Model
 *
 * @version 1.0
 * @author Raggi <support@pharaonic.io>
 * @license http://opensource.org/licenses/mit-license.php MIT License
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
