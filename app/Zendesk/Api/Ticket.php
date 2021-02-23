<?php


namespace App\Zendesk\Api;

use App\Zendesk\Client;
use Illuminate\Support\Facades\DB;
use App\Zendesk\Interfaces\ApiInterface;


class Ticket implements ApiInterface
{
    private $http;
    private $ticketIds = [];

    public function __construct(Client $http)
    {
        $this->http = $http;
    }
    public function tickets(string $nextPage = null): array
    {
        if (isset($nextPage) && !empty($nextPage)) {
            $nextPageUrl = str_replace(config('zendesk.url'), '', $nextPage);
            $tickets = $this->http->get($nextPageUrl);
        } else {
            $tickets = $this->http->get('/tickets');
        }
        $this->processData($tickets);
        $this->nextPage($tickets);
        return $this->ticketIds;
    }
    /**
     * @param $data
     * @return mixed
     */
    public function processData($tickets)
    {
        foreach ($tickets['tickets'] as $ticket) {
            $ticketId = $ticket['id'];
            array_push($this->ticketIds, $ticketId);
            //Store ticket via
            $via = $ticket['via'];
            unset($ticket['via']);
            $this->storeVia($via, $ticketId);
            //Store collaborator ids
            $collaboratorIds = $ticket['collaborator_ids'];
            unset($ticket['collaborator_ids']);
            $this->storeCollaboratorIds($collaboratorIds, $ticketId);
            //Store follower ids
            $followerIds = $ticket['follower_ids'];
            unset($ticket['follower_ids']);
            $this->storeFollowerIds($followerIds, $ticketId);
            //Store email cc ids
            $emailCcIds = $ticket['email_cc_ids'];
            unset($ticket['email_cc_ids']);
            $this->storeEmailCcIds($emailCcIds, $ticketId);
            //Store tags
            $tags = $ticket['tags'];
            unset($ticket['tags']);
            $this->storeTags($tags, $ticketId);
            //Store custom fields
            $customFields = $ticket['custom_fields'];
            unset($ticket['custom_fields']);
            $this->storeCustomFields($customFields, $ticketId);
            //Store sharing agreement ids
            $sharingAgreementIds = $ticket['sharing_agreement_ids'];
            unset($ticket['sharing_agreement_ids']);
            $this->storeSharingAgreementIds($sharingAgreementIds, $ticketId);
            //Store fields
            $fields = $ticket['fields'];
            unset($ticket['fields']);
            $this->storeFields($fields, $ticketId);
            //Store followup ids
            $followupIds = $ticket['followup_ids'];
            unset($ticket['followup_ids']);
            $this->storeFollowupIds($followupIds, $ticketId);
            //store satisfaction rating
            $satisfactionRating = $ticket['satisfaction_rating'];
            unset($ticket['satisfaction_rating']);
            $this->storeSatisfactionRating($satisfactionRating, $ticketId);
            //Store ticket
            $this->storeTicket($ticket);
        }
        return true;
    }

    /**
     * @param $page
     * @return mixed
     */
    public function nextPage($page)
    {
        if ($page['next_page'] !== null) {
            $this->tickets($page['next_page']);
        }
    }

    private function storeVia($via, $ticketId)
    {
        if (!empty($via)) {
            //tore source
            $source = $via['source'];
            unset($via['source']);
            $this->storeSource($source, $ticketId);
            DB::table('zd_ticket_via')->insert(['ticket_id' => $ticketId, 'via' => $via['channel']]);
        }
    }

    private function storeSource($source, $ticketId)
    {
        if (
            !empty($source)
            && !empty($source['from']['address'])
            && !empty($source['from']['name'])
            && !empty($source['to']['address'])
            && !empty($source['to']['address'])
        ) {
            DB::table('zd_ticket_via_source')->insert(
                [
                    'ticket_id' => $ticketId,
                    'from_address' => !empty($source['from']['address']) ? $source['from']['address'] : null,
                    'from_name' => !empty($source['from']['name']) ? $source['from']['name'] : null,
                    'to_address' => !empty($source['to']['address']) ? $source['to']['address'] : null,
                    'to_name' => !empty($source['to']['name']) ? $source['to']['name'] : null,
                    'rel' => !empty($source['rel']) ? $source['rel'] : null
                ]
            );
        }
    }

    private function storeCollaboratorIds($collaboratorIds, $ticketId)
    {
        if (is_array($collaboratorIds) && !empty($collaboratorIds)) {
            foreach ($collaboratorIds as  $collaboratorId) {
                DB::table('zd_ticket_collaborator_ids')->insert(['ticket_id' => $ticketId, 'collaborator_id' => $collaboratorId]);
            }
        }
    }

    private function storeFollowerIds($followerIds, $ticketId)
    {
        if (is_array($followerIds) && !empty($followerIds)) {
            foreach ($followerIds as  $followerId) {
                DB::table('zd_ticket_follower_ids')->insert(['ticket_id' => $ticketId, 'follower_id' => $followerId]);
            }
        }
    }

    private function storeEmailCCIds($emailCcIds, $ticketId)
    {
        if (is_array($emailCcIds) && !empty($emailCcIds)) {
            foreach ($emailCcIds as  $emailCcId) {
                DB::table('zd_ticket_email_cc_ids')->insert(['ticket_id' => $ticketId, 'email_cc_id' => $emailCcId]);
            }
        }
    }

    private function storeTags($tags, $ticketId)
    {
        if (is_array($tags) && !empty($tags)) {
            foreach ($tags as  $tag) {
                DB::table('zd_ticket_tags')->insert(['ticket_id' => $ticketId, 'tag' => $tag]);
            }
        }
    }

    private function storeCustomFields($customFields, $ticketId)
    {
        if (is_array($customFields) && !empty($customFields)) {
            foreach ($customFields as  $customField) {
                DB::table('zd_ticket_custom_fields')->insert(['ticket_id' => $ticketId, 'id' => $customField['id'], 'value' => $customField['value']]);
            }
        }
    }

    private function storeSharingAgreementIds($sharingAgreementIds, $ticketId)
    {
        if (is_array($sharingAgreementIds) && !empty($sharingAgreementIds)) {
            foreach ($sharingAgreementIds as  $sharingAgreementId) {
                DB::table('zd_ticket_sharing_agreement_ids')->insert(['ticket_id' => $ticketId, 'sharing_agreement_id' => $sharingAgreementId]);
            }
        }
    }

    private function storeFields($fields, $ticketId)
    {
        if (is_array($fields) && !empty($fields)) {
            foreach ($fields as  $field) {
                DB::table('zd_ticket_fields')->insert(['ticket_id' => $ticketId, 'id' => $field['id'], 'value' => $field['value']]);
            }
        }
    }

    private function storeFollowupIds($followupIds, $ticketId)
    {
        if (is_array($followupIds) && !empty($followupIds)) {
            foreach ($followupIds as  $followupId) {
                DB::table('zd_ticket_followup_ids')->insert(['ticket_id' => $ticketId, 'followup_id' => $followupId]);
            }
        }
    }

    private function storeTicket($ticket)
    {
        DB::table('zd_tickets')->insert($ticket);
    }

    private function storeSatisfactionRating($satisfactionRating, $ticketId)
    {
        if (!empty($satisfactionRating)) {
            DB::table('zd_ticket_satisfaction_rating')->insert(
                [
                    'ticket_id' => $ticketId,
                    'comment' => $satisfactionRating['comment'],
                    'id' => $satisfactionRating['id'],
                    'score' => $satisfactionRating['score']
                ]
            );
        }
    }
}
