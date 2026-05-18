<?php

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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id(); //Relation : une ligne de budget appartient a un evenement
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('item_name'); // ex: location de salle", "gateau"
            $table->string('category')->nullable(); // ex: "Restoration", "Loisirs"

            // on utilise decimal pour l'argent (10 chiffres au total, 2 apres la virgule)
            $table->decimal('amount', 10, 2)->default(0); // montant prevu 
            $table->decimal('actual_amount', 10, 2)->default(0); // montant reellement paye
            $table->boolean('is_paid')->default(false); // est ce que c'est regle ?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
