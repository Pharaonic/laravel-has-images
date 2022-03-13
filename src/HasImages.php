<?php

namespace Pharaonic\Laravel\Images;

use Exception;
use Illuminate\Http\UploadedFile;
use Pharaonic\Laravel\Helpers\Traits\HasCustomAttributes;

/**
 * Has Images Trait
 *
 * @version 2.0
 * @author Moamen Eltouny (Raggi) <raggi@raggitech.com>
 */
trait HasImages
{
    use HasCustomAttributes;
    
    /**
     * Images Atrributes on Save/Create
     *
     * @var array
     */
    protected static $imagesItems = [];

    /**
     * @return void
     */
    public function initializeHasImages()
    {
        $this->fillable[] = 'images';
    }

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
        $options = $this->filesOptions['images'] ?? [];
        foreach ($images as $sort => $img) {
            $this->images()->create([
                'sort'      => $sort,
                'upload_id' => upload($img, $options)->id
            ]);
        }

        return $this->images;
    }

    public function addImage(UploadedFile $img, int $sort = 0)
    {
        $options = $this->filesOptions['images'] ?? [];
        return $this->images()->create([
            'sort'      => $sort,
            'upload_id' => upload($img, $options)->id
        ]);
    }

    /**
     * Get All Images
     */
    public function images()
    {
        $options = $this->filesOptions['images'] ?? [];
        
        return $this->morphMany(Image::class, 'model')->with(isset($options['thumbnail']) ? 'file.thumbnail' : 'file');
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
