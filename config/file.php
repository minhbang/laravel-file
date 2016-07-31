<?php
return [
    'add_route' => true,
    /**
     * Thư mục 'gốc' lưu files, theo định dạng helper get_path()
     */
    'base_path' => 'storage:data/files',
    /**
     * Thư mục lưu tạm, tự động xóa sau khoảng thời gian
     */
    'temp_path' => 'storage:data/temp_files',

    'datatable' => \Minhbang\File\Datatable::class,
    /**
     * File css icon class
     */
    'icons'     => [
        'pdf'     => 'fa fa-file-pdf-o text-danger',
        'doc*'    => 'fa fa-file-word-o text-primary',
        'ppt*'    => 'fa fa-file-powerpoint-o text-warning',
        'xls*'    => 'fa fa-file-excel-o text-success',
        'rtf'     => 'fa fa-file-text-o',
        'zip'     => 'fa fa-file-zip-o',
        'rar'     => 'fa fa-file-zip-o',
        'default' => 'fa fa-file-o',
    ],
];