<?php

namespace JulioMotol\Embedilite\Rules;

use Illuminate\Contracts\Validation\Rule;
use JulioMotol\Embedilite\EmbediliteFacade;

class EmbedSource implements Rule
{
    /**
     * The providers to be validated with.
     *
     * @var string[]
     */
    protected array $providers;

    public function __construct(string ...$providers)
    {
        $this->providers = $providers;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($this->providers as $provider) {
            if (! EmbediliteFacade::from($provider)::validateSource($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute is not a valid embed source.";
    }
}
