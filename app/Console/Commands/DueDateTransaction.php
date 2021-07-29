<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Illuminate\Console\Command;

class DueDateTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:duedate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Status to Due Date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Transaction::whereDate('due_date','<=',now())->update(['status' => 1]);
    }
}
