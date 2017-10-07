<?php

namespace App\Models;

use Mail;
use Redis;

class LoginToken
{
    public $user;
    public function __construct(User $user, string $token = null)
    {
        $this->user = $user;
        $this->token = $token ?? str_random(64);
    }

    public function create(): self
    {
        Redis::set("login:token:{$this->token}", $this->user->id, 'EX', 15*60*60);
        return $this;
    }

    public function delete(): self
    {
        Redis::del("login:token:{$this->token}");
        return $this;
    }

    public function email(): self
    {
        $url = route('login.token', [
            'token' => $this->token
        ]);

        Mail::send('auth.emails.login', ['url' => $url], function ($m) {
            $m->to($this->user->email)->subject('Magic sign-in link for '.config('app.name'));
        });

        return $this;
    }

    private static function unsafeCheck(string $token): self
    {
        $id = Redis::get("login:token:$token");
        if (!$id) {
            throw new \Exception('Token expired');
        }

        $user = User::findOrFail($id);
        if (!$user) {
            throw new \Exception('Token invalid');
        }

        return new self($user, $token);
    }

    public static function check(string $token): self
    {
        $start = microtime(true);
        $max = $start + 0.25;

        try {
            $ret = static::unsafeCheck($token);
        } catch (\Throwable $e) {
            $ret = $e;
        }

        $delay = $max - microtime(true);
        if ($delay > 0) {
            usleep($delay);
        }

        if ($ret instanceof \Throwable) {
            throw $ret;
        }
        return $ret;
    }
}
