<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramController extends Controller
{
    public function getMedia()
    {
        $token = env('INSTAGRAM_ACCESS_TOKEN');

        // Ambil daftar media utama
        $url    = 'https://graph.instagram.com/me/media';
        $fields = 'id,caption,media_type,media_url,permalink,timestamp';

        $response = Http::get($url, [
            'fields'       => $fields,
            'access_token' => $token,
        ]);

        if (! $response->successful()) {
            Log::error('Instagram media error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            $posts = [];
        } else {
            $posts = $response->json('data') ?? [];
        }

        // Tambahkan children untuk CAROUSEL_ALBUM
        foreach ($posts as &$post) {
            if (($post['media_type'] ?? null) === 'CAROUSEL_ALBUM') {
                $mediaId = $post['id'];

                $childrenResp = Http::get("https://graph.instagram.com/{$mediaId}/children", [
                    'fields'       => 'id,media_type,media_url,permalink,timestamp',
                    'access_token' => $token,
                ]);

                if ($childrenResp->successful()) {
                    $post['children'] = $childrenResp->json('data') ?? [];
                } else {
                    Log::warning('Instagram children error', [
                        'media_id' => $mediaId,
                        'status'   => $childrenResp->status(),
                        'body'     => $childrenResp->body(),
                    ]);
                    $post['children'] = [];
                }
            }
        }

        return view('instagram.feed', compact('posts'));
    }
}
