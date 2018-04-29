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
                    'title'     => __("Title"),
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
                        'title' => __('Replace file'),
                    ],
                    ['id' => $file->id]
                ) .
                Html::tableActions(
                    "{$this->zone}.file",
                    ['file' => $file->id],
                    $file->title,
                    __("File"),
                    [
                        'renderPreview' => 'link',
                        'renderEdit'    => false,
                        'renderShow'    => 'modal',
                    ]
                ),
        ];
    }
}