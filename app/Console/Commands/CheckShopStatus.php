<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckShopStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pos:status {jam?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengecek status operasional Toko Kelontong POS';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $namaKasir = $this->ask('Masukkan nama kasir : ') ?? "User";
        $jam = $this->argument('jam') ?? 10;
        $this->info('=== SISTEM MONITORING TOKO KELONTONG ===');

        if ($jam >= 8 && $jam <= 21) {
            $this->info("Halo $namaKasir Status Toko pada jam $jam:00 WIB adalah: BUKA");
            $this->comment("Silahkan kasir bersiap di meja transaksi");

        } else if ($jam >= 24) {
            $this->error("Jam yang anda masukkan tidak valid. Yang valid : 00.00 - 23.00");

        } else {
            $this->error("Halo $namaKasir Status toko pada jam $jam:00 adalah: TUTUP");
            $this->warn("Akses transaksi di kasir di nonaktifkan sementara");
        }
    }
}
