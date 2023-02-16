<?php
    class Worker{
        public $userId;
        public $fullName;
        public $emailAddress;
        public $contactNo;
        public $nic;
        public $dob;
        public $address;
        public $city;
        public $currentRating;

        public function __construct($userId, $fullName, $emailAddress, $contactNo, $nic, $dob, $address, $city, $currentRating)
        {
            $this->userId = $userId;
            $this->fullName = $fullName;
            $this->emailAddress = $emailAddress;
            $this->contactNo = $contactNo;
            $this->nic = $nic;
            $this->dob = $dob;
            $this->address = $address;
            $this->city = $city;
            $this->currentRating = $currentRating;
        }

        public function getUserId()
        {
            return $this->userId;
        }

        public function getFullName()
        {
            return $this->fullName;
        }

        public function setFullName($fullName)
        {
            $this->fullName = $fullName;
        }

        public function getEmailAddress()
        {
            return $this->emailAddress;
        }

        public function setEmailAddress($emailAddress)
        {
            $this->emailAddress = $emailAddress;
        }

        public function getContactNo()
        {
            return $this->contactNo;
        }

        public function setContactNo($contactNo)
        {
            $this->contactNo = $contactNo;
        }

        public function getNic()
        {
            return $this->nic;
        }

        public function setNic($nic)
        {
            $this->nic = $nic;
        }

        public function getDob()
        {
            return $this->dob;
        }

        public function setDob($dob)
        {
            $this->dob = $dob;
        }

        public function getAddress()
        {
            return $this->address;
        }

        public function setAddress($address)
        {
            $this->address = $address;
        }

        public function getCity()
        {
            return $this->city;
        }

        public function setCity($city)
        {
            $this->city = $city;
        }

        public function getCurrentRating()
        {
            return $this->currentRating;
        }

        public function setCurrentRating($currentRating)
        {
            $this->currentRating = $currentRating;
        }


    }

    ?>