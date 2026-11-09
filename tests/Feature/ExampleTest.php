<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_redirects_guest_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_admin_pengelola_page_loads(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->get('/admin/pengelola');

        $response->assertOk();
    }

    public function test_pengelola_reservasi_supports_search_and_pagination(): void
    {
        $user = User::factory()->create([
            'name' => 'Pengelola Test',
            'email' => 'pengelola@example.com',
            'role' => 'pengelola',
            'password' => bcrypt('password123'),
        ]);

        foreach (range(1, 15) as $i) {
            \App\Models\Reservasi::create([
                'nama_tamu' => 'Rizki',
                'jumlah_pax' => 2,
                'status' => 'pending',
                'tanggal' => now()->addDays($i)->toDateString(),
            ]);
        }

        $response = $this->actingAs($user)->get('/pengelola/reservasi-manual?search=Rizki');

        $response->assertOk();
        $response->assertSee('Cari');
        $response->assertSee('Menampilkan');
    }

    public function test_pengelola_login_redirects_to_pengelola_dashboard(): void
    {
        $user = User::factory()->create([
            'name' => 'Pengelola Test',
            'email' => 'pengelola@example.com',
            'role' => 'pengelola',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->from('/pengelola/login')->post('/pengelola/login', [
            'email' => 'pengelola@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/pengelola');
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_login_redirects_to_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin Test 2',
            'email' => 'admin2@example.com',
            'role' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => 'admin2@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_pengelola_login_ignores_stale_admin_intended_url(): void
    {
        $user = User::factory()->create([
            'name' => 'Pengelola Stale',
            'email' => 'pengelola-stale@example.com',
            'role' => 'pengelola',
            'password' => bcrypt('password123'),
        ]);

        $this->withSession(['url.intended' => '/admin'])
            ->from('/pengelola/login')
            ->post('/pengelola/login', [
                'email' => 'pengelola-stale@example.com',
                'password' => 'password123',
            ])
            ->assertRedirect('/pengelola');

        $this->assertAuthenticatedAs($user);
    }

    public function test_pengunjung_logged_in_user_is_redirected_to_dashboard_from_generic_login(): void
    {
        $user = User::factory()->create([
            'name' => 'Pengunjung Test',
            'email' => 'pengunjung@example.com',
            'role' => 'pengunjung',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/');
    }

    public function test_pengunjung_booking_is_saved_and_shown_in_ticket_history(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'name' => 'Pengunjung Booking',
            'email' => 'booking@example.com',
            'role' => 'pengunjung',
        ]);

        $response = $this->actingAs($user)->post('/pembayaran/proses', [
            'nama_pengunjung' => $user->name,
            'email' => $user->email,
            'no_hp' => '081234567890',
            'tanggal_kunjungan' => now()->addDay()->toDateString(),
            'jumlah_tiket' => 2,
            'metode_pembayaran' => 'qris',
            'cart_data' => json_encode([
                ['id' => 1, 'name' => 'Tiket Masuk', 'price' => 30000, 'qty' => 2],
            ]),
            'bukti_pembayaran' => UploadedFile::fake()->create('bukti.jpg', 10, 'image/jpeg'),
        ]);

        $response->assertRedirect('/tiket');
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'email' => $user->email,
            'nama_lengkap' => $user->name,
            'jumlah_pengunjung' => 2,
            'total_bayar' => 60000,
            'status' => 'pending',
        ]);

        $booking = \App\Models\Booking::where('user_id', $user->id)->firstOrFail();
        Storage::disk('public')->assertExists($booking->bukti_pembayaran);

        $this->get('/tiket')
            ->assertOk()
            ->assertSee($booking->booking_code);
    }

    public function test_invalid_booking_shows_validation_error_in_booking_form(): void
    {
        $user = User::factory()->create(['role' => 'pengunjung']);

        $this->actingAs($user)
            ->from('/booking')
            ->post('/pembayaran/proses', [
                'nama_pengunjung' => $user->name,
                'email' => $user->email,
                'no_hp' => '081234567890',
                'tanggal_kunjungan' => now()->addDay()->toDateString(),
                'jumlah_tiket' => 1,
                'metode_pembayaran' => 'qris',
                'cart_data' => '[]',
                'bukti_pembayaran' => UploadedFile::fake()->create('bukti.jpg', 10, 'image/jpeg'),
            ])
            ->assertRedirect('/booking')
            ->assertSessionHasErrors(['cart_data']);

        $this->get('/booking')
            ->assertOk()
            ->assertSeeText('Booking belum tersimpan')
            ->assertSeeText('Keranjang kosong');
    }

    public function test_seeded_packages_are_visible_on_the_visitor_catalog(): void
    {
        $this->seed(\Database\Seeders\PaketSeeder::class);

        $user = User::factory()->create(['role' => 'pengunjung']);

        $this->actingAs($user)
            ->get('/wisata')
            ->assertOk()
            ->assertSeeText('Tiket Masuk WNI')
            ->assertSeeText('Tiket Masuk WNA')
            ->assertSeeText('Paket WNI + Shuttle')
            ->assertSeeText('Shuttle Ontang-anting PP')
            ->assertSeeText('Jembatan Ponton');
    }

    public function test_404_error_page_is_user_friendly(): void
    {
        $response = $this->get('/route-yang-tidak-ada');

        $response->assertNotFound();
        $response->assertSeeText('Halaman tidak ditemukan');
        $response->assertSeeText('Kembali ke beranda');
    }

    public function test_database_failure_shows_friendly_500_page(): void
    {
        Route::get('/db-error-test', function () {
            DB::statement('SELECT * FROM table_yang_tidak_ada_123456');
        });

        $response = $this->get('/db-error-test');

        $response->assertStatus(500);
        $response->assertSeeText('Layanan sedang terganggu');
        $response->assertSeeText('Kembali ke beranda');
    }
}
