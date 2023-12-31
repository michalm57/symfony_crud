<?php

namespace App\Service;

class EmailLabsService
{
    private $appKey;
    private $secretKey;
    private $subject;
    private $content;
    private $url;

    public function setAppKey(string $appKey)
    {
        $this->appKey = $appKey;
    }

    public function setSecretKey(string $secretKey)
    {
        $this->secretKey = base64_encode($secretKey);
    }

    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    public function send(string $email, string $subject = null, string $content = null)
    {
        //Initialization of CURL library
        $curl = curl_init();

        //Setting the address from which data will be collected
        $url = $this->url;

        //Setting App Key
        $appkey = $this->appKey;
        //Setting Secret Key
        $secret = $this->secretKey;

        //Creating criteria of dispatch
        $data = [
            'to' => [
                $email => [
                    'vars' => [
                        //Here we insert the variables that are swapped in the template
                        // Add variables if needed based on your email template
                    ],
                    //Our own message-id
                    'message_id' => md5('1' . microtime()) . '@domain',
                ],
            ],
            'smtp_account' => '1.your_panel_name.smtp',
            'subject' => $subject ?? $this->subject,
            'template_id' => 'template_id',
            'html' => $content ?? $this->content,
            'from' => 'examplemail@gmail.com',
            'from_name' => 'My Company Name',
            'headers' => [
                'x-header-1' => 'test-1',
                'x-header-2' => 'test-2',
            ],
            'cc' => 'emailcc@domain.com',
            'cc_name' => 'Jan Nowak',
            'bcc' => 'bcc_address@domain.com',
            'bcc_name' => 'Adam Nowak',
            'tags' => [
                'tag_1',
                'tag_2',
            ],
        ];

        //Setting POST method
        curl_setopt($curl, CURLOPT_POST, 1);
        //Transfer of data to POST
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        //Setting the authentication type
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "$appkey:$secret");
        //Transfer URL action
        curl_setopt($curl, CURLOPT_URL, $url);
        //Settings of the return from the server
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        //Download results
        $result = curl_exec($curl);

        // Handle the response here if needed
        // For example, check if the email was sent successfully

        // Close cURL resource
        curl_close($curl);

        return $result; // You can return the result or handle it differently
    }
}