<?php

namespace ApiSdk;

use ApiSdk\Contracts\RequestProvider;

class FilesApi
{
    /**
     * @var RequestProvider
     */
    public $provider;

    public $api;

    /**
     * FilesApi constructor.
     * @param RequestProvider $provider
     * @param string $api
     */
    public function __construct(RequestProvider $provider, string $api)
    {
        $this->provider = $provider;
        $this->api = $api;
    }

    /**
     * @param string $image
     * @param string $dir
     * @param string|null $fileName
     * @param string|null $fileExt
     * @return string|null
     * @throws RequestProviderException
     */
    public function uploadImage(string $image, string $dir, string $fileName = null, string $fileExt = null) : ?string
    {
        $result = $this->provider->request($this->api , 'post','images/add',  [
            'image' => $image,
            'dir' => $dir,
            'file_name' => $fileName,
            'file_ext' => $fileExt
        ]);

        return $result['code'] ?? null;
    }

    /**
     * @param string $url
     * @param string $dir
     * @param array|null $stopPhrases
     * @param string|null $fileName
     * @param string|null $fileExt
     * @return string|null
     * @throws RequestProviderException
     */
    public function uploadImageByUrl(string $url, string $dir, array $stopPhrases = null, string $fileName = null, string $fileExt = null) : ?string
    {
        $result = $this->provider->request($this->api , 'post','images/add', [
            'download_url' => $url,
            'dir' => $dir,
            'file_name' => $fileName,
            'file_ext' => $fileExt,
            'stop_phrases' => $stopPhrases
        ]);

        return $result['code'] ?? null;
    }

    /**
     * @param $image
     * @param null $width
     * @param null $height
     * @return string|null
     */
    public function getImageUrl($image, $width = null, $height = null) : ?string
    {
        $add = [];

        if($width)
        {
            $add[] = 'width='.$width;
        }
        if($height)
        {
            $add[] = 'height='.$height;
        }
        return env('IMAGES_URL') . '/' . $image.($add ? '?'.implode('&', $add) : '');
    }
}
