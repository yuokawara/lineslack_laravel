<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LineFriend
 * @package App\Models
 *
 * @property int $id
 * @property string $line_id
 * @property string $display_name
 */

class LineFriend extends Model
{
    use HasFactory;
    protected $fillable = ['line_id', 'display_name'];
}
