<?php namespace Haruncpi\LaravelUserActivity\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Log extends Model
{
    public $timestamps = false;
    protected $appends = ['dateHumanize','json_data'];
    protected $connection ;

    private $userInstance = "\App\Models\User";

    public function __construct() {
        $this->connection=config('user-activity.log_connection');
        $userInstance = config('user-activity.model.user');
        if(!empty($userInstance)) $this->userInstance = $userInstance;
    }

    public function getDateHumanizeAttribute()
    {
        return Carbon::parse($this->attributes['log_date'])->diffForHumans();
    }

    public function getJsonDataAttribute()
    {
        return json_decode($this->data,true);
    }

    public function user()
    {
        return $this->belongsTo($this->userInstance);
    }
}
