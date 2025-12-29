<?php

namespace App\View\Components\Cms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public ?string $label;
    public ?string $name;
    public $value;
    public string $type;
    public ?string $message;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $label = '',
        string $name = '',
        $value = null,
        string $type = 'text',
        string $message = ''
        ) {
            
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cms.input');
    }
}
