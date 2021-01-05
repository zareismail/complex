<?php

namespace Zareismail\Fields;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Complex extends Field
{ 
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'complex'; 

    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|callable|null  $attribute
     * @param  callable|null  $resolveCallback
     * @return void
     */
    public function __construct($name, callable $fields)
    {
        parent::__construct($name);

        $this->withMeta([
            'fields' => collect($fields())->all()
        ]);
    }

    public function displayNullfields()
    { 
        $this->withMeta([
            'displayNullfields' => true,
        ]);
    }

    /**
     * Resolve the field's value.
     *
     * @param  mixed  $resource
     * @param  string|null  $attribute
     * @return void
     */
    public function resolve($resource, $attribute = null)
    {
        collect($this->meta['fields'])->each->resolve($resource, $attribute);

        return $this;
    }

    /**
     * Resolve the field's value for display.
     *
     * @param  mixed  $resource
     * @param  string|null  $attribute
     * @return void
     */
    public function resolveForDisplay($resource, $attribute = null)
    {
        collect($this->meta['fields'])->each->resolveForDisplay($resource, $attribute);

        return $this;
    }

    /**
     * Resolve the default value for an Action field.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return void
     */
    public function resolveForAction($request)
    { 
        collect($this->meta['fields'])->each->resolveForAction($request);

        return $this;
    } 

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  object  $model
     * @return mixed
     */
    public function fill(NovaRequest $request, $model)
    { 
        return $this->fillFields($request, $model, __FUNCTION__);
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  object  $model
     * @return mixed
     */
    public function fillForAction(NovaRequest $request, $model)
    {
        return $this->fillFields($request, $model, __FUNCTION__);
    } 

    /**
     * Hydrate the given attribute on the model based on the incoming request and given callback.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  object  $model
     * @return mixed
     */
    public function fillFields(NovaRequest $request, $model, $callback)
    {
        $callbacks = collect($this->meta['fields'])->map->{$callback}($request, $model)->filter(function($callback) {
            return is_callable($callback);
        });

        $callbacks->each->__invoke();

        return $this;
    }

    /**
     * Get the validation rules for this field.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function getRules(NovaRequest $request)
    {
        return collect($this->meta['fields'])->flatMap->getRules($request)->all();
    } 

    /**
     * Get the creation rules for this field.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array|string
     */
    public function getCreationRules(NovaRequest $request)
    {
        return collect($this->meta['fields'])->flatMap->getCreationRules($request)->all();
    }

    /**
     * Get the update rules for this field.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function getUpdateRules(NovaRequest $request)
    {
        return collect($this->meta['fields'])->flatMap->getUpdateRules($request)->all();
    } 

    /**
     * Determine if the field is required.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return bool
     */
    public function isRequired(NovaRequest $request)
    {
        return collect($this->meta['fields'])->filter->isRequired($request)->isNotEmpty();
    } 

    /**
     * Check for showing when updating.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  mixed  $resource
     * @return bool
     */
    public function isShownOnUpdate(NovaRequest $request, $resource): bool
    {
        return  parent::isShownOnUpdate($request, $resource) &&
                collect($this->meta['fields'])->filter->isShownOnUpdate($request, $resource)->isNotEMpty(); 
    }

    /**
     * Check showing on index.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  mixed  $resource
     * @return bool
     */
    public function isShownOnIndex(NovaRequest $request, $resource): bool
    {
        return  parent::isShownOnIndex($request, $resource) &&
                collect($this->meta['fields'])->filter->isShownOnIndex($request, $resource)->isNotEMpty(); 
    }

    /**
     * Check showing on detail.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  mixed  $resource
     * @return bool
     */
    public function isShownOnDetail(NovaRequest $request, $resource): bool
    {
        return  parent::isShownOnDetail($request, $resource) &&
                collect($this->meta['fields'])->filter->isShownOnDetail($request, $resource)->isNotEMpty(); 
    }

    /**
     * Check for showing when creating.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return bool
     */
    public function isShownOnCreation(NovaRequest $request): bool
    {
        return  parent::isShownOnCreation($request) &&
                collect($this->meta['fields'])->filter->isShownOnCreation($request)->isNotEMpty(); 
    }

    /**
     * Margin of stacked values on the index.
     *
     * @param bool $expansionOverflow
     *
     * @return $this
     */
    public function expansionOverflow(int $expansionOverflow = 0)
    {
        $this->withMeta(compact('expansionOverflow'));

        return $this;
    } 

    /**
     * Fields overflow margin in the form.
     *
     * @param bool $groupOverflow
     *
     * @return $this
     */
    public function groupOverflow(int $groupOverflow = 0)
    {
        $this->withMeta(compact('groupOverflow'));

        return $this;
    } 
}
