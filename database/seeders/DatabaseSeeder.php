<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Roles;
use App\Models\Users;
use App\Models\PaymentMethods;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        // Create 'admin' role
        $adminRole = Roles::create([
            'name' => 'admin',
        ]);

        // Create 'user' role
        $userRole = Roles::create([
            'name' => 'user',
        ]);

        // Create 'admin' user
        $adminPassword = Hash::make('admin');
        $adminUser = Users::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@montero.com',
            'password' => $adminPassword,
            'role_id' => $adminRole->_id,
        ]);

        // Create 'user' user
        $userPassword = Hash::make('user');
        $userUser = Users::create([
            'first_name' => 'User',
            'last_name' => 'User',
            'email' => 'user@montero.com',
            'password' => $userPassword,
            'role_id' => $userRole->_id,
        ]);

        // Create 'cash' payment method
        $cashPaymentMethod = PaymentMethods::create([
            'name' => 'Efectivo',
        ]);

        // Create 'credit card' payment method
        $creditCardPaymentMethod = PaymentMethods::create([
            'name' => 'Tarjeta de crédito',
        ]);

        // Create 'debit card' payment method
        $debitCardPaymentMethod = PaymentMethods::create([
            'name' => 'Tarjeta de débito',
        ]);

        // Create 'bank transfer' payment method
        $bankTransferPaymentMethod = PaymentMethods::create([
            'name' => 'Transferencia bancaria',
        ]);

        // Create 'paypal' payment method
        $paypalPaymentMethod = PaymentMethods::create([
            'name' => 'Paypal',
        ]);
    }
}
