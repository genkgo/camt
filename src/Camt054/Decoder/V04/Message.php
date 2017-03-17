<?php

namespace Genkgo\Camt\Camt054\Decoder\V04;

use SimpleXMLElement;
use DateTimeImmutable;
use Genkgo\Camt\Camt054\Decoder\Message as BaseMessage;
use Genkgo\Camt\Camt054\DTO\V04 as Camt054V04DTO;
use Genkgo\Camt\DTO;
use Genkgo\Camt\Decoder\Factory\DTO as DTOFactory;

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

            if (isset($xmlGroupHeader->MsgRcpt)) {
                $groupHeader->setMessageRecipient(
                    DTOFactory\Recipient::createFromXml($xmlGroupHeader->MsgRcpt)
                );
            }

            $groupHeader->setOriginalBusinessQuery($originalBusinessQuery);
        }

        if (isset($xmlGroupHeader->AddtlInf)) {
            $groupHeader->setAdditionalInformation((string) $xmlGroupHeader->AddtlInf);
        }

        if (isset($xmlGroupHeader->MsgPgntn)) {
            $groupHeader->setPagination(new DTO\Pagination(
                (string) $xmlGroupHeader->MsgPgntn->PgNb,
                ('true' === (string) $xmlGroupHeader->MsgPgntn->LastPgInd) ? true : false
            ));
        }

        $message->setGroupHeader($groupHeader);
    }
}
