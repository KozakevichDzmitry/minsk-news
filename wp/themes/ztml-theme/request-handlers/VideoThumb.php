<?php

/**
 * INFO:
 * https://gist.github.com/pepebe/10380093
 * https://bezumkin.ru/sections/blog/441
 * https://stackovergo.com/ru/q/415183/how-do-i-get-a-youtube-video-thumbnail-from-the-youtube-api
 */
class VideoThumb
{
    protected const DIRNAME = 'youtube_thumbnail';
    protected const imagesPath = WP_CONTENT_DIR . '/uploads/' . self::DIRNAME . '/';
    protected const imagesUrl = WP_CONTENT_URL . '/uploads/' . self::DIRNAME . '/';

    public static function getYoutubeThumbnail($url)
    {
        $id = self::getYoutubeIdFromUrl($url);
        $thumbnails = self::getThumbnail($id);
        if (!empty($thumbnails['webp']) || !empty($thumbnails['jpg'])) return $thumbnails;
        return self::getRemoteImages($id);
    }

    public static function getYoutubeIdFromUrl($url): string
    {
        preg_match('/(http(s|):|)?\/?\/?(www\.|)yout(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $results);
        return $results[6];
    }

    public static function getRemoteImages($id): array
    {
        $resolution = array(
            'maxresdefault',
            'sddefault',
            'mqdefault',
            'hqdefault',
            'default'
        );

        $images = [];

        self::folderCreate();

        foreach ($resolution as $res) {
            $url = 'https://i.ytimg.com/vi_webp/' . $id . '/' . $res . '.webp';
            $response = self::Curl($url);
            if (!empty($response)) {
                $filename = $id . '.webp';
                if (file_put_contents(self::imagesPath . $filename, $response)) {
                    $images['webp'] = self::imagesUrl . $filename;
                }
                break;
            }
        }

        foreach ($resolution as $res) {
            $url = 'https://i.ytimg.com/vi/' . $id . '/' . $res . '.jpg';
            $response = self::Curl($url);
            if (!empty($response)) {
                $filename = $id . '.jpg';
                if (file_put_contents(self::imagesPath . $filename, $response)) {
                    $images['jpg'] = self::imagesUrl . $filename;
                }
                break;
            }
        }
        if (empty($images)) {
            $images['empty'] = self::imagesUrl . '_empty.jpg';
        }

        return $images;
    }

    public  static function folderCreate()
    {
        if (!file_exists(self::imagesPath)) {
            mkdir(WP_CONTENT_DIR . '/uploads/' . self::DIRNAME , 0755);
        }
    }
    public static function Curl($url = '')
    {
        if (empty($url)) {
            return false;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);

        $data = curl_exec($ch);
        return $data;
    }

    public static function getThumbnail($id)
    {
        $thumbnails = [];
        if (file_exists(self::imagesPath . $id . '.jpg')) $thumbnails['jpg'] = self::imagesUrl . $id . '.jpg';
        if (file_exists(self::imagesPath . $id . '.webp')) $thumbnails['webp'] = self::imagesUrl . $id . '.webp';

        return $thumbnails;
    }

}