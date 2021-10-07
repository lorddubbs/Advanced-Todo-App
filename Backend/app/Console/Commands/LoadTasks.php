<?php

namespace App\Console\Commands;

use App\Models\Task;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class LoadTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all task data to Elasticsearch';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Indexing all tasks...');

        foreach (Task::cursor() as $task)
        {
            $this->elasticsearch->index([
                'index' => $task->getSearchIndex(),
                'type' => $task->getSearchType(),
                'id' => $task->getKey(),
                'description' => $task->toSearchArray(),
            ]);

            $this->output->write('.');
        }

        $this->info("\nDone!");
    }
}
