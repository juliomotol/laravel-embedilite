<?php

namespace JulioMotol\Embedilite;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use JulioMotol\Embedilite\Concerns\ConfiguresEmbed;
use JulioMotol\Embedilite\Models\Embed;

trait InteractsWithEmbed
{
    use ConfiguresEmbed;

    public function embed(): MorphMany
    {
        return $this->morphMany(config('embedilite.model'), 'model');
    }

    public function addEmbed(string $source, string $provider, array $options = [])
    {
        $options = array_merge($this->getEmbedOptions($provider), $options);

        EmbediliteFacade::from($provider)::validateSource($source);

        $this->embed()->create([
            'source' => $source,
            'provider' => $provider,
            'options' => $options,
        ]);
    }

    public function hasEmbed(string $provider = null): bool
    {
        return count($this->getEmbed($provider)) ? true : false;
    }

    public function getEmbed(string $provider = null): ?Collection
    {
        $query = $this->embed();

        if ($provider) {
            $query->whereProvider($provider);
        }

        return $query->get();
    }

    public function getFirstEmbed($provider = null): ?Embed
    {
        return $this->getEmbed($provider)->first();
    }

    public function deleteEmbed($embedId): void
    {
        if ($embedId instanceof Embed) {
            $embedId = $embedId->getKey();
        }

        $embed = $this->embed()->find($embedId);

        if (!$embed) {
            throw new \Exception('embed does not belong to this model');
        }

        $embed->delete();
    }

    public function clearEmbed($provider = null): void
    {
        $this->getEmbed($provider)->each(fn (Embed $embed) => $embed->delete());
    }
}
