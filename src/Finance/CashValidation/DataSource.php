<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\CashValidation;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class DataSource extends Model
{
    private int|float|null $directBankFeed = null;

    private int|float|null $fileUpload = null;

    private int|float|null $manual = null;

    private int|float|null $directBankFeedPos = null;

    private int|float|null $fileUploadPos = null;

    private int|float|null $manualPos = null;

    private int|float|null $directBankFeedNeg = null;

    private int|float|null $fileUploadNeg = null;

    private int|float|null $manualNeg = null;

    private int|float|null $otherPos = null;

    private int|float|null $otherNeg = null;

    private int|float|null $other = null;

    public function getDirectBankFeed(): int|float|null
    {
        return $this->directBankFeed;
    }

    public function setDirectBankFeed(int|float|null $directBankFeed): self
    {
        $this->directBankFeed = $directBankFeed;

        return $this;
    }

    public function getFileUpload(): int|float|null
    {
        return $this->fileUpload;
    }

    public function setFileUpload(int|float|null $fileUpload): self
    {
        $this->fileUpload = $fileUpload;

        return $this;
    }

    public function getManual(): int|float|null
    {
        return $this->manual;
    }

    public function setManual(int|float|null $manual): self
    {
        $this->manual = $manual;

        return $this;
    }

    public function getDirectBankFeedPos(): int|float|null
    {
        return $this->directBankFeedPos;
    }

    public function setDirectBankFeedPos(int|float|null $directBankFeedPos): self
    {
        $this->directBankFeedPos = $directBankFeedPos;

        return $this;
    }

    public function getFileUploadPos(): int|float|null
    {
        return $this->fileUploadPos;
    }

    public function setFileUploadPos(int|float|null $fileUploadPos): self
    {
        $this->fileUploadPos = $fileUploadPos;

        return $this;
    }

    public function getManualPos(): int|float|null
    {
        return $this->manualPos;
    }

    public function setManualPos(int|float|null $manualPos): self
    {
        $this->manualPos = $manualPos;

        return $this;
    }

    public function getDirectBankFeedNeg(): int|float|null
    {
        return $this->directBankFeedNeg;
    }

    public function setDirectBankFeedNeg(int|float|null $directBankFeedNeg): self
    {
        $this->directBankFeedNeg = $directBankFeedNeg;

        return $this;
    }

    public function getFileUploadNeg(): int|float|null
    {
        return $this->fileUploadNeg;
    }

    public function setFileUploadNeg(int|float|null $fileUploadNeg): self
    {
        $this->fileUploadNeg = $fileUploadNeg;

        return $this;
    }

    public function getManualNeg(): int|float|null
    {
        return $this->manualNeg;
    }

    public function setManualNeg(int|float|null $manualNeg): self
    {
        $this->manualNeg = $manualNeg;

        return $this;
    }

    public function getOtherPos(): int|float|null
    {
        return $this->otherPos;
    }

    public function setOtherPos(int|float|null $otherPos): self
    {
        $this->otherPos = $otherPos;

        return $this;
    }

    public function getOtherNeg(): int|float|null
    {
        return $this->otherNeg;
    }

    public function setOtherNeg(int|float|null $otherNeg): self
    {
        $this->otherNeg = $otherNeg;

        return $this;
    }

    public function getOther(): int|float|null
    {
        return $this->other;
    }

    public function setOther(int|float|null $other): self
    {
        $this->other = $other;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'directBankFeed' => Field::number(),
            'fileUpload' => Field::number(),
            'manual' => Field::number(),
            'directBankFeedPos' => Field::number(),
            'fileUploadPos' => Field::number(),
            'manualPos' => Field::number(),
            'directBankFeedNeg' => Field::number(),
            'fileUploadNeg' => Field::number(),
            'manualNeg' => Field::number(),
            'otherPos' => Field::number(),
            'otherNeg' => Field::number(),
            'other' => Field::number(),
        ];
    }
}
