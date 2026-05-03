<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\Select;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('order_reference')
                            ->columnSpan(1)
                            ->disabled(),
                        Forms\Components\TextInput::make('user.name')
                            ->label('Client Name')
                            ->columnSpan(1)
                            ->formatStateUsing(fn($record) => $record?->user?->name ?? 'test')
                            ->disabled(),
                    ]),
                Repeater::make('order_products')
                    ->label('Products')
                    ->disabled()
                    ->schema([
                        Forms\Components\TextInput::make('product_name')
                            ->label('Product Name'),
                        Forms\Components\TextInput::make('variant_name')
                            ->label('Variant'),
                        Forms\Components\TextInput::make('subvariant_name')
                            ->label('Subvariant'),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric(),
                        Forms\Components\TextInput::make('product_price')
                            ->label('Price(Individual)')
                            ->numeric(),
                    ])
                    ->columnSpanFull()
                    ->columns(2),

                Section::make()
                    ->columnSpanFull()
                    ->columns([
                        'xs'=>1,
                        'sm'=>1,
                        'md'=>2,
                        'lg'=>4,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('order_total')
                            ->columnSpan(1)
                            ->label('Total Amount')
                            ->disabled(),
                        Forms\Components\TextInput::make('order_shippingMethod')
                            ->columnSpan(1)
                            ->label('Shipping Method')
                            ->formatStateUsing(fn($record) => $record?->shippingOption?->option_name ?? 'test')
                            ->disabled(),
                        Forms\Components\Textarea::make('order_shippingAddress')
                            ->columnSpan([
                                'xs'=>1,
                                'sm'=>1,
                                'md'=>2,
                                'lg'=>2,
                            ])
                            ->label('Shipping Address')
                            ->formatStateUsing(fn($record) => $record?->shippingDetails?->shipping_address ?? 'N/A')
                            ->disabled(),
                    ]),
                Section::make()
                    ->columnSpanFull()
                    ->columns(4)
                    ->schema([
                        Forms\Components\FileUpload::make('order_purchaseReceipt')
                            ->columnSpan(2)
                            ->downloadable()
                            ->label('Purchase Receipt')
                            ->disabled(),
                        Forms\Components\FileUpload::make('order_shippingReceipt')
                            ->columnSpan(2)
                            ->visible(fn($record) => $record?->order_shippingReceipt !== null)
                            ->downloadable()
                            ->label('Shipping Receipt')
                            ->disabled(),
                    ]),
                Forms\Components\TextInput::make('order_status')
                    ->label('Order Status')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_reference')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('order_total')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('shippingOption.option_name')
                    ->label('Shipping Method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shippingDetails.shipping_address')
                    ->label('Shipping Address')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('order_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending for Verification' => 'info',
                        'Waiting for Payment' => 'warning',
                        'Cancelled' => 'danger',
                        'Order Confirmed' => 'primary',
                        'Forwarded to Delivery' => 'secondary',
                        'Order Delivered' => 'success',
                        default => 'gray',
                    })
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
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->color('success'),
                    Tables\Actions\Action::make('updateStatus')
                        ->label('Update Status')
                        ->color('primary')
                        ->icon('heroicon-o-pencil-square')
                        ->fillForm(fn (Order $record): array => [
                            'order_status' => $record->order_status,
                            'order_shippingFee' => null
                        ])
                        ->form([
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Select::make('order_status')
                                        ->label('Order Status')
                                        ->options([
                                            'Waiting for Payment' => 'Waiting for Payment',
                                            'Order Confirmed' => 'Order Confirmed',
                                            'Forwarded to Delivery' => 'Forwarded to Delivery',
                                            'Cancelled' => 'Cancelled',
                                        ])
                                        ->required()
                                        ->live(),
                                    Forms\Components\TextInput::make('order_shippingFee')
                                        ->label('Shipping Fee')
                                        ->prefix('₱')
                                        ->numeric()
                                        ->visible(fn($get) => $get('order_status') === 'Waiting for Payment')
                                        ->required(fn($get) => $get('order_status') === 'Waiting for Payment'),
                                ]),
                            
                        ])
                        ->action(function (Order $record, array $data) {
                            try {
                                $oldStatus = $record->order_status;
                                $record->update([
                                    'order_status' => $data['order_status'],
                                ]);

                                if ($data['order_status'] == 'Waiting for Payment') {
                                    if ($data['order_shippingFee'] === null) {
                                        halt(500, 'Shipping fee is required when status is set to Waiting for Payment');
                                    }
                                    $record->update([
                                        'order_shippingFee' => $data['order_shippingFee'],
                                    ]);

                                    // Send email to user
                                    $user = $record->user;
                                    if ($user && $user->email) {
                                        $paymentLink = url('/my-orders'); // Placeholder, update to real payment page later
                                        \Mail::to($user->email)->queue(new \App\Mail\WaitingForPaymentMail($record, $paymentLink));
                                    }

                                    // Notify only the current admin (auth user) of status update
                                    $admin = auth()->user();
                                    if ($admin) {
                                        $admin->notify(new \App\Notifications\OrderStatusUpdated($record, $oldStatus, $data['order_status']));
                                    }
                                } else {
                                    // Notify only the current admin (auth user) of status update
                                    $admin = auth()->user();
                                    if ($admin) {
                                        $admin->notify(new \App\Notifications\OrderStatusUpdated($record, $oldStatus, $data['order_status']));
                                    }
                                }
                            } catch (\Exception $e) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Error')
                                    ->body('An error occurred while updating the order status. Please try again. ' . $e->getMessage())
                                    ->danger()
                                    ->sendToDatabase(auth()->user())
                                    ->send();
                                return;
                            }
                        }),
                    Tables\Actions\DeleteAction::make()
                ]),
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
            'index' => Pages\ManageOrders::route('/'),
        ];
    }
}
