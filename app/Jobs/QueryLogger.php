<?php

namespace App\Jobs;

use App\Payloads\QueryLoggerPayload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class QueryLogger implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected QueryLoggerPayload $payload;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(QueryLoggerPayload $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('==== start query ====');
        Log::info('duration: ' . $this->payload->duration);
        Log::info('sql: ' . $this->payload->sql);
        Log::info('bindings: ' . implode(", ", $this->payload->bindings));
        Log::info('==== end query ====' . "\n");
    }
}
