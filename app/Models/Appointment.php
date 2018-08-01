<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Session;


class Appointment extends Model implements AuthenticatableContract{

    use authenticatable;

    protected $table = 'appointments';
    protected $fillable = array('customer_id','expert_id','message','chat_start' ,'contact_id','purpose','appointment_type', 'appointment_datetime','customer_phone','customer_email','customer_name','channel_id');
    protected $guarded = array('id', 'created_at', 'updated_at');

    /**
     * Customer relation 
     * Appointment has one customer
     */
    public function customer()
    {
      return $this->hasOne('App\User', 'id', 'customer_id');
    }

    /**
     * expert/service provider relation
     * Appointment has one expert/service provider
     */
    public function expert()
    {
        return $this->hasOne('App\User', 'id', 'expert_id');
    }
    
    public function appointmentType()
    {
        return $this->hasOne('App\PiplModules\admin\Models\ContactMode', 'id', 'appointment_type');
    }
    public static function addAppointment($customerID) {
      $info = Session::get('appointmentInfo');
      Appointment::create(array(
        'customer_id'  => $customerID,
        'appointment_type'  =>  $info['package_id'],
        'appointment_datetime'  =>  $info['datetime']
      ));
    }

    public function scopeTimeBetween($query, $begin, $end) {
      //return $query->whereBetween('appointment_datetime', array($begin, $end));
      return $query->where('appointment_datetime', '>', $begin)->where('appointment_datetime', '<', $end);
    } 
}
