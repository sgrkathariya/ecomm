<?php

namespace App\Http\Livewire;

use App\Order;
use App\PurchasedProduct;
use Livewire\Component;

class OrderUpdate extends Component
{
    public $order;
    protected $rules = [
        'order.status' => 'required',
    ];

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function updateOrder()
    {
        $this->validate();
        // if order status is changed to confirmed
        if ($this->order->isDirty('status')  && $this->order->status == 'processing') {
            // decrement the product stock
            foreach ($this->order->products as $orderProduct) {
                if ($orderProduct->product->manage_stock) {
                    $orderProduct->product->decrement('stock_quantity', $orderProduct->quantity);
                }
            }
        }

        $this->order->save();
        $this->emit('orderUpdated');
        $this->emit('toast', ['success', 'Order status changed']);

        
        $orderProduct = $this->order->products->first();
        $purchasedProduct = PurchasedProduct::where('product_id', $orderProduct->product_id)->where('user_id', $this->order->user_id)->count();
        if ($this->order->status == "completed") {
            if ($purchasedProduct == 0) {

                PurchasedProduct::create([
                    'product_id' => $orderProduct->product_id,
                    'user_id' => $this->order->user_id,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.order-update');
    }
}
