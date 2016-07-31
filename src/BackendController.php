<?php namespace Minhbang\File;

use Minhbang\Kit\Extensions\BackendController as BaseController;
use Minhbang\Kit\Traits\Controller\QuickUpdateActions;
use Illuminate\Http\Request;

/**
 * Class BackendController
 *
 * @package Minhbang\File
 */
class BackendController extends BaseController
{
    use QuickUpdateActions;

    /**
     * @return \Minhbang\File\Datatable
     */
    protected function getDatatable()
    {
        return $this->newClassInstance(config('file.datatable'), 'backend', trans('file::common.file'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->getDatatable()->share();
        $this->buildHeading(
            trans('file::common.manage_title'),
            'fa-newspaper-o',
            ['#' => trans('file::common.file')],
            [
                [
                    '#',
                    trans('file::common.add_new'),
                    ['class' => 'add-new', 'type' => 'primary', 'size' => 'sm', 'icon' => 'plus-sign'],
                ],
            ]
        );

        return view('file::backend.index');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        return $this->getDatatable()->make(File::orderUpdated());
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $file = new File();
        $file->fill($request->all());
        $error = null;
        if ( ! $file->title) {
            $error = trans('file::error.empty_title');
        } else {
            if ($file->fillFile($request)) {
                $file->save();
            } else {
                $error = trans('file::error.empty_file');
            }
        }

        return response()->json(
            [
                'type'    => $error ? 'error' : 'success',
                'content' => $error ?: trans('file::common.upload_success'),
            ]
        );
    }

    /**
     * @param \Minhbang\File\File $file
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(File $file)
    {
        return view('file::backend.show', compact('file'));
    }

    /**
     * @param \Minhbang\File\File $file
     */
    public function preview(File $file)
    {
        $file->response();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Minhbang\File\File $file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, File $file)
    {
        $error = null;
        if ($file->fillFile($request)) {
            $file->save();
        } else {
            $error = trans('file::error.empty_file');
        }

        return response()->json(
            [
                'type'    => $error ? 'error' : 'success',
                'content' => $error ?: trans('file::common.replace_success'),
            ]
        );
    }

    /**
     * @param \Minhbang\File\File $file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(File $file)
    {
        $file->delete();

        return response()->json(
            [
                'type'    => 'success',
                'content' => trans('common.delete_object_success', ['name' => trans('file::common.file')]),
            ]
        );
    }

    /**
     * Các attributes cho phép quick-update
     *
     * @return array
     */
    protected function quickUpdateAttributes()
    {
        return [
            'title' => [
                'rules' => 'required|max:255',
                'label' => trans('file::common.title'),
            ],
        ];
    }
}