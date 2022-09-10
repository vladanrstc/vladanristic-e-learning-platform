<?php

namespace App\Traits;

trait UserAttributes {

    public static function name() {
        return "name";
    }

    public static function lastName() {
        return "last_name";
    }

    public static function email() {
        return "email";
    }

    public static function password() {
        return "password";
    }

    public static function emailVerifiedAt() {
        return "email_verified_at";
    }

    public static function role() {
        return "role";
    }

    public static function rememberToken() {
        return "remember_token";
    }

    public static function language() {
        return "language";
    }

    public static function createdAt() {
        return "created_at";
    }

    public static function updatedAt() {
        return "updated_at";
    }

    public static function deletedAt() {
        return "deleted_at";
    }

}
