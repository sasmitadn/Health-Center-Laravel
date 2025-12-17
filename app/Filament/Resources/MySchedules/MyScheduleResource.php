<?php

namespace App\Filament\Resources\MySchedules;

use App\Filament\Resources\MySchedules\Pages\CreateMySchedule;
use App\Filament\Resources\MySchedules\Pages\EditMySchedule;
use App\Filament\Resources\MySchedules\Pages\ListMySchedules;
use App\Filament\Resources\MySchedules\Schemas\MyScheduleForm;
use App\Filament\Resources\MySchedules\Tables\MySchedulesTable;
use App\Models\MySchedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MyScheduleResource extends Resource
{
    protected static ?string $model = MySchedule::class;

    protected static string|BackedEnum|null $navigationIcon = 'fluentui-doctor-28-o';

    protected static ?string $recordTitleAttribute = 'MySchedule';

    public static function form(Schema $schema): Schema
    {
        return MyScheduleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MySchedulesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMySchedules::route('/'),
            'create' => CreateMySchedule::route('/create'),
            'edit' => EditMySchedule::route('/{record}/edit'),
        ];
    }
}
