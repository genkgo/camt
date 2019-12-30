<?php

namespace Genkgo\Camt\DTO;

class OrganisationIdentification extends Identification
{
    /**
     * @var null|string
     */
    private $bic;

    /**
     * @var null|string
     */
    private $ibei;

    /**
     * @var null|string
     */
    private $bei;

    /**
     * @var null|string
     */
    private $eangln;

    /**
     * @var null|string
     */
    private $chipsUniversalId;

    /**
     * @var null|string
     */
    private $duns;

    /**
     * @var null|string
     */
    private $bankPartyId;

    /**
     * @var null|string
     */
    private $taxId;

    /**
     * @var null|string
     */
    private $issuer;

    /**
     * @var null|string
     */
    private $otherId;

    /**
     * @var null|string
     */
    private $otherIssuer;

    /**
     * @var null|string
     */
    private $otherSchemeName;

    /**
     * @var null|string
     */
    private $otherType;

    /**
     * @return null|string
     */
    public function getBic(): ?string
    {
        return $this->bic;
    }

    /**
     * @param string $bic
     */
    public function setBic(string $bic): void
    {
        $this->bic = $bic;
        $this->identification = $bic;
    }

    /**
     * @return null|string
     */
    public function getIbei(): ?string
    {
        return $this->ibei;
    }

    /**
     * @param string $ibei
     */
    public function setIbei(string $ibei): void
    {
        $this->ibei = $ibei;
        $this->identification = $ibei;
    }

    /**
     * @return null|string
     */
    public function getBei(): ?string
    {
        return $this->bei;
    }

    /**
     * @param string $bei
     */
    public function setBei(string $bei): void
    {
        $this->bei = $bei;
        $this->identification = $bei;
    }

    /**
     * @return null|string
     */
    public function getEangln(): ?string
    {
        return $this->eangln;
    }

    /**
     * @param string $eangln
     */
    public function setEangln(string $eangln): void
    {
        $this->eangln = $eangln;
        $this->identification = $eangln;
    }

    /**
     * @return null|string
     */
    public function getChipsUniversalId(): ?string
    {
        return $this->chipsUniversalId;
    }

    /**
     * @param string $chipsUniversalId
     */
    public function setChipsUniversalId(string $chipsUniversalId): void
    {
        $this->chipsUniversalId = $chipsUniversalId;
        $this->identification = $chipsUniversalId;
    }

    /**
     * @return null|string
     */
    public function getDuns(): ?string
    {
        return $this->duns;
    }

    /**
     * @param string $duns
     */
    public function setDuns(string $duns): void
    {
        $this->duns = $duns;
        $this->identification = $duns;
    }

    /**
     * @return null|string
     */
    public function getBankPartyId(): ?string
    {
        return $this->bankPartyId;
    }

    /**
     * @param string $bankPartyId
     */
    public function setBankPartyId(string $bankPartyId): void
    {
        $this->bankPartyId = $bankPartyId;
        $this->identification = $bankPartyId;
    }

    /**
     * @return null|string
     */
    public function getTaxId(): ?string
    {
        return $this->taxId;
    }

    /**
     * @param string $taxId
     */
    public function setTaxId(string $taxId): void
    {
        $this->taxId = $taxId;
        $this->identification = $taxId;
    }

    /**
     * @return null|string
     */
    public function getOtherId(): ?string
    {
        return $this->otherId;
    }

    /**
     * @param string $otherId
     */
    public function setOtherId(string $otherId): void
    {
        $this->otherId = $otherId;
        $this->identification = $otherId;
    }

    /**
     * @return null|string
     */
    public function getOtherIssuer(): ?string
    {
        return $this->otherIssuer;
    }

    /**
     * @param string $otherIssuer
     */
    public function setOtherIssuer(string $otherIssuer): void
    {
        $this->otherIssuer = $otherIssuer;
    }

    /**
     * @return null|string
     */
    public function getOtherSchemeName(): ?string
    {
        return $this->otherSchemeName;
    }

    /**
     * @param string $otherSchemeName
     */
    public function setOtherSchemeName(string $otherSchemeName): void
    {
        $this->otherSchemeName = $otherSchemeName;
    }

    /**
     * @return null|string
     */
    public function getOtherType(): ?string
    {
        return $this->otherType;
    }

    /**
     * @param string $otherType
     */
    public function setOtherType(string $otherType): void
    {
        $this->otherType = $otherType;
    }

    /**
     * @return null|string
     */
    public function getIssuer(): ?string
    {
        return $this->issuer;
    }

    /**
     * @param string $issuer
     */
    public function setIssuer(string $issuer): void
    {
        $this->issuer = $issuer;
        $this->identification = $issuer;
    }
}
