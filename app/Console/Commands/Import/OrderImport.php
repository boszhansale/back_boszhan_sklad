<?php

namespace App\Console\Commands\Import;

use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class OrderImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (\DB::connection('boszhan')->table('orders')->get() as $order) {
            Order::updateOrCreate(
                ['id' => $order->id],
                [
                    'id' => $order->id,
                    'status' => $order->status,
                    'payment_type' => $order->payment_type_id,
                    'payment_status' => $order->payment_status_id,
                    'user_id' => $order->user_id,
                    'counteragent_id' => $order->counteragent_id,
                    'store_id' => $order->store_id,
                    'total_price' => $order->total_price,
                    'discount_cashback' => $order->total_price,
                    'discount_phone' => $order->discount_phone,
                    'online_sale' => $order->online_sale,
                    'delivery_date' => $order->delivery_date,

                ]
            );
        }
    }
}
