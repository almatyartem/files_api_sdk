<?php

namespace FilesApiSdk;

use RpContracts\RequestProvider;

class FilesApi
{
    /**
     * @var RequestProvider
     */
    public RequestProvider $provider;

    /**
     * @var string
     */
    public string $api;

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
     */
    public function uploadImage(string $image, string $dir, string $fileName = null, string $fileExt = null) : ?string
    {
        return $this->upload( [
            'image' => $image,
            'dir' => $dir,
            'file_name' => $fileName,
            'file_ext' => $fileExt
        ]);
    }

    /**
     * @param string $url
     * @param string $dir
     * @param array|null $stopPhrases
     * @param string|null $fileName
     * @param string|null $fileExt
     * @return string|null
     */
    public function uploadImageByUrl(string $url, string $dir, array $stopPhrases = null, string $fileName = null, string $fileExt = null) : ?string
    {
        return $this->upload( [
            'download_url' => $url,
            'dir' => $dir,
            'file_name' => $fileName,
            'file_ext' => $fileExt,
            'stop_phrases' => $stopPhrases
        ]);
    }

    /**
     * @param array $data
     * @return string|null
     */
    protected function upload(array $data) : ?string
    {
        $result = $this->provider->request($this->api.'/images/add', 'post', $data);

        return $result->getContents()['code'] ?? null;
    }
}
