<?php

namespace Database\Seeders;

use App\Models\AdvancePaymentSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdvancePaymentSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdvancePaymentSetting::create([
            'advance_payment_status' => false,
            'advance_payment_amount' => null,
        ]);
    }
}
