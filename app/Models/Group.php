<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

 
    public function users()
{
    return $this->belongsToMany(User::class, 'group_user')
                ->withPivot('role', 'joined_at')
                ->withTimestamps();
}
}
