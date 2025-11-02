<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\AcademicYear;
use App\Models\Term;

class CheckTermsTable extends Command
{
    protected $signature = 'check:terms';
    protected $description = 'Check the terms table structure and data';

    public function handle()
    {
        $this->info('Checking Terms Table...');

        // Check if table exists
        if (!Schema::hasTable('terms')) {
            $this->error('Terms table does not exist!');
            return 1;
        }

        // Check columns
        $columns = Schema::getColumnListing('terms');
        $this->info('Columns in terms table: ' . implode(', ', $columns));

        // Check if academic_year_id column exists
        $hasAcademicYearColumn = Schema::hasColumn('terms', 'academic_year_id');
        $this->info('Has academic_year_id column: ' . ($hasAcademicYearColumn ? 'Yes' : 'No'));

        // Get all terms
        $terms = Term::all();
        $this->info('Total terms: ' . $terms->count());

        // Display terms data
        $headers = ['ID', 'Name', 'Academic Year ID'];
        $rows = [];

        foreach ($terms as $term) {
            $rows[] = [
                $term->id,
                $term->name,
                $term->academic_year_id ?? 'NULL'
            ];
        }

        $this->table($headers, $rows);

        // Get all academic years
        $academicYears = AcademicYear::all();
        $this->info('Total academic years: ' . $academicYears->count());

        // Display academic years
        $headers = ['ID', 'Name'];
        $rows = [];

        foreach ($academicYears as $year) {
            $rows[] = [
                $year->id,
                $year->name
            ];
        }

        $this->table($headers, $rows);

        return 0;
    }
}
