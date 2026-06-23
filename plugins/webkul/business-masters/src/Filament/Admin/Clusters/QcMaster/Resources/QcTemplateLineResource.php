<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources;

use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcTemplateLineResource\Pages\CreateQcTemplateLine;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcTemplateLineResource\Pages\EditQcTemplateLine;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcTemplateLineResource\Pages\ListQcTemplateLines;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcTemplateLineResource\Pages\ViewQcTemplateLine;
use Webkul\BusinessMasters\Models\QcTemplateLine;

class QcTemplateLineResource extends Resource
{
    protected static ?string $model = QcTemplateLine::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    protected static ?string $cluster = QcMaster::class;

    protected static ?string $recordTitleAttribute = 'result_type';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return 'QC Template Line';
    }

    public static function getModelLabel(): string
    {
        return 'QC Template Line';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('QC Template Line')
                    ->schema([
                        Select::make('qc_template_id')
                            ->label('QC Template')
                            ->relationship('qcTemplate', 'qc_temp_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        Select::make('qc_parameter_id')
                            ->label('QC Parameter')
                            ->relationship('qcParameter', 'parameter_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        TextInput::make('min_value')
                            ->label('Min Value')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('max_value')
                            ->label('Max Value')
                            ->numeric()
                            ->minValue(0),
                        Select::make('result_type')
                            ->label('Result')
                            ->options([
                                'Yes'   => 'Yes',
                                'No'    => 'No',
                                'Value' => 'Value',
                            ])
                            ->native(false)
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->integer()
                            ->minValue(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('min_value')->label('Min Value')->searchable()->sortable(),
                TextColumn::make('max_value')->label('Max Value')->searchable()->sortable(),
                TextColumn::make('result_type')->label('Result')->searchable()->sortable(),
                TextColumn::make('created_at')->label('Created At')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
                Section::make('QC Template Line')
                    ->schema([
                        TextEntry::make('qc_template_id')->label('QC Template')->placeholder('-'),
                        TextEntry::make('qc_parameter_id')->label('QC Parameter')->placeholder('-'),
                        TextEntry::make('min_value')->label('Min Value')->placeholder('-'),
                        TextEntry::make('max_value')->label('Max Value')->placeholder('-'),
                        TextEntry::make('result_type')->label('Result')->placeholder('-'),
                        TextEntry::make('sort_order')->label('Sort Order')->placeholder('-'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListQcTemplateLines::route('/'),
            'create' => CreateQcTemplateLine::route('/create'),
            'view'   => ViewQcTemplateLine::route('/{record}'),
            'edit'   => EditQcTemplateLine::route('/{record}/edit'),
        ];
    }
}
