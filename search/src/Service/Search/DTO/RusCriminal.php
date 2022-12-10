<?php

namespace Search\Service\Search\DTO;

class RusCriminal implements \JsonSerializable
{
    public function __construct(
        private string $number,
        private string $rank,
        private string $militaryUnit,
        private string $name,
        private string $birthDate,
        private string $phone,
        private string $vk
//        private string $accProbability,
//        private string $contactName,
//        private string $contactCloseness,
//        private string $contactType,
//        private string $contactPhone,
//        private string $contactVk
    ) {}

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getRank(): string
    {
        return $this->rank;
    }

    public function getMilitaryUnit(): string
    {
        return $this->militaryUnit;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getVk(): string
    {
        return $this->vk;
    }
//
//    public function getAccProbability(): string
//    {
//        return $this->accProbability;
//    }
//
//    public function getContactName(): string
//    {
//        return $this->contactName;
//    }
//
//    public function getContactCloseness(): string
//    {
//        return $this->contactCloseness;
//    }
//
//    public function getContactType(): string
//    {
//        return $this->contactType;
//    }
//
//    public function getContactPhone(): string
//    {
//        return $this->contactPhone;
//    }
//
//    public function getContactVk(): string
//    {
//        return $this->contactVk;
//    }


    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}