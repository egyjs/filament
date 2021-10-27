<?php

namespace Filament\Tables\Actions;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

class Action
{
    use Concerns\BelongsToTable;
    use Concerns\CanOpenModal;
    use Concerns\CanOpenUrl;
    use Concerns\CanRequireConfirmation;
    use Concerns\HasAction;
    use Concerns\HasLabel;
    use Concerns\HasName;
    use Conditionable;
    use Macroable;
    use Tappable;

    final public function __construct(string $name)
    {
        $this->name($name);
    }

    public static function make(string $name): static
    {
        $static = new static($name);
        $static->setUp();

        return $static;
    }

    protected function setUp(): void
    {
    }

    public function call(Model $record, array $data = [])
    {
        $action = $this->getAction();

        if (! $action instanceof Closure) {
            return;
        }

        return app()->call($action, [
            'data' => $data,
            'livewire' => $this->getLivewire(),
            'record' => $record,
        ]);
    }
}