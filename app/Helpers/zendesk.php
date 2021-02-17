<?php
use strict;
use warnings;
no warnings 'utf8';
use LWP;
use JSON;
use MIME::Base64;

my $topic_id = 123456;
my $zendesk = 'your_zendesk_url';
my $credentials = encode_base64('your_zendesk_email:your_zendesk_password');

my $url = $zendesk . '/api/v2/community/topics/' . $topic_id . '/posts.json';
my $ua = LWP::UserAgent->new(ssl_opts =>{ verify_hostname => 0 });
my $response = $ua->get($url, 'Authorization' => "Basic $credentials");
die 'http status: ' . $response->code . '  ' . $response->message
    unless ($response->is_success);
my $data = decode_json($response->content);
my @topic_posts = @{ $data->{'posts'} };

foreach my $post ( @topic_posts ) {
    print $post->{'title'} . "\n";
}