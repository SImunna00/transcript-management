<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DbInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display database connection information without using performance_schema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Get database connection info from config
            $connection = config('database.default');
            $dbConfig = config("database.connections.{$connection}");

            // Test the connection
            DB::select('SELECT 1');
            $connectionStatus = '<fg=green>Connected</>';
        } catch (\Exception $e) {
            $connectionStatus = '<fg=red>Failed: ' . $e->getMessage() . '</>';
        }

        // Display database information
        $this->components->info('Database Configuration:');
        $this->components->twoColumnDetail('Connection', $connection);
        $this->components->twoColumnDetail('Driver', $dbConfig['driver'] ?? 'unknown');
        $this->components->twoColumnDetail('Host', $dbConfig['host'] ?? 'unknown');
        $this->components->twoColumnDetail('Port', $dbConfig['port'] ?? 'unknown');
        $this->components->twoColumnDetail('Database', $dbConfig['database'] ?? 'unknown');
        $this->components->twoColumnDetail('Username', $dbConfig['username'] ?? 'unknown');
        $this->components->twoColumnDetail('Status', $connectionStatus);

        // Get table counts if connected
        if ($connectionStatus === '<fg=green>Connected</>') {
            try {
                // Get list of tables
                $tables = collect(DB::select("SHOW TABLES"))->map(function ($table) {
                    return collect($table)->first();
                });

                $this->newLine();
                $this->components->info('Database Tables: ' . count($tables));
                $this->table(['Table', 'Records'], $tables->map(function ($table) {
                    try {
                        $count = DB::table($table)->count();
                    } catch (\Exception $e) {
                        $count = 'Error counting';
                    }
                    return [$table, $count];
                })->toArray());
            } catch (\Exception $e) {
                $this->components->error('Error listing tables: ' . $e->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}
