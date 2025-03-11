<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Faker\Factory as Faker;

class BulkCreatePost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $user;

    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $userId = $this->user->id;
        $dataPosts = $this->dumpDataPost($userId);
        $this->user->createPosts($dataPosts);
    }

    public function dumpDataPost($userId)
    {
        $response = [];
        $faker = Faker::create();
        foreach(range(1, 10) as $key => $value)
        {
            array_push($response, [
                'user_id' => $userId,
                'title' => $faker->name,
                'description' => $faker->text,
                'published_at' => \Carbon\Carbon::now()
            ]);
        }
        return $response;
    }

}
