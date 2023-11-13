<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string $login
 * @property string $password
 * @property string|null $id_1c
 * @property string|null $device_token
 * @property int $status
 * @property string|null $lat
 * @property string|null $lng
 * @property int|null $store_id
 * @property int|null $storage_id
 * @property int|null $organization_id
 * @property string|null $remember_token
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeviceToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId1c($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStorageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property string|null $bank
 * @property-read \App\Models\Organization|null $organization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Receipt> $receipts
 * @property-read int|null $receipts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Refund> $refunds
 * @property-read int|null $refunds_count
 * @property-read \App\Models\Storage|null $storage
 * @property-read \App\Models\Store|null $store
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBank($value)
 * @property string|null $webkassa_login
 * @property string|null $webkassa_token
 * @property string|null $webkassa_login_at
 * @property string|null $webkassa_password
 * @property int|null $webkassa_cash_box_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RefundProducer> $refundProducer
 * @property-read int|null $refund_producer_count
 * @property-read int|null $rejects_count
 * @property-read \App\Models\WebkassaCashBox|null $webkassaCashBox
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWebkassaCashBoxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWebkassaLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWebkassaLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWebkassaPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWebkassaToken($value)
 * @property string|null $balance
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Moving> $movings
 * @property-read int|null $movings_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBalance($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reject> $rejects
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Coming> $comings
 * @property-read int|null $comings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Moving> $fromMovings
 * @property-read int|null $from_movings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Moving> $toMovings
 * @property-read int|null $to_movings_count
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'id',
        'name',
        'phone',
        'password',
        'login',
        'id_1c',
        'device_token',
        'role_id',
        'created_at',
        'warehouse_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::make($value),
        );
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function collectings(): HasMany
    {
        return $this->hasMany(Collecting::class);
    }

    public function fromMovings(): HasMany
    {
        return $this->hasMany(Moving::class,'from_user_id');
    }
    public function toMovings(): HasMany
    {
        return $this->hasMany(Moving::class,'to_user_id');
    }
    //Списание
    public function rejects(): HasMany
    {
        return $this->hasMany(Reject::class);
    }
    public function comings(): HasMany
    {
        return $this->hasMany(Coming::class);
    }
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function couplings(): HasMany
    {
        return $this->hasMany(Coupling::class);
    }

}
