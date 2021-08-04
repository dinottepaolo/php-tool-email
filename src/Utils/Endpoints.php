<?php 
namespace paolodinotte\Tool\Utils;

class Endpoints
{
    // Backend server endpoints
    private const BASE_URL = "https://jsonplaceholder.typicode.com/";
    private const USERS = self::BASE_URL . "users?_start=%s&_end=%s";
    private const POSTS = self::BASE_URL . "posts?userId=%s&_start=%s&_end=%s";

    /**
     * Get users list
     *
     * @param int $start
     * @param int $end
     *
     * @return mixed users list JSON
     *
     */
    public static function getUsers(int $start = 0, int $end = null): mixed{
        $requestUrl = sprintf(self::USERS, $start, $end);
        return self::performGet($requestUrl);
    }

    /**
     * Get user's posts
     *
     * @param int $userId
     * @param int $start
     * @param int $end
     *
     * @return mixed user's posts list JSON
     *
     */
    public static function getPosts(int $userId, int $start = 0, int $end = null): mixed{
        $requestUrl = sprintf(self::POSTS, $userId, $start, $end);
        return self::performGet($requestUrl);
    }


    /**
     * Private utility to fetch JSON from BE
     *
     * @param string $requestUrl
     *
     * @return mixed BE JSON response
     *
     */
    private static function performGet(string $requestUrl): mixed{
        $response = file_get_contents($requestUrl);
        return json_decode($response, true);
    }
}