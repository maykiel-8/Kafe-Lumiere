<?php
// database/migrations/2024_01_01_000002_create_categories_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration {
    public function up(): void
    {
        // Categories (normalized - 2NF)
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });
 
        // Add-ons (normalized separate table)
        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 8, 2)->default(0);
            $table->timestamps();
        });
 
        // Products (2NF: category_id FK, not string)
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->enum('size', ['Tall (16oz)', 'Grande (22oz)', 'Both'])->default('Both');
            $table->decimal('price_tall', 8, 2);
            $table->decimal('price_grande', 8, 2)->nullable();
            $table->string('main_photo')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            $table->softDeletes(); // For restore functionality
 
            $table->index('category_id');
            $table->index('is_available');
        });
 
        // Product photos (multiple photos per product)
        Schema::create('product_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('path');
            $table->boolean('is_main')->default(false);
            $table->timestamps();
        });
 
        // Product <-> Addon pivot (many-to-many)
        Schema::create('product_addon', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('addon_id')->constrained()->onDelete('cascade');
            $table->primary(['product_id', 'addon_id']);
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('product_addon');
        Schema::dropIfExists('product_photos');
        Schema::dropIfExists('products');
        Schema::dropIfExists('addons');
        Schema::dropIfExists('categories');
    }
};
