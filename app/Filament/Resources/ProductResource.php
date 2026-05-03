<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Products';
    
    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('product_name')
                    ->maxLength(255),
                Forms\Components\Textarea::make('product_description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('product_price')
                    ->maxLength(255),
                Forms\Components\TextInput::make('product_salePrice')
                    ->maxLength(255),
                Forms\Components\TextInput::make('product_quantity')
                    ->maxLength(255),
                Forms\Components\TextInput::make('product_soldCount')
                    ->maxLength(255),
                Forms\Components\TextInput::make('product_rating')
                    ->maxLength(45),
                Forms\Components\TextInput::make('product_thumbnail')
                    ->maxLength(255),
                Forms\Components\Textarea::make('product_images')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('product_brand')
                    ->maxLength(255),
                Forms\Components\TextInput::make('product_category')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_price')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_salePrice')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_quantity')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_soldCount')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_rating')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_thumbnail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_brand')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_category')
                    ->searchable(),
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProducts::route('/'),
        ];
    }
}
