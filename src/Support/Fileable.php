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
trait Fileable {
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function files() {
        return $this->morphToMany( File::class, 'fileable' )->orderBy( 'fileables.position' );
    }

    /**
     * @return \Minhbang\File\File
     */
    public function firstFile() {
        return $this->files->first();
    }

    public static function bootFileable() {
        static::deleting(
            function ( $model ) {
                /** @var \Minhbang\File\Support\Fileable|static $model */
                foreach ( $model->files as $file ) {
                    $file->delete();
                }
                $model->files()->detach();
            }
        );
    }

    /**
     * @param string|integer|array $files
     */
    public function fillFiles( $files ) {
        if ( $files ) {
            $files = is_string( $files ) ? explode( ',', $files ) : (array) $files;
            File::whereIn( 'id', $files )->update( [ 'tmp' => 0 ] );
            if ( $this->exists ) {
                $changes = $this->files()->sync( $files );
                if ( $changes['detached'] ) {
                    foreach ( File::whereIn( 'id', $changes['detached'] )->get() as $file ) {
                        $file->delete();
                    }
                }
            } else {
                $this->files()->attach( $files );
            }
        }
    }

    /**
     * @return array
     */
    public function filesForReturn() {
        return $this->files->map( function ( File $file ) {
            return $file->forReturn();
        } )->all();
    }
}