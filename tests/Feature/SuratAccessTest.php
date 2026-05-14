<?php

namespace Tests\Feature;

use App\Models\Surat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SuratAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_cannot_delete_surat(): void
    {
        $staff = $this->user('staff');
        $surat = $this->surat($staff);

        $response = $this->actingAs($staff)->delete(route('surat.destroy', $surat));

        $response->assertForbidden();
        $this->assertDatabaseHas('surats', ['id' => $surat->id]);
    }

    public function test_surat_rahasia_can_be_locked_again(): void
    {
        $staff = $this->user('staff');
        $this->surat($staff, ['kategori' => 'rahasia']);

        $response = $this
            ->actingAs($staff)
            ->withSession(['rahasia_verified' => true])
            ->post(route('surat.rahasia.lock'));

        $response
            ->assertRedirect(route('surat.rahasia'))
            ->assertSessionMissing('rahasia_verified');
    }

    private function user(string $role): User
    {
        return User::create([
            'name' => ucfirst($role),
            'email' => "{$role}@example.test",
            'password' => Hash::make('password'),
            'role' => $role,
            'status' => 'active',
        ]);
    }

    private function surat(User $creator, array $attributes = []): Surat
    {
        return Surat::create(array_merge([
            'kode_surat' => 'SM/TEST/001',
            'nama_surat' => 'Surat Test',
            'jenis_surat' => 'masuk',
            'kategori' => 'umum',
            'tanggal_surat' => now()->toDateString(),
            'status' => 'aktif',
            'created_by' => $creator->id,
        ], $attributes));
    }
}
