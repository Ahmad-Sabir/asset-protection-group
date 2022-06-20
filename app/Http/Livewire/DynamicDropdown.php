<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DynamicDropdown extends Component
{
    /**
     * this variable hold component data
     *
     * @var string $name
     */
    public $name;

    /**
     * this variable hold component data
     *
     * @var string $disabled
     */
    public $disabled;

    /**
     * this variable hold component data
     *
     * @var string $entity
     */
    public $entity;

    /**
     * this variable hold component data
     *
     * @var string $entity_id
     */
    public $entity_id;

    /**
     * this variable hold component data
     *
     * @var string $field_id
     */
    public $field_id;

    /**
     * this variable hold component data
     *
     * @var string $class
     */
    public $class;

    /**
     * this variable hold component data
     *
     * @var string $multiple
     */
    public $multiple;

    /**
     * this variable hold except data
     *
     * @var array $except
     */
    public $except = [];

    /**
     * this variable hold items data
     *
     * @var array $items
     */
    public $items = [];

    /**
     * this variable hold where data
     *
     * @var array $where
     */
    public $where = [];

    /**
     * this variable hold where data
     *
     * @var array $orWhere
     */
    public $orWhere = [];

    /**
     * this variable hold where data
     *
     * @var string $selectedByDisplayName
     */
    public $selectedByDisplayName = '';

    /**
     * this variable hold whereHas data
     *
     * @var string $whereHas
     */
    public $whereHas = '';

    /**
     * this variable hold whereNull data
     *
     * @var string $whereNull
     */
    public $whereNull = '';

    /**
     * this variable hold whereNotNull data
     *
     * @var string $whereNotNull
     */
    public $whereNotNull = '';

    /**
     * this variable hold entity_ids data
     *
     * @var array $entity_ids
     */
    public $entity_ids = [];

    /**
     * this variable hold with data
     *
     * @var array $with
     */
    public $with = [];

    /**
     * holds limit
     *
     * @var int $limit
     */
    public $limit = 30;

    /**
     * hold value for search
     *
     * @var string $searchQuery
     */
    public $searchQuery = '';

    /**
     * DB select for current entity model
     *
     * @var string
     */
    public $entitySelectFields = "id";

    /**
     * DB search fields for current entity model
     *
     * @var string[]
     */
    public $entitySearchFields = ["id"];

    /**
     * Value field in the model
     *
     * @var string
     */
    public $entityField = "id";

    /**
     * Value field in the model
     *
     * @var string
     */
    public $entityDisplayField = "id";

    /**
     * Value field in the model
     *
     * @var null|string
     */
    public $wireModel = null;

    /**
     * Model Binding
     *
     * @var string
     */
    public $parentModel;

    /**
     * Data attibute Binding
     *
     * @var null
     */
    public $isDataAttribute = null;

    /**
     * function name
     *
     * @var null
     */
    public $onChangeFunc = null;

    /**
     * elementId
     *
     * @var null
     */
    public $elementId = null;

    /**
     * set xmodel
     *
     * @var null
     */
    public $xModel = null;

    /**
     * A listeners variable.
     *
     * @var array
     */
    public $listeners = ['reactOnSearch', 'childModelUpdate'];

    /**
     * The attributes that are mass assignable.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        /**
         * @var string $json
         * */
        $json = json_encode($this->items);
        $data = json_decode($json);
        $entityName = class_basename($this->entity);
        if (!empty($this->entity)) {
            $data = app($this->entity)
                ->selectRaw($this->entitySelectFields)
                ->when(!empty($this->entity_id), function ($query) {
                    $orderBy = "FIELD({$this->entityField}, '{$this->entity_id}') DESC, {$this->entityField}";
                    if (app()->environment('testing')) {
                        $orderBy = "{$this->entityField} DESC";
                    }
                    $query->orderByRaw($orderBy);
                })
                ->whereNotIn('id', $this->except)
                ->when(! empty($this->where), function ($query) {
                    $query->where(function ($query) {
                        $query->where($this->where);
                        $query->when($this->orWhere, fn ($query) => $query->orWhere($this->orWhere));
                    });
                })->when(! empty($this->whereHas), function ($query) {
                    $query->whereHas($this->whereHas);
                })->when(! empty($this->whereNull), function ($query) {
                    $query->whereNull($this->whereNull);
                })->when(! empty($this->whereNotNull), function ($query) {
                    $query->whereNotNull($this->whereNotNull);
                })->when(! empty($this->searchQuery), function ($query) {
                    $query->where(function ($query) {
                        foreach ($this->entitySearchFields as $field) {
                            $query->whereRaw($field . ' LIKE ?', ['%' . $this->searchQuery . '%']);
                        }
                    });
                })
                ->with($this->with)->take($this->limit)->get();
        }

        return view()->make('livewire.dynamic-dropdown', [
            "data"                  => $data,
            "name"                  => $this->name,
            "entity"                => $this->entity,
            "entity_id"             => $this->entity_id,
            "field_id"              => $this->field_id,
            "class"                 => $this->class,
            "multiple"              => $this->multiple,
            "entity_ids"            => $this->entity_ids,
            "entityName"            => $entityName,
            "with"                  => $this->with,
            "disabled"              => $this->disabled,
            "searchQuery"           => $this->searchQuery,
            "entityField"           => $this->entityField,
            "entityDisplayField"    => $this->entityDisplayField,
        ]);
    }

    /**
     * On component mount
     *
     * @return void
     */
    public function mount()
    {
        if (!empty($this->parentModel)) {
            $this->{$this->parentModel} = '';
        }
    }

    /**
     * On component updated
     *
     * @return void
     */
    public function updated()
    {
        $this->emitUp('modelUpdate', $this->parentModel, $this->{$this->parentModel});
    }

    /**
     * Event for search query
     *
     * @param string $query
     *
     * @return void
     */
    public function reactOnSearch($query)
    {
        $this->searchQuery = $query;
    }

    /**
     * Model values update from parent
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function childModelUpdate($key, $value)
    {
        if (property_exists($this, $key)) {
            $this->{$key} = $value;
        }
    }
}
