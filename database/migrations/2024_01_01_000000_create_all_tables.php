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
        // Users Table
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('role_id')->nullable();
                $table->string('avatar')->nullable();
                $table->string('name');
                $table->string('last_name')->nullable();
                $table->string('cpf')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->boolean('logged_in')->default(false);
                $table->boolean('banned')->default(false);
                $table->unsignedBigInteger('inviter')->nullable();
                $table->string('inviter_code')->nullable();
                $table->decimal('affiliate_revenue_share', 10, 2)->default(0);
                $table->decimal('affiliate_revenue_share_fake', 10, 2)->nullable();
                $table->decimal('affiliate_cpa', 10, 2)->default(0);
                $table->decimal('affiliate_baseline', 10, 2)->default(0);
                $table->boolean('is_demo_agent')->default(false);
                $table->boolean('is_admin')->default(false);
                $table->string('language')->default('pt_BR');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // Wallets Table
        if (!Schema::hasTable('wallets')) {
            Schema::create('wallets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('currency')->default('BRL');
                $table->string('symbol')->default('R$');
                $table->decimal('balance', 20, 2)->default(0);
                $table->decimal('balance_withdrawal', 20, 2)->default(0);
                $table->decimal('balance_deposit_rollover', 20, 2)->default(0);
                $table->decimal('balance_bonus', 20, 2)->default(0);
                $table->decimal('balance_bonus_rollover', 20, 2)->default(0);
                $table->decimal('balance_cryptocurrency', 20, 2)->default(0);
                $table->decimal('balance_demo', 20, 2)->default(0);
                $table->decimal('refer_rewards', 20, 2)->default(0);
                $table->decimal('total_bet', 20, 2)->default(0);
                $table->decimal('total_won', 20, 2)->default(0);
                $table->decimal('total_lose', 20, 2)->default(0);
                $table->decimal('last_won', 20, 2)->default(0);
                $table->decimal('last_lose', 20, 2)->default(0);
                $table->boolean('hide_balance')->default(false);
                $table->boolean('active')->default(true);
                $table->integer('vip_level')->default(0);
                $table->integer('vip_points')->default(0);
                $table->timestamps();
            });
        }

        // Settings Table
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('software_name')->nullable();
                $table->text('software_description')->nullable();
                $table->string('software_favicon')->nullable();
                $table->string('software_logo_white')->nullable();
                $table->string('software_logo_black')->nullable();
                $table->string('software_background')->nullable();
                $table->string('currency_code')->default('BRL');
                $table->integer('decimal_format')->default(2);
                $table->string('currency_position')->default('left');
                $table->string('prefix')->default('R$');
                $table->string('storage')->default('local');
                $table->decimal('min_deposit', 10, 2)->default(20);
                $table->decimal('max_deposit', 10, 2)->default(10000);
                $table->decimal('min_withdrawal', 10, 2)->default(50);
                $table->decimal('max_withdrawal', 10, 2)->default(10000);
                $table->decimal('bonus_vip', 10, 2)->default(0);
                $table->boolean('activate_vip_bonus')->default(false);
                $table->decimal('ngr_percent', 10, 2)->default(0);
                $table->decimal('revshare_percentage', 10, 2)->default(0);
                $table->boolean('revshare_reverse')->default(false);
                $table->decimal('soccer_percentage', 10, 2)->default(0);
                $table->boolean('turn_on_football')->default(false);
                $table->decimal('initial_bonus', 10, 2)->default(0);
                $table->decimal('rollover', 10, 2)->default(0);
                $table->decimal('rollover_deposit', 10, 2)->default(0);
                $table->boolean('suitpay_is_enable')->default(false);
                $table->boolean('stripe_is_enable')->default(false);
                $table->boolean('bspay_is_enable')->default(false);
                $table->decimal('withdrawal_limit', 10, 2)->default(0);
                $table->string('withdrawal_period')->default('daily');
                $table->boolean('disable_spin')->default(false);
                $table->decimal('perc_sub_lv1', 10, 2)->default(0);
                $table->decimal('perc_sub_lv2', 10, 2)->default(0);
                $table->decimal('perc_sub_lv3', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        // Custom Layouts Table
        if (!Schema::hasTable('custom_layouts')) {
            Schema::create('custom_layouts', function (Blueprint $table) {
                $table->id();
                $table->string('font_family_default')->nullable();
                $table->string('primary_color')->nullable();
                $table->string('primary_opacity_color')->nullable();
                $table->string('secundary_color')->nullable();
                $table->string('gray_dark_color')->nullable();
                $table->string('gray_light_color')->nullable();
                $table->string('gray_medium_color')->nullable();
                $table->string('gray_over_color')->nullable();
                $table->string('title_color')->nullable();
                $table->string('text_color')->nullable();
                $table->string('sub_text_color')->nullable();
                $table->string('placeholder_color')->nullable();
                $table->string('background_color')->nullable();
                $table->string('background_base')->nullable();
                $table->string('background_base_dark')->nullable();
                $table->string('input_primary')->nullable();
                $table->string('input_primary_dark')->nullable();
                $table->string('carousel_banners')->nullable();
                $table->string('carousel_banners_dark')->nullable();
                $table->string('sidebar_color')->nullable();
                $table->string('sidebar_color_dark')->nullable();
                $table->string('navtop_color')->nullable();
                $table->string('navtop_color_dark')->nullable();
                $table->string('side_menu')->nullable();
                $table->string('side_menu_dark')->nullable();
                $table->string('footer_color')->nullable();
                $table->string('footer_color_dark')->nullable();
                $table->string('card_color')->nullable();
                $table->string('card_color_dark')->nullable();
                $table->string('border_radius')->nullable();
                $table->text('custom_css')->nullable();
                $table->text('custom_js')->nullable();
                $table->timestamps();
            });
        }

        // Gateways Table
        if (!Schema::hasTable('gateways')) {
            Schema::create('gateways', function (Blueprint $table) {
                $table->id();
                $table->string('suitpay_uri')->nullable();
                $table->string('suitpay_cliente_id')->nullable();
                $table->string('suitpay_cliente_secret')->nullable();
                $table->boolean('stripe_production')->default(false);
                $table->string('stripe_public_key')->nullable();
                $table->string('stripe_secret_key')->nullable();
                $table->string('stripe_webhook_key')->nullable();
                $table->string('bspay_uri')->nullable();
                $table->string('bspay_cliente_id')->nullable();
                $table->string('bspay_cliente_secret')->nullable();
                $table->timestamps();
            });
        }

        // Providers Table
        if (!Schema::hasTable('providers')) {
            Schema::create('providers', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('name');
                $table->integer('rtp')->default(90);
                $table->boolean('status')->default(true);
                $table->string('distribution')->nullable();
                $table->integer('views')->default(0);
                $table->timestamps();
            });
        }

        // Categories Table
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }

        // Games Table
        if (!Schema::hasTable('games')) {
            Schema::create('games', function (Blueprint $table) {
                $table->id();
                $table->foreignId('provider_id')->constrained()->onDelete('cascade');
                $table->string('game_server_url')->nullable();
                $table->string('game_id')->unique();
                $table->string('game_name');
                $table->string('game_code')->nullable();
                $table->string('game_type')->nullable();
                $table->text('description')->nullable();
                $table->string('cover')->nullable();
                $table->boolean('status')->default(true);
                $table->string('technology')->default('html5');
                $table->boolean('has_lobby')->default(false);
                $table->boolean('is_mobile')->default(true);
                $table->boolean('has_freespins')->default(false);
                $table->boolean('has_tables')->default(false);
                $table->boolean('only_demo')->default(false);
                $table->integer('rtp')->default(90);
                $table->string('distribution')->nullable();
                $table->integer('views')->default(0);
                $table->boolean('is_featured')->default(false);
                $table->boolean('show_home')->default(true);
                $table->timestamps();
            });
        }

        // Orders Table
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('session_id')->nullable();
                $table->string('transaction_id')->nullable();
                $table->string('game')->nullable();
                $table->string('game_uuid')->nullable();
                $table->string('type')->nullable();
                $table->string('type_money')->nullable();
                $table->decimal('amount', 20, 2)->default(0);
                $table->string('providers')->nullable();
                $table->boolean('refunded')->default(false);
                $table->string('round_id')->nullable();
                $table->string('status')->default('pending');
                $table->timestamps();
            });
        }

        // Deposits Table
        if (!Schema::hasTable('deposits')) {
            Schema::create('deposits', function (Blueprint $table) {
                $table->id();
                $table->string('payment_id')->nullable();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->decimal('amount', 20, 2)->default(0);
                $table->string('type')->nullable();
                $table->string('proof')->nullable();
                $table->string('currency')->default('BRL');
                $table->string('symbol')->default('R$');
                $table->string('status')->default('pending');
                $table->timestamps();
            });
        }

        // Withdrawals Table
        if (!Schema::hasTable('withdrawals')) {
            Schema::create('withdrawals', function (Blueprint $table) {
                $table->id();
                $table->string('payment_id')->nullable();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->decimal('amount', 20, 2)->default(0);
                $table->string('type')->nullable();
                $table->text('bank_info')->nullable();
                $table->string('proof')->nullable();
                $table->string('pix_key')->nullable();
                $table->string('pix_type')->nullable();
                $table->string('currency')->default('BRL');
                $table->string('symbol')->default('R$');
                $table->string('status')->default('pending');
                $table->timestamps();
            });
        }

         // Affiliate Histories Table
         if (!Schema::hasTable('affiliate_histories')) {
            Schema::create('affiliate_histories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->unsignedBigInteger('inviter')->nullable();
                $table->decimal('commission', 20, 2)->default(0);
                $table->string('commission_type')->nullable();
                $table->boolean('deposited')->default(false);
                $table->decimal('deposited_amount', 20, 2)->default(0);
                $table->integer('losses')->default(0);
                $table->decimal('losses_amount', 20, 2)->default(0);
                $table->decimal('commission_paid', 20, 2)->default(0);
                $table->integer('status')->default(0);
                $table->timestamps();
            });
        }

        // Missions Table
        if (!Schema::hasTable('missions')) {
            Schema::create('missions', function (Blueprint $table) {
                $table->id();
                $table->string('challenge_name');
                $table->text('challenge_description')->nullable();
                $table->text('challenge_rules')->nullable();
                $table->string('challenge_type')->nullable();
                $table->string('challenge_link')->nullable();
                $table->dateTime('challenge_start_date')->nullable();
                $table->dateTime('challenge_end_date')->nullable();
                $table->decimal('challenge_bonus', 20, 2)->default(0);
                $table->integer('challenge_total')->default(0);
                $table->integer('influencer_winLength')->default(0);
                $table->integer('influencer_loseLength')->default(0);
                $table->string('challenge_currency')->default('BRL');
                $table->string('challenge_provider')->nullable();
                $table->string('challenge_gameid')->nullable();
                $table->timestamps();
            });
        }

        // Vips Table
        if (!Schema::hasTable('vips')) {
            Schema::create('vips', function (Blueprint $table) {
                $table->id();
                $table->string('bet_symbol')->default('R$');
                $table->integer('bet_level')->default(0);
                $table->decimal('bet_required', 20, 2)->default(0);
                $table->string('bet_period')->default('monthly');
                $table->decimal('bet_bonus', 20, 2)->default(0);
                $table->timestamps();
            });
        }
        
        // Game Favorites Table
        if (!Schema::hasTable('game_favorites')) {
            Schema::create('game_favorites', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('game_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }

        // Game Likes Table
        if (!Schema::hasTable('game_likes')) {
            Schema::create('game_likes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('game_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }

        // Mission Users Table
        if (!Schema::hasTable('mission_users')) {
            Schema::create('mission_users', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('mission_id')->constrained()->onDelete('cascade');
                $table->integer('rounds')->default(0);
                $table->boolean('claimed')->default(false);
                $table->timestamps();
            });
        }

        // Vip Users Table
        if (!Schema::hasTable('vip_users')) {
            Schema::create('vip_users', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('vip_id')->constrained()->onDelete('cascade');
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }
        
        // Category Game Table (Pivot)
        if (!Schema::hasTable('category_game')) {
            Schema::create('category_game', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->foreignId('game_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }

        // Spatie Permission Tables
        $tableNames = config('permission.table_names', [
            'roles' => 'roles',
            'permissions' => 'permissions',
            'model_has_permissions' => 'model_has_permissions',
            'model_has_roles' => 'model_has_roles',
            'role_has_permissions' => 'role_has_permissions',
        ]);

        if (!Schema::hasTable($tableNames['permissions'])) {
            Schema::create($tableNames['permissions'], function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('guard_name');
                $table->timestamps();
                $table->unique(['name', 'guard_name']);
            });
        }

        if (!Schema::hasTable($tableNames['roles'])) {
            Schema::create($tableNames['roles'], function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('guard_name');
                $table->timestamps();
                $table->unique(['name', 'guard_name']);
            });
        }

        if (!Schema::hasTable($tableNames['model_has_permissions'])) {
            Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames) {
                $table->unsignedBigInteger('permission_id');
                $table->string('model_type');
                $table->unsignedBigInteger('model_id');
                $table->index(['model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');

                $table->foreign('permission_id')
                    ->references('id')
                    ->on($tableNames['permissions'])
                    ->onDelete('cascade');

                $table->primary(['permission_id', 'model_id', 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            });
        }

        if (!Schema::hasTable($tableNames['model_has_roles'])) {
            Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames) {
                $table->unsignedBigInteger('role_id');
                $table->string('model_type');
                $table->unsignedBigInteger('model_id');
                $table->index(['model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');

                $table->foreign('role_id')
                    ->references('id')
                    ->on($tableNames['roles'])
                    ->onDelete('cascade');

                $table->primary(['role_id', 'model_id', 'model_type'],
                    'model_has_roles_role_model_type_primary');
            });
        }

        if (!Schema::hasTable($tableNames['role_has_permissions'])) {
            Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
                $table->unsignedBigInteger('permission_id');
                $table->unsignedBigInteger('role_id');

                $table->foreign('permission_id')
                    ->references('id')
                    ->on($tableNames['permissions'])
                    ->onDelete('cascade');

                $table->foreign('role_id')
                    ->references('id')
                    ->on($tableNames['roles'])
                    ->onDelete('cascade');

                $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
            });
        }
        // Games Keys Table
        if (!Schema::hasTable('games_keys')) {
            Schema::create('games_keys', function (Blueprint $table) {
                $table->id();
                $table->string('merchant_url')->nullable();
                $table->string('merchant_id')->nullable();
                $table->string('merchant_key')->nullable();
                
                // Games2 Api
                $table->string('games2_agent_code')->nullable();
                $table->string('games2_agent_token')->nullable();
                $table->string('games2_agent_secret_key')->nullable();
                $table->string('games2_api_endpoint')->nullable();
                
                // WorldSlot
                $table->string('worldslot_agent_code')->nullable();
                $table->string('worldslot_agent_token')->nullable();
                $table->string('worldslot_agent_secret_key')->nullable();
                $table->string('worldslot_api_endpoint')->nullable();
                
                // Fivers
                $table->string('agent_code')->nullable();
                $table->string('agent_token')->nullable();
                $table->string('agent_secret_key')->nullable();
                $table->string('api_endpoint')->nullable();
                
                // Salsa
                $table->string('salsa_base_uri')->nullable();
                $table->string('salsa_pn')->nullable();
                $table->string('salsa_key')->nullable();
                
                // Vibra
                $table->string('vibra_site_id')->nullable();
                $table->string('vibra_game_mode')->nullable();
                
                $table->timestamps();
            });
        }

        // GGR Games World Slots Table
        if (!Schema::hasTable('ggr_games_world_slots')) {
            Schema::create('ggr_games_world_slots', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('provider')->nullable();
                $table->string('game')->nullable();
                $table->decimal('balance_bet', 20, 2)->default(0);
                $table->decimal('balance_win', 20, 2)->default(0);
                $table->string('currency')->default('BRL');
                $table->timestamps();
            });
        }

        // GGR Games Fivers Table
        if (!Schema::hasTable('ggr_games_fivers')) {
            Schema::create('ggr_games_fivers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('provider')->nullable();
                $table->string('game')->nullable();
                $table->decimal('balance_bet', 20, 2)->default(0);
                $table->decimal('balance_win', 20, 2)->default(0);
                $table->string('currency')->default('BRL');
                $table->timestamps();
            });
        }

        // Spin Configs Table
        if (!Schema::hasTable('ggds_spin_config')) {
            Schema::create('ggds_spin_config', function (Blueprint $table) {
                $table->id();
                $table->longText('prizes')->nullable();
                $table->timestamps();
            });
        }

        // Setting Mails Table
        if (!Schema::hasTable('setting_mails')) {
            Schema::create('setting_mails', function (Blueprint $table) {
                $table->id();
                $table->string('software_smtp_type')->nullable();
                $table->string('software_smtp_mail_host')->nullable();
                $table->string('software_smtp_mail_port')->nullable();
                $table->string('software_smtp_mail_username')->nullable();
                $table->string('software_smtp_mail_password')->nullable();
                $table->string('software_smtp_mail_encryption')->nullable();
                $table->string('software_smtp_mail_from_address')->nullable();
                $table->string('software_smtp_mail_from_name')->nullable();
                $table->timestamps();
            });
        }

        // Affiliate Withdraws Table
        if (!Schema::hasTable('affiliate_withdraws')) {
            Schema::create('affiliate_withdraws', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('payment_id')->nullable();
                $table->decimal('amount', 20, 2)->default(0);
                $table->string('type')->nullable(); // pix, bank_transfer, etc.
                $table->string('pix_key')->nullable();
                $table->string('pix_type')->nullable();
                $table->text('bank_info')->nullable();
                $table->string('proof')->nullable();
                $table->string('currency')->default('BRL');
                $table->string('symbol')->default('R$');
                $table->integer('status')->default(0); // 0: pending, 1: approved, 2: rejected
                $table->timestamps();
            });
        }

        // Suit Pay Payments Table
        if (!Schema::hasTable('suit_pay_payments')) {
            Schema::create('suit_pay_payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('payment_id')->nullable();
                $table->unsignedBigInteger('withdrawal_id')->nullable();
                $table->string('pix_key')->nullable();
                $table->string('pix_type')->nullable();
                $table->decimal('amount', 20, 2)->default(0);
                $table->text('observation')->nullable();
                $table->string('status')->default('0'); // 0: pending, 1: paid
                $table->timestamps();
            });
        }

        // Banners Table
        if (!Schema::hasTable('banners')) {
            Schema::create('banners', function (Blueprint $table) {
                $table->id();
                $table->string('image');
                $table->string('type')->nullable();
                $table->string('description')->nullable();
                $table->string('link')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names', [
            'roles' => 'roles',
            'permissions' => 'permissions',
            'model_has_permissions' => 'model_has_permissions',
            'model_has_roles' => 'model_has_roles',
            'role_has_permissions' => 'role_has_permissions',
        ]);

        Schema::dropIfExists($tableNames['role_has_permissions']);
        Schema::dropIfExists($tableNames['model_has_roles']);
        Schema::dropIfExists($tableNames['model_has_permissions']);
        Schema::dropIfExists($tableNames['roles']);
        Schema::dropIfExists($tableNames['permissions']);
        
        Schema::dropIfExists('banners');
        Schema::dropIfExists('suit_pay_payments');
        Schema::dropIfExists('affiliate_withdraws');
        Schema::dropIfExists('setting_mails');
        Schema::dropIfExists('ggds_spin_config');
        Schema::dropIfExists('ggr_games_fivers');
        Schema::dropIfExists('ggr_games_world_slots');
        Schema::dropIfExists('games_keys');
        Schema::dropIfExists('category_game');
        Schema::dropIfExists('vip_users');
        Schema::dropIfExists('mission_users');
        Schema::dropIfExists('game_likes');
        Schema::dropIfExists('game_favorites');
        Schema::dropIfExists('vips');
        Schema::dropIfExists('missions');
        Schema::dropIfExists('affiliate_histories');
        Schema::dropIfExists('withdrawals');
        Schema::dropIfExists('deposits');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('games');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('providers');
        Schema::dropIfExists('gateways');
        Schema::dropIfExists('custom_layouts');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('wallets');
        Schema::dropIfExists('users');
    }
};
