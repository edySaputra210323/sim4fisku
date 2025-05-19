<?php

namespace Database\Seeders;

use Closure;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\TahunAjaranSeeder;
use Database\Seeders\KategoriSuratSeeder;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        $this->command->warn(PHP_EOL . 'Creating superadmin...');
        $this->withProgressBar(1, fn() => User::factory(1)->create([
            'name' => 'Superadmin',
            'username' => 'superadmin',
            'email' => 'superadmin@larafila.com',
            'password' => bcrypt('12345678'),
        ]));
        $this->command->info('Superadmin user has been created successfully.');

        $this->call([
            KategoriSuratSeeder::class,
            TahunAjaranSeeder::class,
        ]);
    }

    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);
        $progressBar->start();
        $items = new Collection();

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->getOutput()->writeln('');

        return $items;
    }
}
