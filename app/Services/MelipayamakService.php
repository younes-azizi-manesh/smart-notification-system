<?php
namespace App\Services;

use Melipayamak\MelipayamakApi;

class MelipayamakService
{
    private array $text;
    private string $to;
    private int $bodyId;

    private function setText(array $text): self
    {
        $this->text = $text;
        return $this;
    }

    private function setTo(string $to): self
    {
        $this->to = $to;
        return $this;
    }
    // set number of defined sms body in melipayamak.
    private function setBodyId(int $bodyId): self
    {
        $this->bodyId = $bodyId;
        return $this;
    }

    public function send(): void
    {
        try {
            $api = new MelipayamakApi(config('sms.username'), config('sms.password'));
            $api->sms('soap')->sendByBaseNumber($this->text, $this->to, $this->bodyId);
        } catch (\Exception $e) {
            logger()->error("SMS send failed: " . $e->getMessage());
        }
    }

    public function sendSMS(array $text, string $to, int $bodyId)
    {
        return $this->setText($text)
        ->setTo($to)
        ->setBodyId($bodyId)
        ->send();
    }
}
