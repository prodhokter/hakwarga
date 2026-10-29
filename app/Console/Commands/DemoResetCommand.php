<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DemoResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hw:demo-reset {--force-demo : Force execution in production environment}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset database and re-seed demo scenarios (blocked in production without --force-demo)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->laravel->isProduction() && ! $this->option('force-demo')) {
            $this->error('PERINGATAN: Perintah hw:demo-reset ditolak di lingkungan production demi mencegah kehilangan data.');
            $this->line('Gunakan opsi --force-demo jika Anda benar-benar yakin.');

            return self::FAILURE;
        }

        $this->info('Mereset basis data dan menjalankan migrasi ulang...');
        $this->call('migrate:fresh', [
            '--force' => true,
            '--seed' => true,
        ]);

        $this->info('Data demo simulasi berhasil diinisialisasi ulang.');

        return self::SUCCESS;
    }
}
