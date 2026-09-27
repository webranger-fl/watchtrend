<?php

namespace Tests\Feature;

use App\Models\WordstatPhrase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WordstatPhraseSlugTest extends TestCase
{
    use RefreshDatabase;

    public function test_slug_resolution_prefers_exact_phrase_and_requires_id_for_other_collisions(): void
    {
        $latinPhrase = WordstatPhrase::create(['phrase' => 'seo', 'slug' => 'seo']);
        $cyrillicPhrase = WordstatPhrase::create(['phrase' => 'сео', 'slug' => 'seo']);

        $this->assertSame($latinPhrase->id, WordstatPhrase::resolveSlug('seo')->id);
        $this->assertSame($cyrillicPhrase->id, WordstatPhrase::resolveSlug('seo', $cyrillicPhrase->id)->id);
        $this->assertSame(['slug' => 'seo'], $latinPhrase->keyRouteParameters());
        $this->assertSame(['slug' => 'seo', 'id' => $cyrillicPhrase->id], $cyrillicPhrase->keyRouteParameters());
    }

    public function test_analyze_redirects_to_the_submitted_phrase_when_its_slug_collides(): void
    {
        WordstatPhrase::create(['phrase' => 'seo', 'slug' => 'seo']);
        $cyrillicPhrase = WordstatPhrase::create(['phrase' => 'сео', 'slug' => 'seo']);

        $response = $this->post(route('analyze'), ['keyword' => 'сео']);

        $response->assertRedirect(route('key', $cyrillicPhrase->keyRouteParameters()));
    }
}
