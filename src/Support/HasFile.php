<?php namespace Minhbang\File\Support;

use Minhbang\File\File;

/**
 * Dùng cho các model gắn với MỘT file
 * Trait HasFile
 *
 * @property int $file_id
 * @property-read File $file
 * @package Minhbang\File\Support
 * @mixin \Eloquent
 */
trait HasFile
{
    public static function bootHasFile()
    {
        static::deleting(function ($model) {
            /** @var \Minhbang\File\Support\HasFile|static $model */
            if ($model->file) {
                $model->file->delete();
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    /**
     * Lưu file, trả về thông tin lỗi hoặc NULL
     *
     * @param \Request|mixed $request
     * @param string $title_key
     * @param string $file_key
     * @return null|string
     */
    public function fillFile($request, $title_key = 'title', $file_key = 'file_id')
    {
        $file = new File();
        $error = $file->fillRequest($request, $title_key, $file_key);
        if (is_null($error)) {
            $this->file_id = $file->id;
        }

        return $error;
    }

    /**
     * Cập nhật file (nếu có)/Add File, trả về thông tin lỗi hoặc NULL
     *
     * @param \Request|mixed $request
     * @param string $title_key
     * @param string $file_key
     * @return null|string
     */
    public function updateFile($request, $title_key = 'title', $file_key = 'file_id')
    {
        if ($this->file) {
            if ($request->file($file_key)) {
                $error = $this->file->fillFile($request, $file_key);
                if (is_null($error)) {
                    $this->file->save();
                }

                return $error;
            } else {
                if ($title = $request->get($title_key)) {
                    $this->file->update(['title' => $title]);
                }

                return null;
            }
        } else {
            return $this->fillFile($request, $title_key, $file_key);
        }
    }
}