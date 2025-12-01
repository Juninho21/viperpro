<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $affiliateRole = Role::firstOrCreate(['name' => 'afiliado', 'guard_name' => 'web']);

        // Create Admin User
        $user = User::firstOrCreate(
            ['email' => 'admin@hotmail.com'],
            [
                'name' => 'Admin',
                'password' => '123456', // The model mutator will hash this
                'role_id' => 1,
                'is_admin' => true,
                'phone' => '1234567890',
                'cpf' => '00000000000',
            ]
        );

        // Assign Role
        $user->assignRole($adminRole);

        // Create Wallet for Admin
        Wallet::firstOrCreate(
            ['user_id' => $user->id],
            [
                'currency' => 'BRL',
                'symbol' => 'R$',
                'balance' => 1000.00,
                'active' => true,
            ]
        );

        // Create Default Settings
        if (Setting::count() == 0) {
            Setting::create([
                'software_name' => 'ViperPro',
                'software_description' => 'ViperPro Casino Script',
                'currency_code' => 'BRL',
                'decimal_format' => 2,
                'currency_position' => 'left',
                'prefix' => 'R$',
                'min_deposit' => 20,
                'max_deposit' => 10000,
                'min_withdrawal' => 50,
                'max_withdrawal' => 10000,
                'suitpay_is_enable' => false,
                'stripe_is_enable' => false,
                'bspay_is_enable' => false,
            ]);
        }

        // Create or Update Default Games Keys
        $gamesKey = \App\Models\GamesKey::first();
        if (!$gamesKey) {
            \App\Models\GamesKey::create([
                'merchant_url' => 'https://api.example.com',
                'merchant_id' => 'demo',
                'merchant_key' => 'demo',
                'worldslot_api_endpoint' => 'https://api.worldslot.com/',
                'games2_api_endpoint' => 'https://api.games2.com/',
                'api_endpoint' => 'https://api.fivers.com/',
                'salsa_base_uri' => 'https://api.salsa.com/',
            ]);
        } else {
            $gamesKey->update([
                'worldslot_api_endpoint' => 'https://api.worldslot.com/',
                'games2_api_endpoint' => 'https://api.games2.com/',
                'api_endpoint' => 'https://api.fivers.com/',
                'salsa_base_uri' => 'https://api.salsa.com/',
            ]);
        }

        // Create Default Spin Config
        if (\App\Models\SpinConfigs::count() == 0) {
            \App\Models\SpinConfigs::create([
                'prizes' => json_encode([
                    ['id' => 1, 'name' => 'R$ 10,00', 'type' => 'money', 'value' => 10, 'percent' => 10, 'bgcolor' => '#ff0000', 'textcolor' => '#ffffff'],
                    ['id' => 2, 'name' => 'R$ 50,00', 'type' => 'money', 'value' => 50, 'percent' => 5, 'bgcolor' => '#00ff00', 'textcolor' => '#000000'],
                    ['id' => 3, 'name' => 'Tente Novamente', 'type' => 'empty', 'value' => 0, 'percent' => 85, 'bgcolor' => '#0000ff', 'textcolor' => '#ffffff'],
                ]),
            ]);
        }

        // Create Default Mail Settings
        if (\App\Models\SettingMail::count() == 0) {
            \App\Models\SettingMail::create([
                'software_smtp_type' => 'smtp',
                'software_smtp_mail_host' => 'smtp.mailtrap.io',
                'software_smtp_mail_port' => '2525',
                'software_smtp_mail_username' => null,
                'software_smtp_mail_password' => null,
                'software_smtp_mail_encryption' => 'tls',
                'software_smtp_mail_from_address' => 'admin@viperpro.com',
                'software_smtp_mail_from_name' => 'ViperPro Admin',
            ]);
        }

        // Create Default Custom Layout
        if (\App\Models\CustomLayout::count() == 0) {
            \App\Models\CustomLayout::create([
                'background_base' => '#0f172a',
                'background_base_dark' => '#0f172a',
                'carousel_banners' => '#1e293b',
                'carousel_banners_dark' => '#1e293b',
                'sidebar_color' => '#1e293b',
                'sidebar_color_dark' => '#1e293b',
                'navtop_color' => '#1e293b',
                'navtop_color_dark' => '#1e293b',
                'side_menu' => '#1e293b',
                'side_menu_dark' => '#1e293b',
                'footer_color' => '#1e293b',
                'footer_color_dark' => '#1e293b',
                'primary_color' => '#3b82f6',
                'primary_opacity_color' => '#3b82f6',
                'input_primary' => '#334155',
                'input_primary_dark' => '#334155',
                'card_color' => '#1e293b',
                'card_color_dark' => '#1e293b',
                'secundary_color' => '#64748b',
                'gray_dark_color' => '#334155',
                'gray_light_color' => '#94a3b8',
                'gray_medium_color' => '#64748b',
                'gray_over_color' => '#475569',
                'title_color' => '#ffffff',
                'text_color' => '#cbd5e1',
                'sub_text_color' => '#94a3b8',
                'placeholder_color' => '#64748b',
                'background_color' => '#0f172a',
                'border_radius' => '0.5rem',
            ]);
        }
    }
}
