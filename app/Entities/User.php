<?php

namespace App\Entities;

use App\Notifications\Auth\RegistrationNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\RBAC\Role;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Illuminate\Http\UploadedFile;

/**
 * App\Entities\User
 *
 * @property int $id
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $role_id
 * @property string $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \App\Entities\CompanyProfile $companyProfile
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OauthAccessToken[] $oauthAccessTokens
 * @property-read int|null $oauth_access_tokens_count
 * @property-read \App\Entities\Profile $profile
 * @property-read \App\RBAC\Role $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\SocialNetwork[] $socialNetworks
 * @property-read int|null $social_networks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $organization_name
 * @property int|null $organization_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereOrganizationName($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Language[] $knownLanguages
 * @property-read int|null $known_languages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Language[] $wouldLikeToLearnLanguages
 * @property-read int|null $would_like_to_learn_languages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Goal[] $goals
 * @property-read int|null $goals_count
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    const TYPE_COMPANY = 'company';
    const TYPE_MEMBER = 'member';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'email_verified_at', 'role_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function socialNetworks()
    {
        return $this->hasMany(SocialNetwork::class, 'user_id', 'id');
    }

    public function oauthAccessTokens(){
        return $this->hasMany(OauthAccessToken::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function companyProfile()
    {
        return $this->hasOne(CompanyProfile::class, 'user_id', 'id');
    }

    public function knownLanguages()
    {
        return $this->belongsToMany(Language::class, 'known_languages', 'user_id', 'language_id');
    }

    public function wouldLikeToLearnLanguages()
    {
        return $this->belongsToMany(Language::class, 'languages_wltl', 'user_id', 'language_id');
    }

    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'users_to_goals', 'user_id', 'goal_id');
    }

    public function isCompany(): bool
    {
        return $this->type === self::TYPE_COMPANY;
    }

    public function isMember(): bool
    {
        return $this->type === self::TYPE_MEMBER;
    }


    /**
     * Проверяет, имеет ли пользователь права
     * @param string|string[] $permission - название разрешения или массив разрешений
     * @param bool $require - должен иметь все права или только 1 право из массива
     * @return bool
     */
    public function canDo($permission, $require = false): bool
    {
        if (is_array($permission)) {
            foreach ($permission as $permName) {
                $permRes = $this->canDo($permName);
                if($permRes && !$require){
                    return true;
                } else if (!$permRes && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->role->permissions as $perm) {
                if(Str::is($permission, $perm->name)) {
                    return true;
                }
            }
            return false;
        }
    }

    public function setRole(int $roleId)
    {
        $this->role_id = $roleId;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = \Hash::make($password);
        return $this;
    }

    public function setOrganization(Request $request): self
    {
        $organizationId = $request->get('organization_id', null);
        if ($this->isCompany()) {
            throw new \DomainException('Company can\'t have organization');
        }
        if (
            $organizationId
            && User::whereType(static::TYPE_COMPANY)->where('id', $organizationId)->first()
        ) {
            $this->organization_id = $organizationId;
            $this->organization_name = null;
        } elseif (!empty($request->get('organization_name'))) {
            $this->organization_id = null;
            $this->organization_name = $request->get('organization_name');
        }
        if ($this->isDirty()) {
            $this->save();
        }

        return $this;
    }

    public function setGoals(Request $request): self
    {
        $this->goals()->sync($request->get('goals'));
        return  $this;
    }

    public function setAvatar(UploadedFile $file): self
    {
        list($fullFileName, $smallFileName) = MediaFile::createFileNameByFileType($file, MediaFile::TYPE_AVATAR);
        $image = \Image::make($file);
        $image
            ->fit(600)
            ->save(storage_path('app/public/') . $fullFileName, 75)
            ->fit(180)
            ->save(storage_path('app/public/') . $smallFileName);

        MediaFile::addImage($fullFileName, static::class, $this->id, MediaFile::TYPE_AVATAR);
        MediaFile::addImage($smallFileName, static::class, $this->id, MediaFile::TYPE_AVATAR_SMALL);
        return $this;
    }

    public function getAvatar()
    {
        $avatars = MediaFile::whereEntity(self::class)
            ->whereEntityId($this->id)
            ->whereIn('file_type', [MediaFile::TYPE_AVATAR, MediaFile::TYPE_AVATAR_SMALL])
            ->get();

        return $avatars;
    }

    public function sendEmailVerificationNotificationOnRegister(string $password): void
    {
        $this->notify(new RegistrationNotification($password));
    }

    public static function makeFromEmail(array $attributes): self
    {
        $password = Str::random(8);
        $user = new self();
        $user->email = $attributes['email'];
        $user->type = $attributes['type'];
        $user->email_verified_at = now();
        $user->setRole(Role::USER)
            ->setPassword($password)
            ->save();
        $user->sendEmailVerificationNotificationOnRegister($password);
        return $user;
    }

    public static function findOrCreateViaNetworkService(string $serviceName, array $attributes): self
    {
        $user = self::whereHas('socialNetworks', function (Builder $query) use ($serviceName, $attributes) {
            $query->where('service', $serviceName);
            $query->where('identity', $attributes['identity']);
        })->first();
        if (!$user) {
            $user = new self();
            if (!empty($attributes['email'])) {
                $user->email = $attributes['email'];
                $user->email_verified_at = now();
            }
            $user->setRole(Role::USER)->save();
            $user->socialNetworks()
                ->create(array_merge(['service' => $serviceName], $attributes))
                ->save();
        }

        return $user;
    }

    public function getAccountInfo(): array
    {
        $data = [
            'email' => $this->email,
            'type' => $this->type,
            'avatar' => $this->getAvatar(),
        ];
        $this->load(['profile', 'knownLanguages', 'wouldLikeToLearnLanguages', 'companyProfile']);
        if ($this->isMember() && $this->profile) {
            $data = array_merge(
                $data,
                $this->profile->toArray(),
                [
                    'known_languages' => $this->knownLanguages->toArray(),
                    'would_like_to_learn_languages' => $this->wouldLikeToLearnLanguages->toArray(),
                ]
            );
        } elseif ($this->isCompany() && $this->companyProfile) {
            $data = array_merge($data, $this->companyProfile->toArray());
        }

        return $data;
    }

    public function makeToken()
    {
        return $this->createToken('FutureTeam');
    }

    public function setProfile(Request $request)
    {
        $profile = new Profile($request->all());
        $profile->setBirthDate($request->get('birth_date_at'));
        if ($request->has('languages_wltl')) {
            $this->wouldLikeToLearnLanguages()->sync($request->get('languages_wltl'));
        }
        if ($request->has('known_languages')) {
            $this->knownLanguages()->sync($request->get('known_languages'));
        }
        $this->setOrganization($request)
            ->setGoals($request)
            ->setAvatar($request->file('photo'))
            ->profile()
            ->save($profile);
        $this->save();
    }

    public function updateProfile(Request $request)
    {

    }
}
