<?php

namespace AlperenErsoy\FilamentExport\Components;

use AlperenErsoy\FilamentExport\Components\Concerns\HasUniqueActionId;
use AlperenErsoy\FilamentExport\FilamentExport;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Concerns\HasName;
use Filament\Tables\Actions\Modal\Actions\Action;
use Illuminate\Support\Collection;

class TableView extends Component
{
    use HasName;
    use HasUniqueActionId;

    protected FilamentExport $export;

    protected function setUp(): void
    {
        parent::setUp();

        $this->view('filament-export::components.table_view');
    }

    public static function make(string $name): static
    {
        $static = app(static::class);
        $static->name($name);
        $static->setUp();

        return $static;
    }

    public function export(FilamentExport $export): static
    {
        $this->export = $export;

        return $this;
    }

    public function getExport(): FilamentExport
    {
        return $this->export;
    }

    public function fileName(string $fileName): static
    {
        $this->getExport()->fileName($fileName);

        return $this;
    }

    public function getFileName(): string
    {
        return $this->getExport()->getFileName();
    }

    public function filteredColumns(array $columns): static
    {
        if (count($columns) == 0) {
            return $this;
        }

        $this->getExport()->filteredColumns($columns);

        return $this;
    }

    public function getFilteredColumns(): Collection
    {
        return $this->getExport()->getFilteredColumns();
    }

    public function additionalColumns(array $additionalColumns): static
    {
        if (count($additionalColumns) == 0) {
            return $this;
        }

        $this->getExport()->additionalColumns($additionalColumns);

        return $this;
    }

    public function getAdditionalColumns(): Collection
    {
        return $this->getExport()->getAdditionalColumns();
    }

    public function getAllColumns(): Collection
    {
        return $this->getExport()->getAllColumns();
    }

    public function getRows(): Collection
    {
        return $this->getExport()->collection();
    }

    public function getExportAction(): Action
    {
        return Action::make('export')
            ->button()
            ->label(__('filament-export::table_view.export_action_label'))
            ->submit()
            ->icon(config('filament-export.export_icon'));
    }

    public function getPrintAction(): Action
    {
        $uniqueActionId = $this->getUniqueActionId();

        return Action::make('print')
            ->button()
            ->label(__('filament-export::table_view.print_action_label'))
            ->action("\$emit('print-table-$uniqueActionId')")
            ->color('gray')
            ->icon(config('filament-export.print_icon'));
    }

    public function getCancelAction(): Action
    {
        return Action::make('cancel')
            ->button()
            ->label(__('filament-export::export_action.cancel_action_label'))
            ->cancel()
            ->color('secondary')
            ->icon(config('filament-export.cancel_icon'));
    }

    public function getFooterActions(): array
    {
        return [
            $this->getExportAction(),
            $this->getPrintAction(),
            $this->getCancelAction(),
        ];
    }

    public function getPreviewModalHeading(): string
    {
        return __('filament-export::table_view.preview_modal_heading');
    }
}
