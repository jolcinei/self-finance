<?php

namespace App\Models;

use App\Enums\CategoriaOperacaoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Categoria extends Model
{
    use HasFactory;


    protected $fillable = [
        'nome', 'descricao', 'operacao', 'parent_id'
    ];

    protected $casts = [
        'operacao' => CategoriaOperacaoEnum::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Categoria::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Categoria::class, 'parent_id')->orderBy('id', 'asc');
    }

}
