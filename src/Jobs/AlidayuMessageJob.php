<?php

namespace Sliverwing\Alidayu;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;

class AlidayuMessageJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $appkey;
    private $secretKey;
    private $phoneNum;
    private $smsParam;
    private $freeSignName;
    private $templateCode;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phoneNum, $smsParam, $type)
    {
        $this->appkey = config('alidayu.appkey');
        $this->secretKey = config('alidayu.secretKey');
        $this->freeSignName = config('alidayu.sms.'.$type.'.SmsFreeSignName');
        $this->templateCode = config('alidayu.sms.'.$type.'.SmsTemplateCode');
        $this->phoneNum = $phoneNum;
        $this->smsParam = $smsParam;

        if ($this->appkey === null || $this->secretKey === null) {
            throw new \Exception("Appkey & SecretKey Required!");
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client(new App([
            'app_key' => $this->appkey,
            'app_secret' => $this->secretKey,
        ]));

        $req = new AlibabaAliqinFcSmsNumSend;
        $req->setRecNum($this->phoneNum)
            ->setSmsParam($this->smsParam)
            ->setSmsFreeSignName($this->freeSignName)
            ->setSmsTemplateCode($this->templateCode);
        $resp = $client->execute($req);
        if ($resp->code != 0){
            throw new \Exception($resp->sub_msg);
        }
    }
}
