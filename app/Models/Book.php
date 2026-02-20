<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'book_id',
        'title',
        'author',
        'publisher',
        'status'
    ];

    public function issues()
    {
        return $this->hasMany(BookIssue::class);
    }

    public function currentIssue()
    {
        return $this->hasOne(BookIssue::class)->where('status', 'issued')->latest();
    }
}
