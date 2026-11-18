<?php

namespace App\Modules\Catalog\Models;

use App\Modules\Catalog\Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description'])]
#[UseFactory(CategoryFactory::class)]
class Category extends Model
{
    use HasFactory;

    /** One-to-Many: satu kategori punya banyak buku. */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
