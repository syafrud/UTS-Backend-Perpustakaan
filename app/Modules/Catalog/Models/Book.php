<?php

namespace App\Modules\Catalog\Models;

use App\Modules\Catalog\Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['category_id', 'title', 'isbn', 'publisher', 'published_year', 'stock'])]
#[UseFactory(BookFactory::class)]
class Book extends Model
{
    use HasFactory;

    public const AUTHOR_MAIN = 'utama';

    public const AUTHOR_CO = 'pendamping';

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** Many-to-Many dengan pivot: kolom role = penulis utama / pendamping. */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class)->withPivot('role')->withTimestamps();
    }

    /** Penulis pertama = utama, sisanya pendamping. */
    public function syncAuthors(array $authorIds): void
    {
        $this->authors()->sync(collect(array_values($authorIds))->mapWithKeys(
            fn ($id, $i) => [$id => ['role' => $i === 0 ? self::AUTHOR_MAIN : self::AUTHOR_CO]]
        )->all());
    }
}
