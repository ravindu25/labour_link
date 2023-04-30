<?php
    class Feedback{
        public $feedbackToken;
        public $bookingId;
        public $customerId;
        public $customerName;
        public $workerId;
        public $workerName;
        public $createdTimestamp;
        public $ratingPunctuality;
        public $ratingEfficiency;
        public $ratingProfessionalism;
        public $writtenFeedback;
        public $extraObservations;


        public function __construct($feedbackToken, $bookingId, $customerId, $customerName, $workerId, $workerName, $createdTimestamp, $ratingPunctuality, $ratingEfficiency, $ratingProfessionalism, $writtenFeedback, $extraObservations)
        {
            $this->feedbackToken = $feedbackToken;
            $this->bookingId = $bookingId;
            $this->customerId = $customerId;
            $this->customerName = $customerName;
            $this->workerId = $workerId;
            $this->workerName = $workerName;
            $this->createdTimestamp = $createdTimestamp;
            $this->ratingPunctuality = $ratingPunctuality;
            $this->ratingEfficiency = $ratingEfficiency;
            $this->ratingProfessionalism = $ratingProfessionalism;
            $this->writtenFeedback = $writtenFeedback;
            $this->extraObservations = $extraObservations;
        }

        public function getFeedbackToken()
        {
            return $this->feedbackToken;
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

        public function getCreatedTimestamp()
        {
            return $this->createdTimestamp;
        }

        public function getRatingPunctuality()
        {
            return $this->ratingPunctuality;
        }

        public function getRatingEfficiency()
        {
            return $this->ratingEfficiency;
        }

        public function getRatingProfessionalism()
        {
            return $this->ratingProfessionalism;
        }

        public function getWrittenFeedback()
        {
            return $this->writtenFeedback;
        }

        public function getExtraObservations()
        {
            return $this->extraObservations;
        }

        public function setCreatedTimestamp($createdTimestamp)
        {
            $this->createdTimestamp = $createdTimestamp;
        }

        public function setRatingPunctuality($ratingPunctuality)
        {
            $this->ratingPunctuality = $ratingPunctuality;
        }

        public function setRatingEfficiency($ratingEfficiency)
        {
            $this->ratingEfficiency = $ratingEfficiency;
        }

        public function setRatingProfessionalism($ratingProfessionalism)
        {
            $this->ratingProfessionalism = $ratingProfessionalism;
        }

        public function setWrittenFeedback($writtenFeedback)
        {
            $this->writtenFeedback = $writtenFeedback;
        }

        public function setExtraObservations($extraObservations)
        {
            $this->extraObservations = $extraObservations;
        }
    }
    ?>
