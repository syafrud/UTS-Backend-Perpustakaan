<?php

namespace App\Modules\Catalog\Models;

use App\Modules\Catalog\Database\Factories\AuthorFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'bio'])]
#[UseFactory(AuthorFactory::class)]
class Author extends Model
{
    use HasFactory;

    /** Many-to-Many via pivot author_book. */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)->withPivot('role')->withTimestamps();
    }
}
