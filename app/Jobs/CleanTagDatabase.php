<?php

namespace App\Jobs;

use App\Core\Domain\Repository\TagRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CleanTagDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tags = DB::table('tags')
            ->leftJoin('tag_to_articles', 'tags.id', '=', 'tag_to_articles.tag_id')
            ->groupBy('tags.id')
            ->select('tags.*', DB::raw('COUNT(tag_to_articles.id) as article_count'))
            ->having('article_count', '=', 0)
            ->get();

        $ids = [];
        foreach ($tags as $tag) {
            $ids[] = $tag->id;
        }

        DB::table('tags')->whereIn('id', $ids)->delete();
    }
}
