<?php
    class Booking{
        public $bookingId;
        public $customerId;
        public $customerName;
        public $customerAddress;
        public $customerPhoneNumber;
        public $workerId;
        public $workerName;
        public $workerAddress;
        public $workerPhoneNumber;
        public $createdDate;
        public $startDate;
        public $endDate;
        public $workerType;
        public $status;
        public $paymentMethod;
        public $paymentAmount;

        public function __construct($bookingId, $customerId, $customerName, $customerAddress, $customerPhoneNumber, $workerAddress, $workerPhoneNumber,$workerId, $workerName,$createdDate, $startDate, $endDate, $workerType, $status, $paymentMethod, $paymentAmount)
        {
            $this->bookingId = $bookingId;
            $this->customerId = $customerId;
            $this->customerName = $customerName;
            $this->customerAddress = $customerAddress;
            $this->customerPhoneNumber = $customerPhoneNumber;
            $this->workerId = $workerId;
            $this->workerName = $workerName;
            $this->workerAddress = $workerAddress;
            $this->workerPhoneNumber = $workerPhoneNumber;
            $this->createdDate = $createdDate;
            $this->startDate = $startDate;
            $this->endDate = $endDate;
            $this->workerType = $workerType;
            $this->status = $status;
            $this->paymentMethod = $paymentMethod;
            $this->paymentAmount = $paymentAmount;
        }

        public function getBookingId()
        {
            return $this->bookingId;
        }

        public function getCustomerId()
        {
            return $this->customerId;
        }

        public function getCustomerName()
        {
            return $this->customerName;
        }

        public function getCustomerAddress()
        {
            return $this->customerAddress;
        }

        public function getCustomerPhoneNumber()
        {
            return $this->customerPhoneNumber;
        }

        public function getWorkerId()
        {
            return $this->workerId;
        }

        public function getWorkerName()
        {
            return $this->workerName;
        }

        public function getWorkerAddress()
        {
            return $this->workerAddress;
        }

        public function getWorkerPhoneNumber()
        {
            return $this->workerPhoneNumber;
        }

        public function getCreatedDate()
        {
            return $this->createdDate;
        }

        public function getStartDate()
        {
            return $this->startDate;
        }

        public function getEndDate()
        {
            return $this->endDate;
        }

        public function getWorkerType()
        {
            return $this->workerType;
        }

        public function getStatus()
        {
            return $this->status;
        }

        public function getPaymentMethod()
        {
            return $this->paymentMethod;
        }

        public function getPaymentAmount()
        {
            return $this->paymentAmount;
        }

        public function setCreatedDate($createdDate)
        {
            $this->createdDate = $createdDate;
        }

        public function setStartDate($startDate)
        {
            $this->startDate = $startDate;
        }

        public function setEndDate($endDate)
        {
            $this->endDate = $endDate;
        }

        public function setWorkerType($workerType)
        {
            $this->workerType = $workerType;
        }

        public function setStatus($status)
        {
            $this->status = $status;
        }

        public function setPaymentMethod($paymentMethod)
        {
            $this->paymentMethod = $paymentMethod;
        }

        public function setCustomerAddress($customerAddress)
        {
            $this->customerAddress = $customerAddress;
        }

        public function setCustomerPhoneNumber($customerPhoneNumber)
        {
            $this->customerPhoneNumber = $customerPhoneNumber;
        }

        public function setWorkerAddress($workerAddress)
        {
            $this->workerAddress = $workerAddress;
        }

        public function setWorkerPhoneNumber($workerPhoneNumber)
        {
            $this->workerPhoneNumber = $workerPhoneNumber;
        }

        public function setPaymentAmount($paymentAmount)
        {
            $this->paymentAmount = $paymentAmount;
        }
    }
    ?>
