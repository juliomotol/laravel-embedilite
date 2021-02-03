<?php

namespace JulioMotol\Embedilite\Providers;

use Illuminate\Support\Str;
use InvalidArgumentException;
use JulioMotol\Embedilite\Contracts\Provider as ProviderContract;
use JulioMotol\Embedilite\Exceptions\InvalidEmbedSource;

abstract class Provider implements ProviderContract
{
    /**
     * The embed provider name.
     *
     * @var string|null
     */
    protected ?string $name;

    /**
     * The embed view template.
     *
     * @var string
     */
    protected string $view = '';

    /**
     * The embed source
     *
     * @var string
     */
    protected string $source;

    /**
     * The embed source
     *
     * @var array
     */
    protected array $options = [];

    /**
     * Create a new provider instance.
     *
     * @param string|null $source
     * @param array $options
     */
    public function __construct(string $source = null, array $options = [])
    {
        if ($source) {
            $this->setSource($source);
        }

        if (! empty($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Set the embed source.
     *
     * @param string $source
     * @return self
     */
    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Set the embed options.
     *
     * @param array $options
     * @return self
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get the embed provider name.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name ?? (string)Str::of(get_class($this))->beforeLast('Provider')->replaceMatches('/(?=[A-Z])/', ' ')->trim();
    }

    /**
     * Render the embed.
     *
     * @return string
     */
    public function toHtml(): string
    {
        if (! $this->validateSource($this->source)) {
            throw new InvalidEmbedSource($this);
        }

        if (! $this->view) {
            throw new InvalidArgumentException('No view template was specified.');
        }

        $viewPayload = array_merge($this->parseSource(), $this->options);

        return (string)view($this->view, $viewPayload);
    }
}
