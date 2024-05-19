<?php

use App\Models\User;
use App\Models\Work;
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
        Schema::create('work_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Work::class)->constrained();

            $table->unsignedInteger('expected_salary');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_applications');
    }
};