<?php namespace Minhbang\File\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Minhbang\File\Support\Fileable;

/**
 * Class Model2
 * @property integer $id
 * @property string $name
 * @package Minhbang\File\Tests\Stubs
 * @author Minh Bang
 */
class Model2 extends Model
{
    use Fileable;

    public $table = 'filetest_model2s';
    public $timestamps = false;
    protected $fillable = ['name'];
}