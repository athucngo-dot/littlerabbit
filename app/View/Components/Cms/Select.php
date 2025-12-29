<?php

namespace App\View\Components\Cms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public string $label;
    public string $name;
    public $options;
    public $selected;
    public string $valueKey;
    public string $labelKey;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $label = '',
        string $name = '',
        $options = [],
        $selected = null,
        string $valueKey = 'id',
        string $labelKey = 'name'
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
        $this->valueKey = $valueKey;
        $this->labelKey = $labelKey;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cms.select');
    }
}
