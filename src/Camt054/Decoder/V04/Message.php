<?php

namespace Genkgo\Camt\Camt054\Decoder\V04;

use Genkgo\Camt\Camt054\Decoder\Message as BaseMessage;
use Genkgo\Camt\Camt054\DTO\V04 as Camt054V04DTO;
use Genkgo\Camt\DTO;
use SimpleXMLElement;
use DateTimeImmutable;

class Message extends BaseMessage
{
    /**
     * {@inheritdoc}
     */
    public function addGroupHeader(DTO\Message $message, SimpleXMLElement $document)
    {
        $xmlGroupHeader = $this->getRootElement($document)->GrpHdr;
        $groupHeader = new Camt054V04DTO\GroupHeader(
            (string)$xmlGroupHeader->MsgId,
            new DateTimeImmutable((string)$xmlGroupHeader->CreDtTm)
        );

        if (isset($xmlGroupHeader->OrgnlBizQry)) {
            $originalBusinessQuery = new Camt054V04DTO\OriginalBusinessQuery(
                (string) $xmlGroupHeader->OrgnlBizQry->MsgId
            );

            if (isset($xmlGroupHeader->OrgnlBizQry->CreDtTm)) {
                $originalBusinessQuery->setCreatedOn(
                    new DateTimeImmutable((string) $xmlGroupHeader->OrgnlBizQry->CreDtTm)
                );
            }

            if (isset($xmlGroupHeader->OrgnlBizQry->MsgNmId)) {
                $originalBusinessQuery->setMessageNameId((string) $xmlGroupHeader->OrgnlBizQry->MsgNmId);
            }

            $groupHeader->setOriginalBusinessQuery($originalBusinessQuery);
        }

        if (isset($xmlGroupHeader->AddtlInf)) {
            $groupHeader->setAdditionalInformation((string) $xmlGroupHeader->AddtlInf);
        }

        $message->setGroupHeader($groupHeader);
    }
}
