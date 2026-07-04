<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_transaction_export_returns_excel_file(): void
    {
        $user = User::factory()->create();
        Transaction::factory()->create([
            'transaction_code' => 'TRX-001',
            'user_id' => $user->id,
            'description' => 'Test export transaction',
            'type' => 'income',
            'amount' => 125000,
            'payment_method' => 'cash',
            'status' => 'completed',
        ]);

        $response = $this->actingAs($user)->get(route('transactions.export'));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}
