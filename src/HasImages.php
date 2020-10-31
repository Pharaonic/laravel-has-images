<?php

namespace Pharaonic\Laravel\Images;

use Exception;
use Illuminate\Http\UploadedFile;

/**
 * Has Images Trait
 *
 * @version 1.0
 * @author Raggi <support@pharaonic.io>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
trait HasImages
{
    /**
     * Images Atrributes on Save/Create
     *
     * @var array
     */
    protected static $imagesItems = [];

    protected static function bootHasImages()
    {
        // Created
        self::creating(function ($model) {
            foreach ($model->getAttributes() as $name => $value) {
                if ($name == 'images') {
                    if (!is_array($value)) throw new Exception('Images should be an Array.');

                    self::$imagesItems = $value;
                    unset($model->{$name});
                }
            }
        });

        // Created
        self::created(function ($model) {
            if (count(self::$imagesItems) > 0) {
                $model->_setImagesAttribute(self::$imagesItems);
                unset($model->images);
            }
        });

        // Retrieving
        self::retrieved(function ($model) {
            try {
                $model->addSetterAttribute('images', '_setImagesAttribute');
            } catch (\Throwable $e) {
                throw new Exception('You have to use Pharaonic\Laravel\Helpers\Traits\HasCustomAttributes as a trait in ' . get_class($model));
            }
        });


        // Deleting
        self::deleting(function ($model) {
            $model->clearImages();
        });
    }

    /**
     * Uploading/Re-Upload Images
     */
    public function _setImagesAttribute($images)
    {
        $this->clearImages();

        foreach ($images as $sort => $img) {
            $this->images()->create([
                'sort'      => $sort,
                'upload_id' => upload($img)->id
            ]);
        }

        return $this->images;
    }

    public function addImage(UploadedFile $img, int $sort = 0)
    {
        return $this->images()->create([
            'sort'      => $sort,
            'upload_id' => upload($img)->id
        ]);
    }

    /**
     * Get All Images
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }

    /**
     * Clear All Images
     */
    public function clearImages()
    {
        foreach ($this->images()->get() as $image) {
            $image->file->delete();
        }
    }
}
