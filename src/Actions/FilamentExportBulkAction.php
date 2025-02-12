<?php

namespace AlperenErsoy\FilamentExport\Actions;

use AlperenErsoy\FilamentExport\FilamentExport;
use AlperenErsoy\FilamentExport\Actions\Concerns\CanDisableAdditionalColumns;
use AlperenErsoy\FilamentExport\Actions\Concerns\CanDisableFilterColumns;
use AlperenErsoy\FilamentExport\Actions\Concerns\CanDisableFileName;
use AlperenErsoy\FilamentExport\Actions\Concerns\CanDisableFileNamePrefix;
use AlperenErsoy\FilamentExport\Actions\Concerns\CanDisablePreview;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasAdditionalColumnsField;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasFilterColumnsField;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasDefaultFormat;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasDefaultPageOrientation;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasExportModelActions;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasFileName;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasFileNameField;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasFormatField;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasPageOrientationField;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasTimeFormat;
use AlperenErsoy\FilamentExport\Actions\Concerns\HasUniqueActionId;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FilamentExportBulkAction extends \Filament\Tables\Actions\BulkAction
{
    use CanDisableAdditionalColumns;
    use CanDisableFilterColumns;
    use CanDisableFileName;
    use CanDisablePreview;
    use HasAdditionalColumnsField;
    use HasFilterColumnsField;
    use HasDefaultFormat;
    use HasDefaultPageOrientation;
    use HasFileName;
    use CanDisableFileNamePrefix;
    use HasExportModelActions;
    use HasFileNameField;
    use HasFormatField;
    use HasPageOrientationField;
    use HasTimeFormat;
    use HasUniqueActionId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->uniqueActionId('bulk-action');

        FilamentExport::setUpFilamentExportAction($this);

        $this->form(static fn ($action, $records): array => FilamentExport::getFormComponents($action, $records))
            ->action(static fn ($action, $records, $data): BinaryFileResponse|StreamedResponse => FilamentExport::callDownload($action, $records, $data));
    }
}
