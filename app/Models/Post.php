<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Elasticquent\ElasticquentTrait;

class Post extends Model
{
    use HasFactory, ElasticquentTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'published_at'
    ];

    protected $mappingProperties = [
        'title' => [
          'type' => 'text',
          "analyzer" => "standard",
        ],
        'description' => [
          'type' => 'text',
          "analyzer" => "standard",
        ],
        'user_id' => [
          'type' => 'text',
          "analyzer" => "standard",
        ],
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
