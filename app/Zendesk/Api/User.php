<?php


namespace App\Zendesk\Api;

use App\Zendesk\Client;
use Illuminate\Support\Facades\DB;

class User implements ApiInterface
{
    private $http;
    private $userIds = [];

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    /**
     * @param string|null $nextPage
     * @return array
     * @throws \JsonException
     */
    public function users(string $nextPage = null): array
    {
        if (isset($nextPage) && !empty($nextPage)) {
            $nextPageUrl = str_replace(config('zendesk.url'), '', $nextPage);
            $users = $this->http->get($nextPageUrl);
        } else {
            $users = $this->http->get('/users');
        }
        $this->processData($users);
        $this->nextPage($users);
        return $this->userIds;
    }

    /**
     * @param $users
     * @return array
     */
    public function processData($users)
    {
        foreach ($users['users'] as $user) {
            $userId = $user['id'];
            array_push($this->userIds, $userId);
            //Store tags of users
            $tags = $user['tags'];
            unset($user['tags']);
            $this->storeTags($tags, $userId);
            //Store user fields
            $userFields = $user['user_fields'];
            unset($user['user_fields']);
            $this->storeUserFields($userFields, $userId);
            //Store user photo
            $photo = $user['photo'];
            unset($user['photo']);
            $this->storeUserPhoto($photo, $userId);
            //Store user
            $this->storeUsers($user);
        }
        return true;
    }

    private function storeTags($tags, $userId)
    {
        if (is_array($tags) && !empty($tags)) {
            foreach ($tags as  $tag) {
                DB::table('user_tags')->insert(['user_id' => $userId, 'tag' => $tag]);
            }
        }
    }

    private function storeUserFields($userFields, $userId)
    {
        if (is_array($userFields) && !empty($userFields)) {
            DB::table('user_fields')->insert([
                'user_id' => $userId,
                'asset_database_user_id' => $userFields['asset_database_user_id'],
                'irregular_prepaid_hours' => $userFields['irregular_prepaid_hours'],
                'SN_User_Data' => $userFields['SN_User_Data'],
                'xero_contact_id' => $userFields['xero_contact_id'],
            ]);
        }
    }

    /**
     * @param $page
     * @return mixed
     * @throws \JsonException
     */
    public function nextPage($page)
    {
        if ($page['next_page'] !== null) {
            $this->users($page['next_page']);
        }
    }

    private function storeUsers($user)
    {
        DB::table('users')->insert($user);
    }

    private function storeUserPhoto($photo, $userId)
    {
        if (is_array($photo) && !empty($photo)) {
            DB::table('user_photos')->insert(
                ['user_id' => $userId, 'url' => $photo['url']]
            );
        }
    }
}
