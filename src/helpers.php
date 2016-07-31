<?php
if ( ! function_exists('mb_get_path')) {
    /**
     * - Nếu có 'location:path', sử dụng helper path functions,
     *   vd: 'storage:data/files' => storage_path('data/files')
     *   location = app | base | config | database | public | storage
     * - Ngước lại, path bình thường
     *
     * @param $path
     *
     * @return string
     */
    function mb_get_path($path)
    {
        if (strpos($path, ':') !== false) {
            list($location, $path) = explode(':', $path, 2);
            $path = call_user_func("{$location}_path", $path);
        }

        return $path;
    }
}

if ( ! function_exists('mb_mkdir')) {
    /**
     * Tạo thư mục, tùy chọn theo thời gian, vd: base/path/2016/7
     *
     * @param string $dir
     * @param \Carbon\Carbon $time
     * @param string $format
     * @param int $mode
     *
     * @return false|string
     */
    function mb_mkdir($dir, $time = null, $format = 'Y/m', $mode = 0755)
    {
        if ( ! is_null($time)) {
            $dir = rtrim($dir, '/') . '/' . $time->format($format);
        }

        if ( ! is_dir($dir)) {
            mkdir($dir, $mode, true);
        }

        return $dir;
    }
}

if ( ! function_exists('mb_file_response')) {
    /**
     * Xuất file về browser
     *
     * @param string $file
     * @param string $mime
     */
    function mb_file_response($file, $mime)
    {
        header("Content-type: {$mime}");
        header('Content-Disposition: inline');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        readfile($file);
    }
}
