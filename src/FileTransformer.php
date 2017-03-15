<?php namespace Minhbang\File;

use Minhbang\Kit\Extensions\ModelTransformer;
use Html;

/**
 * Class FileTransformer
 */
class FileTransformer extends ModelTransformer
{
    /**
     * @param \Minhbang\File\File $file
     *
     * @return array
     */
    public function transform(File $file)
    {
        return [
            'id'      => (int)$file->id,
            'icon'    => $file->present()->icon,
            'title'   => Html::linkQuickUpdate($file->id, $file->title, [
                    'attr'      => 'title',
                    'title'     => trans("file::common.title"),
                    'class'     => 'w-lg',
                    'placement' => 'top',
                ]
            ),
            'actions' =>
                Html::linkButton(
                    '#',
                    null,
                    [
                        'class' => 'replace',
                        'size'  => 'xs',
                        'icon'  => 'fa-cloud-upload',
                        'type'  => 'success',
                        'title' => trans('file::common.replace'),
                    ],
                    ['id' => $file->id]
                ) .
                Html::tableActions(
                    "{$this->zone}.file",
                    ['file' => $file->id],
                    $file->title,
                    trans("file::common.file"),
                    [
                        'renderPreview' => 'link',
                        'renderEdit'    => false,
                        'renderShow'    => 'modal',
                    ]
                ),
        ];
    }
}