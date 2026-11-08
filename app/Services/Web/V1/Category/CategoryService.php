<?php

namespace App\Services\Web\V1\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryService
{
    /**
     * Create a new category.
     */
    public function create(array $data): Model | Builder
    {
        $categoryData = [
            'name'   => $data['name'],
            'slug'   => ! empty($data['slug']) ? Str::slug($data['slug']) : $this->generateUniqueSlug($data['name']),
            'status' => $data['status'] ?? 'active',
        ];

        return Category::query()->create($categoryData);
    }

    /**
     * Update an existing category.
     */
    public function update(int $id, array $data): Model | Collection | Builder | array | null
    {
        $category = Category::query()->findOrFail($id);

        $categoryData = [
            'name'   => $data['name'],
            'status' => $data['status'] ?? $category->status,
        ];

        if (! empty($data['slug'])) {
            $categoryData['slug'] = Str::slug($data['slug']);
        } elseif ($data['name'] !== $category->name) {
            $categoryData['slug'] = $this->generateUniqueSlug($data['name'], $category->id);
        }

        $category->update($categoryData);

        return $category->fresh();
    }

    /**
     * Generate a unique slug for a category.
     */
    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug    = Str::slug($name);
        $base    = $slug;
        $counter = 1;

        while (
            Category::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
