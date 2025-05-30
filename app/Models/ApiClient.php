<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class ApiClient extends Model implements JWTSubject
{
    protected $fillable = ['name', 'public_key', 'secret_key', 'allowed_domains', 'is_active'];

    protected static function booted()
    {
        static::creating(function ($client) {
            $client->public_key = (string) Str::uuid();
            $client->secret_key = Str::random(64);
        });
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
