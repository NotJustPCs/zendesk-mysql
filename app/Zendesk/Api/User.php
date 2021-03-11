<?php


namespace App\Zendesk\Api;

use App\Zendesk\Client;
use Illuminate\Support\Facades\DB;
use App\Zendesk\Interfaces\ApiInterface;
use Illuminate\Support\Facades\Log;

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
    public function users(array $params = []): array
    {
        $users = $this->http->get('/users',$params);
        $this->processData($users);
        return $this->userIds;
    }

    /**
     * @param $users
     * @return array
     */
    public function processData($users)
    {
        $this->processUsers($users);
        $this->processUserIdentities($users);
        $this->nextPage($users);
        return true;
    }
    private function processUsers($users){

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
    }
    private function processUserIdentities($users){
        foreach ($users['identities'] as $identity) {
            switch ($identity['type']) {
                case 'email':
                    $this->storeUserIdentityEmail($identity);
                    break;
                case 'phone_number':
                    $this->storeUserIdentityPhoneNumber($identity);
                    break;
                case 'facebook':
                    $this->storeUserIdentityFacebook($identity);
                    break;
                case 'google':
                    $this->storeUserIdentityGoogle($identity);
                    break;
                case 'agent_forwarding':
                    $this->storeUserIdentityAgentForwarding($identity);
                    break;
                case 'twitter':
                    $this->storeUserIdentityTwitter($identity);
                    break;
                default:
                    Log::info('default case');
                    break;
            }
        }
    }
    private function storeTags($tags, $userId)
    {
        if (is_array($tags) && !empty($tags)) {
            foreach ($tags as  $tag) {
                DB::table('zendesk_user_tags')->insert(['user_id' => $userId, 'tag' => $tag]);
            }
        }
    }

    private function storeUserFields($userFields, $userId)
    {
        if (is_array($userFields) && !empty($userFields)) {
            DB::table('zendesk_user_fields')->insert([
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
        if (isset($page['next_page']) && !empty($page['next_page']) ) {
            $nextPageUrl = str_replace(config('zendesk.url'), '', $page['next_page']);
            $users = $this->http->get($nextPageUrl);
            $this->processData($users);
        }
    }

    private function storeUsers($user)
    {
        DB::table('zendesk_users')->insert($user);
    }

    private function storeUserPhoto($photo, $userId)
    {
        if (is_array($photo) && !empty($photo)) {
            DB::table('zendesk_user_photos')->insert(
                ['user_id' => $userId, 'url' => $photo['url']]
            );
        }
    }

    private function storeUserIdentityEmail($identity)
    {
        DB::table('zendesk_user_identity_emails')->insert($identity);
    }

    private function storeUserIdentityPhoneNumber($identity)
    {
        DB::table('zendesk_user_identity_phone_numbers')->insert($identity);
    }

    private function storeUserIdentityFacebook($identity)
    {
        DB::table('zendesk_user_identity_facebook')->insert($identity);
    }

    private function storeUserIdentityGoogle($identity)
    {
        DB::table('zendesk_user_identity_google')->insert($identity);
    }

    private function storeUserIdentityAgentForwarding($identity)
    {
        DB::table('zendesk_user_identity_agent_forwarding')->insert($identity);
    }

    private function storeUserIdentityTwitter($identity)
    {
        DB::table('zendesk_user_identity_twitter')->insert($identity);
    }
}
