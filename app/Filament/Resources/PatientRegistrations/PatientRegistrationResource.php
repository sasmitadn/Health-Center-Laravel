<?php

namespace App\Filament\Resources\PatientRegistrations;

use App\Filament\Resources\PatientRegistrations\Pages\CreatePatientRegistration;
use App\Filament\Resources\PatientRegistrations\Pages\EditPatientRegistration;
use App\Filament\Resources\PatientRegistrations\Pages\ListPatientRegistrations;
use App\Filament\Resources\PatientRegistrations\Schemas\PatientRegistrationForm;
use App\Filament\Resources\PatientRegistrations\Tables\PatientRegistrationsTable;
use App\Models\PatientRegistration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PatientRegistrationResource extends Resource
{
    protected static ?string $model = PatientRegistration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Registration';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth('web')->user();
        $patientId = $user->patient?->id;
        return $query->where('patient_id', $patientId);
    }

    public static function form(Schema $schema): Schema
    {
        return PatientRegistrationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PatientRegistrationsTable::configure($table);
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
            'index' => ListPatientRegistrations::route('/'),
            'create' => CreatePatientRegistration::route('/create'),
            'edit' => EditPatientRegistration::route('/{record}/edit'),
        ];
    }
}
