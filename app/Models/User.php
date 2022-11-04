<?php

namespace App\Models;

use App\Enums\Favorites;
use App\Services\Auth\Interfaces\IUserModel;
use App\Traits\ModelHelper;
use Database\Factories\UserFactory;
use DomainException;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Scout\Searchable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $profile_id
 * @property string $profile_type
 * @property string $salt
 * @property-read string $type
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Model|Eloquent $profile
 * @property-read TemporaryToken|null $temporaryToken
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereProfileId($value)
 * @method static Builder|User whereProfileType($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereSalt($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|Image[] $images
 * @property-read int|null $images_count
 * @property-read Collection|PersonalSorting[] $personalSorting
 * @property-read int|null $personal_sorting_count
 */
class User extends Authenticatable implements IUserModel
{
    use HasApiTokens, HasFactory, Notifiable, Searchable, ModelHelper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'email',
        'password',
        'remember_token',
        'salt',
        'profile_id',
        'profile_type'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['type'];

    public function getTypeAttribute(): string
    {
        switch ($this->profile_type) {
            case Salon::class :
                return 'salon';
            case Customer::class :
                return 'customer';
            case Admin::class :
                return 'admin';
        }
        throw new DomainException('unknown user type');
    }

    public function profile(): MorphTo
    {
        return $this->morphTo('profile');
    }

    public function temporaryToken(): HasOne
    {
        return $this->hasOne(TemporaryToken::class);
    }


    public function tokens()
    {
        return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function personalSorting(): HasMany
    {
        return $this->hasMany(PersonalSorting::class);
    }

    public function favorites(Favorites $type): BelongsToMany
    {
        $models = [
            Favorites::Salon->value => Salon::class,
            Favorites::Service->value => Service::class,
            Favorites::Staff->value => Staff::class,
        ];
        return $this->belongsToMany($models[$type->value], $type->value . '_favorite');
    }

    public function reviewMarks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'review_likes')
            ->withPivot('type', 'review_id');
    }

    public function reviewLikes(): BelongsToMany
    {
        return $this->reviewMarks()->where('type', 1);
    }

    public function reviewDislikes(): BelongsToMany
    {
        return $this->reviewMarks()->where('type', 2);
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name
        ];
    }


}
