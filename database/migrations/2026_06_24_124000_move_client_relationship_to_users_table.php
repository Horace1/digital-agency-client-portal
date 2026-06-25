<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('client_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->nullOnDelete();
        });

        DB::table('clients')
            ->whereNotNull('user_id')
            ->orderBy('id')
            ->each(function (object $client): void {
                DB::table('users')
                    ->where('id', $client->user_id)
                    ->update(['client_id' => $client->id]);
            });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->unique()
                ->after('id')
                ->constrained()
                ->nullOnDelete();
        });

        DB::table('clients')
            ->orderBy('id')
            ->each(function (object $client): void {
                $userId = DB::table('users')
                    ->where('client_id', $client->id)
                    ->orderBy('id')
                    ->value('id');

                if ($userId !== null) {
                    DB::table('clients')
                        ->where('id', $client->id)
                        ->update(['user_id' => $userId]);
                }
            });

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('client_id');
        });
    }
};
