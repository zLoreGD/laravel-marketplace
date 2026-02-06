<?php

namespace App\Filament\Resources\CartItems;

use BackedEnum;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\CartItems\Pages\EditCartItem;
use App\Filament\Resources\CartItems\Pages\ListCartItems;
use App\Filament\Resources\CartItems\Pages\CreateCartItem;
use App\Filament\Resources\CartItems\Schemas\CartItemForm;
use App\Filament\Resources\CartItems\Tables\CartItemsTable;

class CartItemResource extends Resource
{
    protected static ?string $model = CartItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'CartItem';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
           Select::make('user_id')
           ->label('User')
           ->options(User::pluck('name','id')) 
           ->searchable()
           ->required(),
           
           Select::make('product_id')
           ->label('Product')
           ->options(Product::pluck('name','id'))
           ->searchable()
           ->required(),
           TextInput::make('quantity')
           ->label('Quantity')
           ->numeric()
           ->minValue(1)
           ->default(1)
           ->required(),
        ]);
            
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id'),
            TextColumn::make('user.name')->label('User'),
            TextColumn::make('product.name')->label('Product'),
            TextColumn::make('quantity'),
            TextColumn::make('created_at')->dateTime(),
        ])
        ->actions([
            EditAction::make(),
            DeleteAction::make(),
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
            'index' => ListCartItems::route('/'),
            'create' => CreateCartItem::route('/create'),
            'edit' => EditCartItem::route('/{record}/edit'),
        ];
    }
}
