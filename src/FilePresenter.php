<?php
namespace Minhbang\File;

use Html;
use Laracasts\Presenter\Presenter;

/**
 * Class FilePresenter
 *
 * @property \Minhbang\File\File $entity
 * @package Minhbang\Kit\Traits\Presenter
 */
class FilePresenter extends Presenter
{
    /**
     * @var array
     */
    protected static $icons;

    /**
     * FilePresenter constructor.
     *
     * @param $entity
     */
    public function __construct($entity)
    {
        parent::__construct($entity);
        if (is_null(static::$icons)) {
            static::$icons = config('file.icons');
        }
    }

    /**
     * Icon theo file ext
     *
     * @return string
     */
    public function icon()
    {
        $ext   = $this->entity->ext;
        $class = null;
        foreach (static::$icons as $pattern => $icon) {
            if (str_is($pattern, $ext)) {
                $class = $icon;
                break;
            }
        }
        $class = $class ?: static::$icons['default'];

        return "<i class=\"$class\"></i>";
    }

    /**
     * Format file size
     *
     * @return string
     */
    public function size()
    {
        return mb_format_bytes($this->entity->size, 1);
    }

    /**
     * @param string $attribute
     *
     * @return string
     */
    public function title($attribute = 'title')
    {
        $title = $attribute ? $this->entity->{$attribute} . ' — ' : '';

        return $this->icon() . ' ' . $title . $this->size();
    }

    /**
     * @param string $route
     * @param string $attribute
     * @param array $options
     *
     * @return string
     */
    public function link($route, $attribute = 'title', $options = [])
    {
        return Html::link(route($route, ['file' => $this->entity->id]), $this->title($attribute), $options);
    }
}