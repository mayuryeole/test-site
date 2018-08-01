<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class BookingDateTime extends Model implements AuthenticatableContract {

    use Authenticatable;

    protected $table = 'booking_datetimes';
    protected $fillable = ['user_id,booking_datetime'];
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public static function addAvailability($paramDate)
    {
        BookingDateTime::create($paramDate);
    }

    public static function deleteAvailability($paramDate)
    {
//        DB::table('booking_datetimes')->where([
        BookingDateTime::where([
            'booking_datetime' => $paramDate,
            'status' => "0"
        ])->delete();
//        BookingDateTime::create([
//            'booking_datetime' => $paramDate,
//        ]);
    }

    public function scopeTimeBetween($query, $begin, $end) {
        return $query->where('booking_datetime', '>=', $begin)->where('booking_datetime', '<', $end);
    }

}
