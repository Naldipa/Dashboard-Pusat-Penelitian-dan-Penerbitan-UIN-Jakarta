<?php

namespace App\Http\Controllers;

use App\Models\Penelitian;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PenelitianImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $file = $request->file('file_excel');

        if (! $file->isValid()) {
            return back()->withErrors(['file_excel' => 'File upload tidak valid.']);
        }

        $path = $file->getRealPath();
        $handle = fopen($path, 'r');

        if (! $handle) {
            return back()->withErrors(['file_excel' => 'File tidak bisa dibaca.']);
        }

        $header = null;
        $count  = 0;

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            // Skip baris kosong
            if ($row === [null] || $row === false) {
                continue;
            }

            // Baris pertama = header
            if ($header === null) {
                $header = array_map(fn ($h) => Str::of($h)->trim()->lower()->toString(), $row);
                continue;
            }

            $data = [];
            foreach ($row as $i => $value) {
                $key = $header[$i] ?? null;
                if ($key) {
                    $data[$key] = $value;
                }
            }

            if (! isset($data['judul']) || trim($data['judul']) === '') {
                continue;
            }

            $fakultasRaw = $data['fakultas'] ?? '';
            $fakultas    = $this->mapFakultas($fakultasRaw);

            Penelitian::create([
                'judul'           => $data['judul'] ?? '-',
                'penulis_utama'   => $data['penulis_utama'] ?? null,
                'anggota_penulis' => $data['anggota_penulis'] ?? null,
                'fakultas'        => $fakultas,
                'tahun'           => isset($data['tahun']) ? (int) $data['tahun'] : now()->year,
                'status'          => $data['status'] ?? null,
                // kalau ada kolom abstrak di DB dan di CSV:
                // 'abstrak'         => $data['abstrak'] ?? null,
            ]);

            $count++;
        }

        fclose($handle);

        return back()->with('success', "Berhasil mengimport {$count} baris data penelitian.");
    }

    private function mapFakultas(string $value): string
    {
        $slug = Str::of($value)->lower();

        if ($slug->contains(['tarbiyah', 'fitk'])) {
            return 'Fakultas Ilmu Tarbiyah dan Keguruan';
        }

        if ($slug->contains(['adab', 'fah'])) {
            return 'Fakultas Adab dan Humaniora';
        }

        if ($slug->contains('ushuluddin')) {
            return 'Fakultas Ushuluddin';
        }

        if ($slug->contains(['syariah', 'hukum'])) {
            return 'Fakultas Syariah dan Hukum';
        }

        if ($slug->contains(['dakwah', 'komunikasi'])) {
            return 'Fakultas Ilmu Dakwah dan Komunikasi';
        }

        if ($slug->contains('dirasat')) {
            return 'Fakultas Dirasat Islamiyah';
        }

        if ($slug->contains('psikologi')) {
            return 'Fakultas Psikologi';
        }

        if ($slug->contains(['ekonomi', 'bisnis'])) {
            return 'Fakultas Ekonomi dan Bisnis';
        }

        if ($slug->contains(['sains', 'teknologi', 'fst'])) {
            return 'Fakultas Sains dan Teknologi';
        }

        if ($slug->contains(['kesehatan', 'kesehatan masyarakat'])) {
            return 'Fakultas Ilmu Kesehatan';
        }

        if ($slug->contains('kedokteran')) {
            return 'Fakultas Kedokteran';
        }

        if ($slug->contains(['fisip', 'sosial', 'politik'])) {
            return 'Fakultas Ilmu Sosial dan Ilmu Politik';
        }

        if ($slug->contains(['pasca', 'pasca sarjana'])) {
            return 'Sekolah Pasca Sarjana';
        }

        return 'Unit Lain';
    }
}
