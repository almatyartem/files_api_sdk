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
     * FilesApi constructor.
     * @param RequestProvider $provider
     * @param string $api
     */
    public function __construct(RequestProvider $provider)
    {
        $this->provider = $provider;
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
     * @param string $prefix
     * @param string $dir
     * @return array|null
     */
    public function find(string $prefix, string $dir)
    {
        $result = $this->provider->request('images/find/'.$dir.'/'.$prefix);

        return $result->getContents() ?? null;
    }

    /**
     * @param array $data
     * @return string|null
     */
    protected function upload(array $data) : ?string
    {
        $result = $this->provider->request('images/add', 'post', $data);

        return $result->getContents()['code'] ?? null;
    }
}
