<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CopyCountriesToSqlite extends Command
{
    protected $signature = 'countries:copy-to-sqlite';
    protected $description = 'Copia los 250 países de Postgres a SQLite para que se vean en la web';

    public function handle()
    {
        $this->info('Copiando 250 países a SQLite...');

        DB::connection('pgsql')
            ->table('countries')
            ->orderBy('name')
            ->chunk(100, function ($paises) {
                foreach ($paises as $p) {
                    DB::table('countries')->updateOrInsert(
                        ['id' => $p->id],
                        [
                            'name'       => $p->name,
                            'capital'    => $p->capital,
                            'population' => $p->population,
                            'region'     => $p->region,
                            'flag_url'   => $p->flag_url,
                            'created_at' => $p->created_at ?? now(),
                            'updated_at' => $p->updated_at ?? now(),
                        ]
                    );
                }
            });

        $this->info('¡Listo! 250 países copiados a SQLite. Abre /countries ahora.');
    }
}