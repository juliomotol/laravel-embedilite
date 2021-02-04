<?php

namespace JulioMotol\Embedilite\Support;

class EmbedOption
{
    /**
     * The embed provider.
     *
     * @var string
     */
    public string $provider = '';

    /**
     * The options for the embed provider.
     *
     * @var string
     */
    public array $options = [];

    /**
     * Create a new instance.
     *
     * @param string $provider
     */
    public function __construct(string $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Create a new instance.
     *
     * @param string $provider
     * @return self
     */
    public static function create(string $provider): self
    {
        return new static($provider);
    }

    /**
     * Set embed options
     *
     * @param array $options
     * @return self
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }
}
