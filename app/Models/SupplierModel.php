<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierModel extends Model
{
    use HasFactory;

    protected $table = 'm_supplier';
    protected $primaryKey = 'supplier_id';
    protected $fillable = [
        'supplier_nama',
        'kontak',
        'alamat'
    ];

    public function barang(): HasMany
    {
        return $this->hasMany(BarangModel::class, 'supplier_id', 'supplier_id');
    }
}
