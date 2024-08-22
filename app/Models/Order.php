<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $invoice_id
 * @property int $user_id
 * @property string $address
 * @property float $discount
 * @property float $delivery_charge
 * @property float $subtotal
 * @property float $grand_total
 * @property int $product_qty
 * @property string|null $payment_method
 * @property string $payment_status
 * @property string|null $payment_approve_date
 * @property string|null $transaction_id
 * @property mixed|null $coupon_info
 * @property string|null $currency_name
 * @property string $order_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $address_id
 * @property-read \App\Models\Delivery|null $delivery
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Address|null $userAddress
 * @method static Builder|Order authUser()
 * @method static Builder|Order declined()
 * @method static Builder|Order delivered()
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereAddress($value)
 * @method static Builder|Order whereAddressId($value)
 * @method static Builder|Order whereCouponInfo($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereCurrencyName($value)
 * @method static Builder|Order whereDeliveryCharge($value)
 * @method static Builder|Order whereDiscount($value)
 * @method static Builder|Order whereGrandTotal($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereInvoiceId($value)
 * @method static Builder|Order whereOrderStatus($value)
 * @method static Builder|Order wherePaymentApproveDate($value)
 * @method static Builder|Order wherePaymentMethod($value)
 * @method static Builder|Order wherePaymentStatus($value)
 * @method static Builder|Order whereProductQty($value)
 * @method static Builder|Order whereSubtotal($value)
 * @method static Builder|Order whereTransactionId($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;

    const ORDER_STATUS_PENDING = 'pending';
    const ORDER_STATUS_IN_PROGRESS = 'in_process';
    const ORDER_STATUS_DELIVERED = 'delivered';
    const ORDER_STATUS_DECLINED = 'declined';

    /**
     * Get the user that owns the order.
     */
    function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the delivery area that owns the order.
     */
    function delivery() : BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    /**
     * Get the addresses that owns the order.
     */
    function userAddress() : BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

    /**
     * Get the order items.
     */
    function orderItems() : HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope a query to only include logged user orders.
     *
     * @param Builder $query
     */
    public function scopeAuthUser(Builder $query): void
    {
        $query->where('user_id', auth()->user()->id);
    }

    /**
     * Scope a query to only include delivered orders.
     *
     * @param Builder $query
     */
    public function scopeDelivered(Builder $query): void
    {
        $query->where('order_status', self::ORDER_STATUS_DELIVERED);
    }

    /**
     * Scope a query to only include declined orders.
     *
     * @param Builder $query
     */
    public function scopeDeclined(Builder $query): void
    {
        $query->where('order_status', self::ORDER_STATUS_DECLINED);
    }
}
