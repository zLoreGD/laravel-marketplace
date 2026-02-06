<?php

namespace App\Filament\Resources\Products;

use BackedEnum;
use App\Models\Product;
use App\Models\Category;
use Faker\Provider\Image;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\Column;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Schemas\ProductForm;
use App\Filament\Resources\Products\Tables\ProductsTable;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Product';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')->label('Product Name')
            ->required(true)
            ->minLength(3)
            ->maxLength(50),
            
            TextInput::make('description')->label('Product Description')
            ->required(true)
            ->minLength(3)
            ->maxLength(200),
            TextInput::make('price')->label('Product Price')
            ->numeric()
            ->step('0.01')
            ->inputMode('decimal')
            ->minValue(0)
            ->maxValue(999999),
            Select::make('category_id')->label('Product Category')
            ->options(Category::pluck('name','id'))
            ->required(true)
            ->default('Misc'),
            Checkbox::make('available')->label('Available'),
            FileUpload::make('image_path')->label('Product Image')
            ->image()
            ->directory('products')
            ->disk('public')
            
            

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id'),
            TextColumn::make('name')->label('Product Name'),
            TextColumn::make('description')->label('Product description'),
            TextColumn::make('price')->label('Price'),
            TextColumn::make('category.name')->label('Category'),
            IconColumn::make('available')->label('Available')->boolean(),

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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
