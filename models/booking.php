<?php
    class Booking{
        public $bookingId;
        public $customerId;
        public $customerName;
        public $workerId;
        public $workerName;
        public $createdDate;
        public $startDate;
        public $endDate;
        public $workerType;
        public $status;

        public function __construct($bookingId, $customerId, $customerName, $workerId, $workerName,$createdDate, $startDate, $endDate, $workerType, $status)
        {
            $this->bookingId = $bookingId;
            $this->customerId = $customerId;
            $this->customerName = $customerName;
            $this->workerId = $workerId;
            $this->workerName = $workerName;
            $this->createdDate = $createdDate;
            $this->startDate = $startDate;
            $this->endDate = $endDate;
            $this->workerType = $workerType;
            $this->status = $status;
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

        public function getWorkerId()
        {
            return $this->workerId;
        }

        public function getWorkerName()
        {
            return $this->workerName;
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


    }
    ?>
