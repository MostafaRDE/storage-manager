<?php

namespace MostafaRDE\StorageManager\Models;

use Illuminate\Database\Eloquent\Model;

class StorageLink extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = [
        'linkable_type', 'linkable_id', 'linkable_caller_name'
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'linkable_caller_name', 'storage',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'file',
    ];

    /**
     * Get all of the owning linkable models.
     */
    public function linkable()
    {
        return $this->morphTo();
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    /*
     * Accessors and Mutators
     */
    public function getFileAttribute()
    {
        return $this->storage;
    }
}