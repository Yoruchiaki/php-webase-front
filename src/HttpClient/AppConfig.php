<?php

namespace Yoruchiaki\WebaseFront\HttpClient;

class AppConfig
{
    public string $frontUrl;
    public int    $timeout;

    public function __construct(
        string $frontUrl,
        int $timeout = 5
    ) {
        $this->frontUrl = $frontUrl;
        $this->timeout = $timeout;
    }

    public function setFrontUrl(int $groupId): AppConfig
    {
        $this->groupId = $groupId;
        return $this;
    }

    public function setTimeOut()
    {

    }
}