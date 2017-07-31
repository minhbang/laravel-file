<?php namespace Minhbang\File;

use Carbon\Carbon;
use Laracasts\Presenter\PresentableTrait;
use Minhbang\Kit\Extensions\Model;
use Minhbang\Kit\Traits\Model\DatetimeQuery;
use DB;
use Minhbang\Kit\Traits\Model\SearchQuery;
use Imagick;

/**
 * Class File
 *
 * @package Minhbang\File\File
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property string $mime
 * @property integer $size
 * @property integer $hit
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read string $path
 * @property-read string $file_path
 * @property-read string $ext
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File whereId( $value )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File whereTitle( $value )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File whereName( $value )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File whereMime( $value )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File whereSize( $value )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File whereHit( $value )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File whereCreatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Kit\Extensions\Model except( $id = null )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Kit\Extensions\Model whereAttributes( $attributes )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Kit\Extensions\Model findText( $column, $text )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File orderCreated( $direction = 'desc' )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File orderUpdated( $direction = 'desc' )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File period( $start = null, $end = null, $field = 'created_at', $end_if_day = false, $is_month = false )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File today( $field = 'created_at' )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File yesterday( $same_time = false, $field = 'created_at' )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File thisWeek( $field = 'created_at' )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File thisMonth( $field = 'created_at' )
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\File\File searchKeyword( $keyword, $columns = null )
 * @mixin \Eloquent
 */
class File extends Model {
    use SearchQuery;
    use DatetimeQuery;
    use PresentableTrait;
    protected $presenter = FilePresenter::class;
    protected $table = 'files';
    protected $fillable = [ 'title', 'tmp' ];
    protected $searchable = [ 'title' ];
    /**
     * Thư mục 'base' của tất cả các file
     *
     * @var string
     */
    protected static $base_path;

    /**
     * File constructor.
     *
     * @param array $attributes
     */
    public function __construct( array $attributes = [] ) {
        parent::__construct( $attributes );
        if ( is_null( static::$base_path ) ) {
            static::$base_path = mb_get_path( config( 'file.base_path' ) );
        }
    }

    /**
     * Lấy các models đã được attach file này
     *
     * @param string|\Minhbang\Kit\Extensions\Model $model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function fileables( $model ) {
        if ( ! is_string( $model ) ) {
            $model = get_class( $model );
        }

        return $this->morphedByMany( $model, 'fileable' );
    }

    /**
     * @param \Request|string $request
     *
     * @return bool
     */
    public function fillFile( $request ) {
        if ( $file = $request->file( 'name' ) ) {
            $filename = xuuid() . '.' . strtolower( $file->getClientOriginalExtension() );
            $file = $file->move( $this->path, $filename );
            $this->performDeleteFile();
            $this->name = $filename;
            $this->mime = $file->getMimeType();
            $this->size = $file->getSize();

            return true;
        } else {
            return false;
        }

    }

    /**
     * Nếu có lỗi, trả về msg
     *
     * @param \Request|string $request
     *
     * @return string|null
     */
    public function fillRequest( $request ) {
        $this->fill( $request->all() );
        $error = null;
        if ( ! $this->title ) {
            $error = trans( 'file::error.empty_title' );
        } else {
            if ( $this->fillFile( $request ) ) {
                $this->save();
            } else {
                $error = trans( 'file::error.empty_file' );
            }
        }

        return $error;
    }

    /**
     * @return bool
     */
    public function performDeleteFile() {
        return $this->exists && $this->name ? unlink( $this->getFilePathAttribute() ) : false;
    }

    /**
     * Thư mục chứa file, phân chia thư mục con theo năm/tháng
     * getter $this->path
     *
     * @return string
     */
    public function getPathAttribute() {
        if ( ! $this->exists ) {
            $this->created_at = Carbon::now();
        }

        return mb_mkdir( static::$base_path, $this->created_at );
    }

    /**
     * Đường dẫn đầy đủ của file
     * getter $this->file_path
     */
    public function getFilePathAttribute() {
        return $this->getPathAttribute() . '/' . $this->name;
    }

    /**
     * getter $this->ext, file xxtension
     *
     * @return string
     */
    public function getExtAttribute() {
        return substr( $this->name, strrpos( $this->name, '.' ) + 1 );
    }

    /**
     * Xuất file về browser
     */
    public function response() {
        mb_file_response( $this->getFilePathAttribute(), $this->mime );
    }

    /**
     * @param string $viewRoute
     * @param array $params
     *
     * @return array
     */
    public function forReturn( $viewRoute = 'backend.file.preview', $params = [] ) {
        $result = $this->toArray();
        $result['title'] = $this->present()->title;
        if ( $viewRoute ) {
            $result['title'] = '<a target="_blank" href="' . route( $viewRoute, [ 'file' => $this->id ] + $params ) . '">' . $result['title'] . '</a>';
        }

        return $result;
    }

    public static function boot() {
        parent::boot();
        // File events
        static::deleting( function ( File $file ) {
            $file->performDeleteFile();
            DB::table( 'fileables' )->where( 'file_id', $file->id )->delete();
        } );
    }

    /**
     * Xóa hết các file tạm, quá hạn $h giờ
     *
     * @param int $h
     */
    public static function emptyTmp( $h = 1 ) {
        $files = static::where( 'tmp', 1 )->where( 'created_at', '<', Carbon::now()->subHour( $h )->toDateTimeString() )->get();
        foreach ( $files as $file ) {
            $file->delete();
        }
    }

    /**
     * Lấy Hình ảnh trang đầu của file PDF
     *
     * @param int $resolution
     * @param string $format
     *
     * @return \Imagick|null
     */
    public function pdfThumbnail( $resolution = 72, $format = 'png' ) {
        if ( ! $this->exists || $this->mime != 'application/pdf' ) {
            return null;
        }
        $imagick = new Imagick();
        $imagick->setResolution( $resolution, $resolution );
        $imagick->setFormat( $format );
        $imagick->readImage( sprintf( '%s[%s]', $this->file_path, 0 ) );
        $imagick->mergeImageLayers( Imagick::LAYERMETHOD_FLATTEN );
        $imagick->trimImage( 0.1 );

        return $imagick;
    }
}