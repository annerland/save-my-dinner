<?php

namespace App\Services;

use GuzzleHttp\Client;

class OpenAIService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . env(key: 'OPENAI_API_KEY'),
                'Content-Type' => 'application/json'
            ],
            'timeout' => 30,
        ]);
    }

    public function generateRecipe($ingredients)
    {
        $response = $this->client->post('responses', [
            'json' => [
                'model' => 'gpt-4o-mini-2024-07-18',
                'input' => 'Generate an existing recipe using the following ingredients and create a creative title for that: ' . implode(', ', $ingredients),
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['output'][0]['content'][0] ?? 'An Error Ocurred while generating a recipe';
    }
}