<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'book_id',
        'title',
        'author_id',
        'publisher_id',
        'status'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function issues()
    {
        return $this->hasMany(BookIssue::class);
    }

    public function currentIssue()
    {
        return $this->hasOne(BookIssue::class)->where('status', 'issued')->latest();
    }
}