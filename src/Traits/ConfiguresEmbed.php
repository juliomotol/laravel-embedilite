<?php

namespace JulioMotol\Embedilite\Traits;

use JulioMotol\Embedilite\Support\EmbedOption;

trait ConfiguresEmbed
{
    /**
     * The configured embed options.
     *
     * @var EmbedOption[]
     */
    protected array $embedOptions = [];

    /**
     * Add an embed option.
     *
     * @param string $provider
     * @return EmbedOption
     */
    public function addEmbedOption(string $provider): EmbedOption
    {
        return tap(
            EmbedOption::create($provider),
            fn ($embedOption) => $this->embedOptions[] = $embedOption
        );
    }

    /**
     * Register embed options.
     *
     * @return void
     */
    public function registerEmbedOptions(): void
    {
    }

    /**
     * Get an embed option for a certain provider
     *
     * @param string $provider
     * @return EmbedOption|null
     */
    public function getEmbedOptions(string $provider): ?EmbedOption
    {
        $this->registerEmbedOptions();

        return collect($this->embedOptions)
            ->first(fn (EmbedOption $embedOption) => $embedOption->provider === $provider);
    }
}
