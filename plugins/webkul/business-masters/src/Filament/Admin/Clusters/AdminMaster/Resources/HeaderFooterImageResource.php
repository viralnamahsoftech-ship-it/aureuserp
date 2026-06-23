<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources;

use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\HeaderFooterImageResource\Pages\CreateHeaderFooterImage;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\HeaderFooterImageResource\Pages\EditHeaderFooterImage;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\HeaderFooterImageResource\Pages\ListHeaderFooterImages;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\HeaderFooterImageResource\Pages\ViewHeaderFooterImage;
use Webkul\BusinessMasters\Models\HeaderFooterImage;

class HeaderFooterImageResource extends Resource
{
    protected static ?string $model = HeaderFooterImage::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 6;

    protected static ?string $cluster = AdminMaster::class;

    protected static ?string $recordTitleAttribute = 'file_path';

    public static function getNavigationLabel(): string
    {
        return 'Header / Footer Images';
    }

    public static function getModelLabel(): string
    {
        return 'Header / Footer Images';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Header / Footer Images')
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'company_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        Select::make('branch_id')
                            ->label('Branch')
                            ->relationship('branch', 'branch_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('image_type')
                            ->label('Image Type')
                            ->options([
                                'header' => 'Header',
                                'footer' => 'Footer',
                            ])
                            ->native(false)
                            ->required(),
                        FileUpload::make('file_path')
                            ->label('File')
                            ->image()
                            ->disk('public')
                            ->directory('business/file-path')
                            ->visibility('public'),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('image_type')->label('Image Type')->searchable()->sortable(),
                IconColumn::make('is_active')->label('Active')->boolean()->sortable(),
                IconColumn::make('is_active')->label('Active')->boolean()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')->label('Created At')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label('Active'),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Header / Footer Images')
                    ->schema([
                        TextEntry::make('company_id')->label('Company')->placeholder('-'),
                        TextEntry::make('branch_id')->label('Branch')->placeholder('-'),
                        TextEntry::make('image_type')->label('Image Type')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListHeaderFooterImages::route('/'),
            'create' => CreateHeaderFooterImage::route('/create'),
            'view'   => ViewHeaderFooterImage::route('/{record}'),
            'edit'   => EditHeaderFooterImage::route('/{record}/edit'),
        ];
    }
}
