<?php

namespace App\Filament\Resources\MyPatients;

use App\Filament\Resources\MyPatients\Pages\CreateMyPatient;
use App\Filament\Resources\MyPatients\Pages\EditMyPatient;
use App\Filament\Resources\MyPatients\Pages\ListMyPatients;
use App\Filament\Resources\MyPatients\Schemas\MyPatientForm;
use App\Filament\Resources\MyPatients\Tables\MyPatientsTable;
use App\Models\MyPatient;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MyPatientResource extends Resource
{
    protected static ?string $model = MyPatient::class;

    protected static string|BackedEnum|null $navigationIcon = 'fluentui-patient-20-o';

    protected static ?string $recordTitleAttribute = 'MyPatient';

    public static function form(Schema $schema): Schema
    {
        return MyPatientForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MyPatientsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'My Patient';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMyPatients::route('/'),
            // 'create' => CreateMyPatient::route('/create'),
            // 'edit' => EditMyPatient::route('/{record}/edit'),
        ];
    }
}
