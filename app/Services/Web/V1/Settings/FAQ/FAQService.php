<?php

namespace App\Services\Web\V1\Settings\FAQ;

use App\Models\FAQ;

class FAQService
{
    /**
     * Create a new FAQ record.
     *
     * @param  array<string, mixed>  $data
     * @return \App\Models\FAQ
     */
    public function create(array $data): FAQ
    {
        return FAQ::query()->create([
            'question' => $data['question'],
            'answer'   => $data['answer'],
            'status'   => $data['status'] ?? 'active',
        ]);
    }

    /**
     * Update an existing FAQ record.
     *
     * @param  int                   $id
     * @param  array<string, mixed>  $data
     * @return \App\Models\FAQ
     */
    public function update(int $id, array $data): FAQ
    {
        $faq = FAQ::query()->findOrFail($id);

        $payload = [
            'question' => $data['question'],
            'answer'   => $data['answer'],
            'status'   => $data['status'] ?? $faq->status,
        ];

        $faq->update($payload);

        return $faq->fresh();
    }
}
