<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('model_rs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->integer('BOR'); // Bed Occupancy Rate (%)
            $table->integer('LOS'); // Length of Stay (hari)
            $table->integer('TOI'); // Turn Over Interval (hari)
            $table->integer('BTO'); // Bed Turn Over (kali)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('model_rs');
    }
};
