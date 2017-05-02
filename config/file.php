<?php
return [
    'middleware' => ['web', 'role:sys.admin'],
    /**
     * Thư mục 'gốc' lưu files, theo định dạng helper mb_get_path()
     */
    'base_path'  => 'my_storage:files',
    /**
     * Thư mục lưu tạm, tự động xóa sau khoảng thời gian
     */
    'temp_path'  => 'my_storage:temp_files',
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
    // Định nghĩa menus cho ebook
    'menus'          => [
        'backend.sidebar.content.file' => [
            'priority' => 5,
            'url'      => 'route:backend.file.index',
            'label'    => 'trans:file::common.manage_title',
            'icon'     => 'fa-newspaper-o',
            'active'   => 'backend/file*',
        ],
    ],
];