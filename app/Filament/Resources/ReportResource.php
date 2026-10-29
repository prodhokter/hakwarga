<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ticket_code')
                    ->required()
                    ->maxLength(16),
                Forms\Components\TextInput::make('secret_hash')
                    ->required()
                    ->maxLength(64),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('category')
                    ->required()
                    ->maxLength(40),
                Forms\Components\Select::make('region_id')
                    ->relationship('region', 'name')
                    ->required(),
                Forms\Components\Select::make('agency_id')
                    ->relationship('agency', 'name'),
                Forms\Components\Select::make('program_id')
                    ->relationship('program', 'name'),
                Forms\Components\Select::make('target_beneficiary_id')
                    ->relationship('targetBeneficiary', 'id'),
                Forms\Components\TextInput::make('amount_claimed')
                    ->numeric(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(20)
                    ->default('submitted'),
                Forms\Components\DateTimePicker::make('first_response_at'),
                Forms\Components\DateTimePicker::make('resolved_at'),
                Forms\Components\Toggle::make('is_simulated')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ticket_code')
                    ->label('Nomor Tiket')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('region.name')
                    ->label('Wilayah')
                    ->sortable(),
                Tables\Columns\TextColumn::make('agency.name')
                    ->label('Instansi Penyalur')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
