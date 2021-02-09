<?php

namespace JulioMotol\Embedilite;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use JulioMotol\Embedilite\Concerns\ConfiguresEmbed;
use JulioMotol\Embedilite\Models\Embed;

trait InteractsWithEmbed
{
    use ConfiguresEmbed;

    /**
     * Get the related embed models.
     *
     * @return MorphMany
     */
    public function embed(): MorphMany
    {
        return $this->morphMany(config('embedilite.model'), 'model');
    }

    /**
     * Add an embed to this model.
     *
     * @param string $source
     * @param string $provider
     * @param array $options
     * @return Embed
     */
    public function addEmbed(string $source, string $provider, array $options = []): Embed
    {
        $options = array_merge($this->getEmbedOptions($provider), $options);

        EmbediliteFacade::from($provider)::validateSource($source);

        return $this->embed()->create([
            'source' => $source,
            'provider' => $provider,
            'options' => $options,
        ]);
    }

    /**
     * Check if this model has embed.
     *
     * @param string|null $provider
     * @return bool
     */
    public function hasEmbed(?string $provider): bool
    {
        return count($this->getEmbed($provider)) ? true : false;
    }

    /**
     * Get the embeds of this model.
     *
     * @param string|null $provider
     * @return Collection|null
     */
    public function getEmbed(?string $provider): ?Collection
    {
        $query = $this->embed();

        if ($provider) {
            $query->whereProvider($provider);
        }

        return $query->get();
    }

    /**
     * Get the first embed of this model
     *
     * @param string|null $provider
     * @return Embed|null
     */
    public function getFirstEmbed(?string $provider): ?Embed
    {
        return $this->getEmbed($provider)->first();
    }

    /**
     * Delete an embed of this model.
     *
     * @param int|Embed $embedId
     * @return void
     */
    public function deleteEmbed($embedId): void
    {
        if ($embedId instanceof Embed) {
            $embedId = $embedId->getKey();
        }

        $embed = $this->embed()->find($embedId);

        if (! $embed) {
            throw new \Exception('embed does not belong to this model');
        }

        $embed->delete();
    }

    /**
     * Clear all the embed of this model.
     *
     * @param string|null $provider
     * @return void
     */
    public function clearEmbed(?string $provider): void
    {
        $this->getEmbed($provider)->each(fn (Embed $embed) => $embed->delete());
    }
}
