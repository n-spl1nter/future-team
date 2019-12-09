<?php

namespace App\Entities;

use App\Events\SendMail;
use App\Notifications\Auth\PasswordResetNotification;
use App\Notifications\Auth\RegistrationNotification;
use App\Notifications\Main\MessageToUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\RBAC\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Http\UploadedFile;
use function Symfony\Component\Debug\Tests\testHeader;

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
 * @property string|null $organization_name
 * @property int|null $organization_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Action[] $actions
 * @property-read int|null $actions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \App\Entities\CompanyProfile $companyProfile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Event[] $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Goal[] $goals
 * @property-read int|null $goals_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Action[] $joinedActions
 * @property-read int|null $joined_actions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Language[] $knownLanguages
 * @property-read int|null $known_languages_count
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Language[] $wouldLikeToLearnLanguages
 * @property-read int|null $would_like_to_learn_languages_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereOrganizationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Entities\User|null $organization
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\EmailMessage[] $sentEmailMessages
 * @property-read int|null $sent_email_messages_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User companies()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\User[] $organizationMembers
 * @property-read int|null $organization_members_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Activity[] $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\User members()
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens, Sortable, HasImage;

    private $avatar = null;

    protected $fillable = ['email', 'password'];
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'email_verified_at', 'role_id', 'email',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public $sortable = ['id', 'email', 'role_id'];

    public function scopeActive(Builder $builder)
    {
        return $builder->whereNotNull('email_verified_at');
    }

    public function scopeCompanies(Builder $builder)
    {
        return $builder->where('role_id', '=', Role::COMPANY);
    }

    public function scopeMembers(Builder $builder)
    {
        return $builder->where('role_id', '=', Role::MEMBER);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function socialNetworks()
    {
        return $this->hasMany(SocialNetwork::class, 'user_id', 'id');
    }

    public function oauthAccessTokens()
    {
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

    public function actions()
    {
        return $this->hasMany(Action::class, 'user_id', 'id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'user_id', 'id');
    }

    public function joinedActions()
    {
        return $this->belongsToMany(Action::class, 'users_to_actions', 'user_id', 'action_id');
    }

    public function organization()
    {
        return $this->belongsTo(self::class, 'organization_id', 'id');
    }

    public function organizationMembers()
    {
        return $this->hasMany(self::class, 'organization_id', 'id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'user_id', 'id');
    }

    public function sentEmailMessages()
    {
        return $this->hasMany(EmailMessage::class, 'user_id_from', 'id');
    }

    public function isCompany(): bool
    {
        return in_array($this->role_id, [Role::COMPANY]);
    }

    public function isMember(): bool
    {
        return in_array($this->role_id, [Role::MEMBER, Role::MODERATOR, Role::ADMIN]);
    }

    public function hasFilledProfile(): bool
    {
        return ($this->isMember() && $this->profile)
            || ($this->isCompany() && $this->companyProfile);
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
            && User::whereRoleId(Role::COMPANY)->where('id', $organizationId)->first()
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
        if ($request->has('goals')) {
            $this->goals()->sync($request->get('goals'));
        }
        return  $this;
    }

    public function setAvatar(UploadedFile $file = null): self
    {
        if (!$file) {
            return $this;
        }
        MediaFile::removeFile(static::class, $this->id, MediaFile::TYPE_AVATAR);
        $this->setImage($file, MediaFile::TYPE_AVATAR, 640, 240);
        return $this;
    }

    public function getAvatar()
    {
        if (empty($this->avatars)) {
            $avatar = $this->getImage(MediaFile::TYPE_AVATAR);
            if ($avatar) {
                $this->avatar = $avatar->url;
            }
        }

        return $this->avatar;
    }

    public function sendEmailVerificationNotificationOnRegister(string $password): void
    {
        $this->notify(new RegistrationNotification($password));
    }

    public static function makeFromEmail(Request $request): self
    {
        $user = null;
        \DB::transaction(function () use ($request, &$user) {
            $userType = $request->get('type');
            $password = Str::random(8);
            $user = new self();
            $user->email = $request->get('email');
            $user->email_verified_at = now();
            $user->setRole($userType === 'member' ? Role::MEMBER : Role::COMPANY)
                ->setPassword($password)
                ->save();
            if ($user->isMember()) {
                $user->setProfile($request);
            } else {
                $user->setCompanyProfile($request);
            }
            $user->sendEmailVerificationNotificationOnRegister($password);
        });

        event(new Registered($user));
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
            $user->setRole(Role::MEMBER)->save();
            $user->socialNetworks()
                ->create(array_merge(['service' => $serviceName], $attributes))
                ->save();
        }

        return $user;
    }

    public function toArray()
    {
        $userData = [
            'type' => $this->role->name,
            'avatar' => $this->getAvatar(),
            'id' => $this->id,
        ];
        if ($this->isMember() && $this->profile) {
            $userData['full_name'] = $this->profile->full_name;
            $userData['city'] = $this->profile->city;

        } elseif ($this->isCompany() && $this->companyProfile) {
            $userData['full_name'] = $this->companyProfile->full_name;
            $userData['country'] = $this->companyProfile->country;
        }
        if (Arr::has($this->relations, 'wouldLikeToLearnLanguages')) {
            $userData['wouldLikeToLearnLanguages'] = $this->relations['wouldLikeToLearnLanguages'];
        }
        if (Arr::has($this->relations, 'knownLanguages')) {
            $userData['knownLanguages'] = $this->relations['knownLanguages'];
        }
        return $userData;
    }

    public function getPublicProfile(): array
    {
        $data = [
            'type' => $this->role->name,
            'avatar' => $this->getAvatar(),
            'goals' => $this->goals->toArray(),
            'actions' => [
                'items' => $this->actions()->limit(3)->get()->toArray(),
                'totalCount' => $this->actions()->count(),
            ],
            'events' => [
                'items' => $this->events()->limit(3)->get()->toArray(),
                'totalCount' => $this->events()->count(),
            ],
        ];

        if ($this->isMember() && $this->profile) {
            $data = array_merge(
                $data,
                $this->profile->toArray()
            );
            if ($this->profile->isAgreeToLanguageExchange()) {
                $data = array_merge(
                    $data,
                    [
                        'known_languages' => $this->knownLanguages->toArray(),
                        'would_like_to_learn_languages' => $this->wouldLikeToLearnLanguages->toArray(),
                    ]
                );
            }
            if ($this->organization) {
                $data['organization'] = $this->organization->toArray();
            } elseif ($this->organization_name) {
                $data['organization_name'] = $this->organization_name;
            }
        } elseif ($this->isCompany() && $this->companyProfile) {
            $data = array_merge(
                $data,
                $this->companyProfile->getPublicProfile()
            );
        }

        return $data;
    }

    public function getAccountInfo(): array
    {
        $data = [
            'email' => $this->email,
            'type' => $this->role->name,
            'avatar' => $this->getAvatar(),
        ];
        $this->load(['profile', 'knownLanguages', 'wouldLikeToLearnLanguages', 'companyProfile', 'goals']);
        if ($this->isMember() && $this->profile) {
            $data = array_merge(
                $data,
                $this->profile->toArray(),
                [
                    'known_languages' => $this->knownLanguages->toArray(),
                    'would_like_to_learn_languages' => $this->wouldLikeToLearnLanguages->toArray(),
                ]
            );
            if ($this->organization) {
                $data['organization'] = $this->organization->toArray();
            } elseif ($this->organization_name) {
                $data['organization_name'] = $this->organization_name;
            }
        } elseif ($this->isCompany() && $this->companyProfile) {
            $data = array_merge($data, $this->companyProfile->toArray());
        }

        return array_merge($data, [
            'goals' => $this->goals->toArray(),
        ]);
    }

    public function makeToken()
    {
        return $this->createToken('FutureTeam');
    }

    public function setProfile(Request $request)
    {
        $profile = $this->profile;
        if (!$profile) {
            $profile = new Profile($request->all());
        } else {
            $profile->update($request->all());
        }
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

    public function setCompanyProfile(Request $request)
    {
        $companyProfile = $this->companyProfile;
        if (!$companyProfile) {
            $companyProfile = new CompanyProfile($request->all());
            $companyProfile->full_name = $request->get('full_name');
        } else {
            $companyProfile->update($request->all());
        }
        $orgTypeId = $request->get('organization_type_id', null);
        $orgTypeValue = $request->get('organization_type');
        if ($orgTypeId) {
            $companyProfile->organization_type_id = $orgTypeId;
            $companyProfile->organization_type = null;
        } else {
            $companyProfile->organization_type_id = null;
            $companyProfile->organization_type = $orgTypeValue;
        }
        $this->setGoals($request)
            ->setAvatar($request->file('photo'))
            ->companyProfile()
            ->save($companyProfile);
    }

    public function sendMessageToUser(User $user, string $text)
    {
        if ($user->id === $this->id) {
            throw new \DomainException(__('common.InvalidRecipient'));
        }
        $attributes = [
            'user_id_to' => $user->id,
            'message' => $text,
        ];
        /** @var EmailMessage $sentEmail */
        $sentEmail = $this->sentEmailMessages()->create($attributes);
        $user->notify(new MessageToUserNotification($sentEmail));
        event(new SendMail($sentEmail));
    }

    public function getFullName()
    {
        if ($this->isMember() && $this->profile) {
            return $this->profile->full_name;
        } elseif ($this->isCompany() && $this->companyProfile) {
            return $this->companyProfile->full_name;
        }
        return '';
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }
}
