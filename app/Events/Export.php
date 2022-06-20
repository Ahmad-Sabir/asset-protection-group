<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Export
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Data.
     *
     * @var mixed
     */
    public $data;

    /**
     * Data.
     *
     * @var mixed
     */
    public $pdfTemplate;

    /**
     * Data.
     *
     * @var mixed
     */
    public $orientation;

    /**
     * Data.
     *
     * @var mixed
     */
    public $filter;

    /**
     * Data.
     *
     * @var mixed
     */
    public $fields;

    /**
     * Data.
     *
     * @var mixed
     */
    public $type;

    /**
     * Data.
     *
     * @var mixed
     */
    public $module;

    /**
     * Create a new event instance.
     *
     * @param mixed $data
     * @param mixed $pdfTemplate
     * @param mixed $orientation
     * @param mixed $filter
     * @param mixed $fields
     * @param mixed $type
     * @param mixed $module
     * @return void
     */
    public function __construct(
        $data,
        $pdfTemplate,
        $orientation = '',
        $filter = '',
        $fields = '',
        $type = '',
        $module = []
    ) {
        $this->data = $data;
        $this->pdfTemplate = $pdfTemplate;
        $this->orientation = $orientation;
        $this->filter = $filter;
        $this->fields = $fields;
        $this->type = $type;
        $this->module = $module;
    }
}
