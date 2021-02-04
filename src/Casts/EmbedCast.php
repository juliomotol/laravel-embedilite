<?php

namespace JulioMotol\Embedilite\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use JulioMotol\Embedilite\EmbediliteFacade as Embedilite;
use JulioMotol\Embedilite\Providers\Provider;
use JulioMotol\Embedilite\Traits\ConfiguresEmbed;

class EmbedCast implements CastsAttributes
{
    /**
     * The target column to cast.
     *
     * @var string
     */
    protected string $column = '';

    /**
     * The embed providers for the column.
     *
     * @var array
     */
    protected array $providers = [];

    /**
     * Create a new cast instance.
     *
     * @param string $column
     * @param string ...$provider
     */
    public function __construct($column, ...$provider)
    {
        $this->column = $column;
        $this->providers = $provider;
    }

    /**
     * Transform the attribute from the underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $value = $model->{$this->column};

        foreach ($this->providers as $provider) {
            $embedProvider = Embedilite::from($provider);

            if (! $embedProvider->validateSource($value)) {
                continue;
            }

            return tap($embedProvider, function ($embedProvider) use ($model, $value, $provider) {
                $embedProvider->setSource($value);

                if (in_array(ConfiguresEmbed::class, class_uses($model))) {
                    $embedProvider->setOptions($model->getEmbedOptions($provider)->options);
                }
            });
        }

        throw new InvalidArgumentException("Unable to cast embed provider for {$this->column} where providers could be {implode(', ', $this->providers)}.");
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof Provider) {
            return $value->source;
        }

        return $value;
    }
}
