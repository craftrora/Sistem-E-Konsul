<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketCounter extends Model
{
    protected $table = 'ticket_counters';
    protected $primaryKey = 'tahun';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = ['tahun', 'nomor_terakhir'];

    protected function casts(): array
    {
        return [
            'tahun'          => 'integer',
            'nomor_terakhir' => 'integer',
        ];
    }
}
