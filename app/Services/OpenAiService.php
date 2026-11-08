<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAiService
{
    protected string $apiKey;

    protected string $chatModel;

    public function __construct()
    {
        $this->apiKey    = (string) config('services.openai.api_key');
        $this->chatModel = (string) config('services.openai.model', 'gpt-4o-mini');
    }

    /**
     * Transcribe an audio file to text using OpenAI Whisper API.
     */
    public function transcribeAudio(string $absoluteAudioPath): string
    {
        if (! file_exists($absoluteAudioPath)) {
            throw new Exception("Audio file not found at: {$absoluteAudioPath}");
        }

        if (empty($this->apiKey)) {
            throw new Exception('OPENAI_API_KEY is not configured in .env');
        }

        $response = Http::withToken($this->apiKey)
            ->timeout(120)
            ->attach(
                'file',
                file_get_contents($absoluteAudioPath),
                basename($absoluteAudioPath)
            )
            ->post('https://api.openai.com/v1/audio/transcriptions', [
                'model'           => 'whisper-1',
                'language'        => 'en',
                'response_format' => 'json',
            ]);

        if (! $response->successful()) {
            Log::error('OpenAI Whisper Transcription Error: ' . $response->body());
            throw new Exception('Whisper Transcription Error: ' . $response->body());
        }

        return (string) ($response->json()['text'] ?? '');
    }

    /**
     * Generate reflection insights with 100% strict JSON schema output.
     *
     * @return array<string, mixed>
     */
    public function generateInsights(string $transcript): array
    {
        if (empty($this->apiKey)) {
            throw new Exception('OPENAI_API_KEY is not configured in .env');
        }

        $jsonSchema = [
            'type'                 => 'object',
            'properties'           => [
                'title'                    => [
                    'type'        => 'string',
                    'description' => 'A short, gentle, 2-5 word title summarizing the spoken reflection (e.g., Finding Peace in the Chaos, Overcoming Morning Overwhelm).',
                ],
                'mood'                     => [
                    'type'        => 'string',
                    'description' => 'Detected primary emotional mood (e.g., Calm, Overwhelmed, Hopeful, Grateful, Anxious, Focused).',
                ],
                'summary'                  => [
                    'type'        => 'string',
                    'description' => 'Compassionate, insightful 2-4 sentence summary of the reflection.',
                ],
                'emotional_patterns'       => [
                    'type'        => 'array',
                    'description' => 'Exactly 5 key emotion levels with intensity and percentage.',
                    'items'       => [
                        'type'                 => 'object',
                        'properties'           => [
                            'name'  => ['type' => 'string', 'description' => 'Emotion name (e.g. Overwhelm, Letting Go, Anxiety, Confidence, Peace)'],
                            'level' => ['type' => 'string', 'enum' => ['Low', 'Medium', 'High']],
                            'score' => ['type' => 'integer', 'description' => 'Intensity percentage between 0 and 100'],
                        ],
                        'required'             => ['name', 'level', 'score'],
                        'additionalProperties' => false,
                    ],
                ],
                'themes_detected'          => [
                    'type'        => 'array',
                    'description' => '4 to 5 mindfulness and personal growth themes identified from the speech.',
                    'items'       => ['type' => 'string'],
                ],
                'growth_narrative'         => [
                    'type'        => 'string',
                    'description' => 'A one-sentence encouraging statement about the user\'s progress and self-awareness.',
                ],
                'growth_score'             => [
                    'type'        => 'integer',
                    'description' => 'Growth and self-awareness index score between 1 and 100.',
                ],
                'personalized_affirmation' => [
                    'type'        => 'string',
                    'description' => 'An empowering first-person affirmation statement.',
                ],
                'recommended_next_step'    => [
                    'type'        => 'string',
                    'description' => 'A gentle, actionable mindfulness next step recommendation.',
                ],
            ],
            'required'             => [
                'title',
                'mood',
                'summary',
                'emotional_patterns',
                'themes_detected',
                'growth_narrative',
                'growth_score',
                'personalized_affirmation',
                'recommended_next_step',
            ],
            'additionalProperties' => false,
        ];

        $response = Http::withToken($this->apiKey)
            ->timeout(120)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model'           => $this->chatModel,
                'messages'        => [
                    [
                        'role'    => 'system',
                        'content' => 'You are an empathetic, insightful voice journaling mindfulness companion and emotional health coach. Analyze user reflections and return structured psychological insights adhering strictly to the JSON schema.',
                    ],
                    [
                        'role'    => 'user',
                        'content' => "Here is the user's spoken voice reflection transcript:\n\n\"{$transcript}\"",
                    ],
                ],
                'response_format' => [
                    'type'        => 'json_schema',
                    'json_schema' => [
                        'name'   => 'reflection_analysis',
                        'strict' => true,
                        'schema' => $jsonSchema,
                    ],
                ],
            ]);

        if (! $response->successful()) {
            Log::error('OpenAI Insights Generation Error: ' . $response->body());
            throw new Exception('OpenAI Insights Error: ' . $response->body());
        }

        $content = $response->json()['choices'][0]['message']['content'] ?? '{}';

        return json_decode($content, true) ?: [];
    }
}
