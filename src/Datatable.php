<?php namespace Minhbang\File;

use Minhbang\Kit\Extensions\Datatable as BaseDatatable;
use Html;

/**
 * Class Datatable
 *
 * @package Minhbang\File
 */
class Datatable extends BaseDatatable
{
    /**
     * @return array
     */
    function columns()
    {
        return [
            'index'   => [
                'title' => '#',
                'data'  => '',
            ],
            'icon'    => [
                'title' => '',
                'data'  => function (File $model) {
                    return $model->present()->icon;
                },
            ],
            'title'   => [
                'title' => trans('file::common.title'),
                'data'  => function (File $model) {
                    return Html::linkQuickUpdate(
                        $model->id,
                        $model->title,
                        [
                            'attr'      => 'title',
                            'title'     => trans("file::common.title"),
                            'class'     => 'w-lg',
                            'placement' => 'top',
                        ]
                    );
                },
            ],
            'actions' => [
                'title' => trans('common.actions'),
                'data'  => function (File $model) {
                    $edit = Html::linkButton(
                        '#',
                        null,
                        [
                            'class' => 'replace',
                            'size'  => 'xs',
                            'icon'  => 'fa-cloud-upload',
                            'type'  => 'success',
                            'title' => trans('file::common.replace'),
                        ],
                        ['id' => $model->id]
                    );

                    return $edit . Html::tableActions(
                        "{$this->zone}.file",
                        ['file' => $model->id],
                        $model->title,
                        $this->name,
                        [
                            'renderPreview' => 'link',
                            'renderEdit'    => false,
                            'renderShow'    => 'modal',
                        ]
                    );
                },
            ],
        ];
    }

    /**
     * @return array
     */
    function zones()
    {
        return [
            'backend' => [
                'table'   => [
                    'id'        => 'file-manage',
                    'row_index' => true,
                ],
                'columns' => [
                    'index'   => 'min-width text-right',
                    'icon'    => 'min-width',
                    'title'   => 'file-title',
                    'actions' => 'min-width',
                ],
                'search'  => 'files.title',
            ],
        ];
    }
}