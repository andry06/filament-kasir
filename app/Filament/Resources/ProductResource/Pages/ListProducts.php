<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Imports\ProductImport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;



    protected function getHeaderActions(): array
    {
        return [
            Action::make('importProduct')
                ->icon('heroicon-s-arrow-down-tray')
                ->color('primary')
                ->form([
                    FileUpload::make('attachment')
                        ->label('Upload Template Product')
                ])
                ->action(function (array $data) {
                    $file = Storage::disk('public')->path($data['attachment']);

                    try {
                        Excel::import(new ProductImport, $file);
                        Notification::make()
                            ->title('Product imported')
                            ->success()
                            ->send();

                    } catch (\Exception $e) {
                        info($e);
                        Notification::make()
                            ->title('Product failed to import')
                            ->danger()
                            ->send();
                    }
                }),
            Action::make('Download Template')
                ->url(route('download-template'))
                ->color('success'),
            Actions\CreateAction::make(),
        ];
    }
}
