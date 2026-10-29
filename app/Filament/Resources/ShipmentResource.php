<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Models\Shipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('receipt_code')
                    ->required()
                    ->maxLength(24),
                Forms\Components\Select::make('beneficiary_id')
                    ->relationship('beneficiary', 'masked_name')
                    ->required(),
                Forms\Components\Select::make('program_id')
                    ->relationship('program', 'name')
                    ->required(),
                Forms\Components\Select::make('agency_id')
                    ->relationship('agency', 'name')
                    ->required(),
                Forms\Components\TextInput::make('period')
                    ->required()
                    ->maxLength(7),
                Forms\Components\TextInput::make('entitled_cash')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('entitled_goods_value')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('entitled_goods_description')
                    ->maxLength(160),
                Forms\Components\TextInput::make('current_status')
                    ->required()
                    ->maxLength(32),
                Forms\Components\TextInput::make('distribution_point')
                    ->maxLength(120),
                Forms\Components\Toggle::make('is_simulated')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('receipt_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('beneficiary.masked_name')
                    ->label('Penerima')
                    ->searchable(),
                Tables\Columns\TextColumn::make('program.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('agency.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('period')
                    ->searchable(),
                Tables\Columns\TextColumn::make('entitled_cash')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('entitled_goods_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('entitled_goods_description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('current_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('distribution_point')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_simulated')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'edit' => Pages\EditShipment::route('/{record}/edit'),
        ];
    }
}
