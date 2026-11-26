<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Seed a small but complete data set for local demo and chart testing.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        $userId = DB::table('users')->insertGetId([
            'first_name'        => 'Juan',
            'last_name'         => 'Dela Cruz',
            'email'             => 'customer@example.com',
            'email_verified_at' => $now,
            'password'          => Hash::make('password'),
            'status'            => '1',
            'address'           => '123 Rizal Street, Quezon City',
            'mobile_number'     => 9171234567,
            'birthday'          => '1995-06-15',
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);

        $categories = [
            'Consoles',
            'Accessories',
            'Games',
            'Merchandise',
        ];

        $categoryIds = [];
        foreach ($categories as $category) {
            $categoryIds[] = DB::table('categories')->insertGetId([
                'name'       => $category,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $brands = [
            'Nintendo',
            'Sony',
            'Retro',
            'Generic',
        ];

        $brandIds = [];
        foreach ($brands as $brand) {
            $brandIds[] = DB::table('brands')->insertGetId([
                'name'       => $brand,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $images = [
            '1537048132_sample-ce57850bd583f6ccb03c45c606b44a1d_1_large_1580292112.jpg',
            '1537048132_sample-ce57850bd583f6ccb03c45c606b44a1d_1_large_1581014305.jpg',
            '1cf8by_large_1579597738.jpg',
            '1cf8by_large_1579845934.jpg',
            '1cf8by_large_1581768259.jpg',
            '25435108_1675590959129970_2117801909_o_large_1579846141.jpg',
            '28944547_285278732005525_1218266011_o_large_1580328863.jpg',
            'Elliot_large_1580301588.jpg',
        ];

        $items = [
            ['name' => 'Gameboy Advance SP', 'category' => 0, 'brand' => 0, 'price' => 2500.00, 'stocks' => 12, 'description' => 'Refurbished Gameboy Advance SP in good working condition.'],
            ['name' => 'Nintendo 64 Console', 'category' => 0, 'brand' => 0, 'price' => 4500.00, 'stocks' => 4, 'description' => 'Complete Nintendo 64 console with controller and cables.'],
            ['name' => 'PlayStation 2 Slim', 'category' => 0, 'brand' => 1, 'price' => 3800.00, 'stocks' => 7, 'description' => 'Slim PlayStation 2 unit, tested and working.'],
            ['name' => 'Retro Controller', 'category' => 1, 'brand' => 2, 'price' => 850.00, 'stocks' => 20, 'description' => 'USB retro controller compatible with PC and Raspberry Pi.'],
            ['name' => 'Memory Card 8MB', 'category' => 1, 'brand' => 3, 'price' => 300.00, 'stocks' => 3, 'description' => 'Replacement 8MB memory card for classic consoles.'],
            ['name' => 'Pokemon Crystal', 'category' => 2, 'brand' => 0, 'price' => 2200.00, 'stocks' => 2, 'description' => 'Authentic Pokemon Crystal cartridge for Gameboy Color.'],
            ['name' => 'Final Fantasy VII', 'category' => 2, 'brand' => 1, 'price' => 1800.00, 'stocks' => 5, 'description' => 'Complete Final Fantasy VII for PlayStation 1.'],
            ['name' => 'Retro Gaming Shirt', 'category' => 3, 'brand' => 3, 'price' => 550.00, 'stocks' => 30, 'description' => 'Cotton t-shirt with a retro gaming print.'],
        ];

        $itemIds = [];
        foreach ($items as $index => $item) {
            $itemIds[] = DB::table('items')->insertGetId([
                'category_id' => $categoryIds[$item['category']],
                'brand_id'    => $brandIds[$item['brand']],
                'image'       => $images[$index],
                'name'        => $item['name'],
                'stocks'      => $item['stocks'],
                'price_stocks'=> $item['price'],
                'description' => $item['description'],
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }

        $orders = [
            ['date' => '2020-01-12', 'status' => 'Pending',    'paid' => 0, 'method' => 'cod',  'total' => 2500.00, 'items' => [[0, 1]]],
            ['date' => '2020-02-14', 'status' => 'Confirmed',  'paid' => 1, 'method' => 'cod',  'total' => 4500.00, 'items' => [[1, 1]]],
            ['date' => '2020-03-10', 'status' => 'On Delivery','paid' => 1, 'method' => 'bank', 'total' => 4650.00, 'items' => [[2, 1], [3, 1]]],
            ['date' => '2020-04-18', 'status' => 'Completed',  'paid' => 1, 'method' => 'cod',  'total' => 2500.00, 'items' => [[5, 1]]],
            ['date' => '2020-05-09', 'status' => 'Completed',  'paid' => 1, 'method' => 'bank', 'total' => 1800.00, 'items' => [[6, 1]]],
            ['date' => '2020-06-21', 'status' => 'Return',     'paid' => 1, 'method' => 'cod',  'total' => 850.00,  'items' => [[3, 1]]],
            ['date' => '2020-07-05', 'status' => 'Pending',    'paid' => 0, 'method' => 'cod',  'total' => 300.00,  'items' => [[4, 1]]],
            ['date' => '2020-08-16', 'status' => 'Completed',  'paid' => 1, 'method' => 'bank', 'total' => 550.00,  'items' => [[7, 1]]],
        ];

        foreach ($orders as $index => $order) {
            $createdAt = $order['date'] . ' 10:00:00';

            $invoiceId = DB::table('invoices')->insertGetId([
                'customer_email' => 'customer@example.com',
                'customer_id'    => (string) $userId,
                'country_code'   => 'PH',
                'payment_id'     => 'DEMO-' . strtoupper(uniqid()),
                'currency'       => 'PHP',
                'payment_status' => $order['paid'] ? 'COMPLETED' : 'PENDING',
                'price'          => $order['total'],
                'created_at'     => $createdAt,
                'updated_at'     => $createdAt,
            ]);

            $orderId = DB::table('orders')->insertGetId([
                'order_number'       => 'ORD-DEMO-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'status'             => $order['status'],
                'user_id'            => $userId,
                'invoice_id'         => $invoiceId,
                'grand_total'        => $order['total'],
                'item_count'         => count($order['items']),
                'payment_status'     => $order['paid'],
                'payment_method'     => $order['method'],
                'image'              => null,
                'first_name'         => 'Juan',
                'last_name'          => 'Dela Cruz',
                'deliver_to'         => 'Maria Dela Cruz',
                'deliver_to_address' => '123 Rizal Street, Quezon City',
                'address'            => '123 Rizal Street, Quezon City',
                'city'               => 'Quezon City',
                'zip_code'           => '1100',
                'phone_number'       => '09171234567',
                'notes'              => 'Demo order ' . ($index + 1),
                'created_at'         => $createdAt,
                'updated_at'         => $createdAt,
            ]);

            foreach ($order['items'] as $line) {
                DB::table('suborders')->insert([
                    'item_id'    => $itemIds[$line[0]],
                    'order_id'   => $orderId,
                    'price'      => $items[$line[0]]['price'],
                    'quantity'   => $line[1],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }

            if ($order['status'] === 'On Delivery') {
                DB::table('deliveries')->insert([
                    'order_id'     => $orderId,
                    'customer_name'=> 'Juan Dela Cruz',
                    'ETA'          => '2020-03-12',
                    'created_at'   => $createdAt,
                    'updated_at'   => $createdAt,
                ]);
            }
        }

        $customOrders = [
            ['date' => '2020-01-20', 'price' => 1500.00, 'qty' => 1, 'description' => 'Custom painted Gameboy shell'],
            ['date' => '2020-02-22', 'price' => 2200.00, 'qty' => 2, 'description' => 'Custom controller with logo'],
            ['date' => '2020-03-25', 'price' => 900.00,  'qty' => 1, 'description' => 'Engraved memory card case'],
            ['date' => '2020-04-28', 'price' => 3200.00, 'qty' => 3, 'description' => 'Custom retro console bundle'],
            ['date' => '2020-05-30', 'price' => 1100.00, 'qty' => 1, 'description' => 'Custom game cartridge label'],
            ['date' => '2020-06-11', 'price' => 1750.00, 'qty' => 2, 'description' => 'Personalized gaming shirt'],
        ];

        foreach ($customOrders as $index => $customOrder) {
            $createdAt = $customOrder['date'] . ' 14:00:00';

            $customOrderId = DB::table('custom_orders')->insertGetId([
                'user_id'        => $userId,
                'name'           => 'Custom Order ' . ($index + 1),
                'image'          => null,
                'status'         => $index % 3,
                'payment_status' => 1,
                'payment_method' => 'cod',
                'quantity'       => $customOrder['qty'],
                'description'    => $customOrder['description'],
                'price'          => $customOrder['price'],
                'completed'      => $index < 4 ? 1 : 0,
                'proof_image'    => null,
                'address'        => '123 Rizal Street, Quezon City',
                'city'           => 'Quezon City',
                'zip_code'       => '1100',
                'created_at'     => $createdAt,
                'updated_at'     => $createdAt,
            ]);

            if ($index < 3) {
                DB::table('custom_deliveries')->insert([
                    'custom_order_id' => $customOrderId,
                    'customer_name'   => 'Juan Dela Cruz',
                    'status'          => 'Delivered',
                    'ETA'             => $customOrder['date'],
                    'created_at'      => $createdAt,
                    'updated_at'      => $createdAt,
                ]);
            }
        }
    }
}
