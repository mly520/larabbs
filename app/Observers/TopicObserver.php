<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        // XSS対応
        $topic->body = clean($topic->body, 'user_topic_body');
        // 簡略文自動作成
        $topic->excerpt = make_excerpt($topic->body);
        // slug内容自動生成
        if ( ! $topic->slug) {
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }
}