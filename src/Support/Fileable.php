<?php
namespace Minhbang\File\Support;

use Minhbang\File\File;

/**
 * Dùng cho Model có nhiều files (vd: Ebook... )
 * Class Fileable
 *
 * @package Minhbang\File\Support
 * @mixin \Eloquent
 */
trait Fileable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'fileable')->orderBy('fileables.position');
    }

    public static function bootFileable()
    {
        static::deleting(
            function ($model) {
                /** @var \Minhbang\File\Support\Fileable|static $model */
                $model->files()->detach();
            }
        );
    }
}