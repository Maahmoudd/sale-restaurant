<?php

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Table::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Reservation::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Customer::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('total')->default(0);
            $table->boolean('paid')->default(0);
            $table->timestamp('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
