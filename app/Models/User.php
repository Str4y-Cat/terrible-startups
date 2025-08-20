<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function withDemoData(): User
    {


        $ideas = require database_path('seeders/data/ideas.php');
        $tagOptions = require database_path('seeders/data/tags.php');

        //create the default tags
        foreach ($tagOptions as $key => $values) {
            foreach ($values as $value) {
                $this->tags()->create([
                    'key' => $key,
                    'value' => $value,
                ]);
            }
        }

        //create dummy ideas attached to user
        foreach ($ideas as $idea) {
            $createdIdea = $this->ideas()->create($idea);

            //create dummy tags attached to user
            /* //create dummy tags attached to user */
            foreach ($tagOptions as $key => $value) {

                $tag = $this->tags()->where('key', $key)->inRandomOrder()->first();

                $createdIdea->tags()->attach($tag->id);
            }
        }

        return $this;
    }


    public function ideas(): HasMany
    {
        return $this->hasMany(Idea::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
