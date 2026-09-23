<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Document;
use App\Models\DocumentVersion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Users
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@simdok.local',
            'password' => Hash::make('password'),
            'role' => User::ROLE_SUPER_ADMIN,
            'department' => 'PSTI',
            'is_active' => true,
        ]);

        $admin = User::create([
            'name' => 'Admin PSTI',
            'email' => 'admin2@simdok.local',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
            'department' => 'PSTI',
            'is_active' => true,
        ]);

        $reviewer = User::create([
            'name' => 'Reviewer Kaprodi',
            'email' => 'reviewer@simdok.local',
            'password' => Hash::make('password'),
            'role' => User::ROLE_REVIEWER,
            'department' => 'PSTI',
            'is_active' => true,
        ]);

        $biro = User::create([
            'name' => 'Staf Biro',
            'email' => 'biro@simdok.local',
            'password' => Hash::make('password'),
            'role' => User::ROLE_BIRO,
            'department' => 'Biro Administrasi',
            'is_active' => true,
        ]);

        $dosen = User::create([
            'name' => 'Dosen Pengajar',
            'email' => 'dosen@simdok.local',
            'password' => Hash::make('password'),
            'role' => User::ROLE_USER,
            'department' => 'PSTI',
            'is_active' => true,
        ]);

        // Create Categories
        $categories = [
            'RPS',
            'Portofolio Mata Kuliah',
            'Kurikulum',
            'Tracer Study',
            'Penelitian',
            'Pengabdian',
            'Akreditasi',
            'Audit Mutu',
            'Surat',
            'SK',
            'Undangan',
            'Notulen',
            'Berita Acara',
            'Bukti Kegiatan',
            'Kerja Sama',
            'Sertifikat',
            'Laporan'
        ];

        foreach ($categories as $index => $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'is_active' => true,
                'sort_order' => $index + 1
            ]);
        }

        $rpsCategory = Category::where('name', 'RPS')->first();
        $skCategory = Category::where('name', 'SK')->first();
        
        // Create Sample Documents
        
        // Draft Document
        Document::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'Draft RPS Pemrograman Web',
            'document_number' => 'RPS-PW-2026',
            'category_id' => $rpsCategory->id,
            'department' => 'PSTI',
            'academic_year' => '2026/2027',
            'semester' => 'Ganjil',
            'course_name' => 'Pemrograman Web',
            'pic' => 'Dosen Pengajar',
            'document_date' => '2026-09-01',
            'upload_date' => '2026-09-02',
            'original_uploaded_at' => now(),
            'status' => Document::STATUS_DRAFT,
            'current_version' => 1,
            'created_by' => $dosen->id,
        ]);

        // Submitted Document
        Document::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'RPS Basis Data',
            'document_number' => 'RPS-BD-2026',
            'category_id' => $rpsCategory->id,
            'department' => 'PSTI',
            'academic_year' => '2026/2027',
            'semester' => 'Ganjil',
            'course_name' => 'Basis Data',
            'pic' => 'Dosen Pengajar',
            'document_date' => '2026-09-05',
            'upload_date' => '2026-09-06',
            'original_uploaded_at' => now(),
            'status' => Document::STATUS_SUBMITTED,
            'current_version' => 1,
            'created_by' => $dosen->id,
        ]);

        // Approved Document
        $docApproved = Document::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'SK Mengajar Semester Ganjil 2026',
            'document_number' => 'SK/001/PSTI/2026',
            'category_id' => $skCategory->id,
            'department' => 'PSTI',
            'academic_year' => '2026/2027',
            'semester' => 'Ganjil',
            'pic' => 'Admin PSTI',
            'document_date' => '2026-08-20',
            'upload_date' => '2026-08-21',
            'original_uploaded_at' => now()->subMonth(),
            'status' => Document::STATUS_APPROVED,
            'current_version' => 1,
            'created_by' => $admin->id,
            'approved_by' => $reviewer->id,
            'approved_at' => now()->subWeeks(3),
        ]);

        // Archived Document
        Document::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'SK Mengajar Semester Ganjil 2025',
            'document_number' => 'SK/001/PSTI/2025',
            'category_id' => $skCategory->id,
            'department' => 'PSTI',
            'academic_year' => '2025/2026',
            'semester' => 'Ganjil',
            'pic' => 'Admin PSTI',
            'document_date' => '2025-08-20',
            'upload_date' => '2025-08-21',
            'original_uploaded_at' => now()->subYear(),
            'status' => Document::STATUS_ARCHIVED,
            'current_version' => 1,
            'created_by' => $admin->id,
            'approved_by' => $reviewer->id,
            'approved_at' => now()->subYear()->addDays(5),
            'archived_at' => now(),
        ]);
    }
}
