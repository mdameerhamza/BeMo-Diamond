<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
    ];
    public function cards()
    {
        return $this->hasMany(Card::class)->orderBy('index');
    }
    public function delete()
    {
        // delete all related cards 
        $this->cards()->delete();
        // it's an uglier alternative, but faster
        // Card::where("column_id", $this->id)->delete()
        // delete the user
        return parent::delete();
    }
}
