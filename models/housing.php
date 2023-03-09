<?php
    class Housing{
        public $housingId;
        public $customerId;
        public $address;
        public $verified;

         public function __construct($housingId, $customerId, $address, $verified)
        {
            $this->housingId = $housingId;
            $this->customerId = $customerId;
            $this->address = $address;
            $this->verified = $verified;
        }

        public function getHousingId()
        {
            return $this->housingId;
        }

        public function getCustomerId()
        {
            return $this->customerId;
        }

        public function setCustomerId($customerId)
        {
            $this->customerId = $customerId;
        }

        public function getAddress()
        {
            return $this->address;
        }

        public function setAddress($address)
        {
            $this->address = $address;
        }

        public function getVerified()
        {
            return $this->verified;
        }

        public function setVerified($verified)
        {
            $this->verified = $verified;
        }
    }
