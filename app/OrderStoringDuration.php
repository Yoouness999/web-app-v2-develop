<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class OrderStoringDuration extends Model {

	/**
     * Compare 2 storing durations
     *
     * @param $storingDuration OrderStoringDuration
     * @return boolean
     */
	public function isBiggerThan($storingDuration = null) {
	    return $this->month > $storingDuration->month;
	}

    /**
     * Get start commitment period
     *
     * @param $endCommitmentPeriod
     * @return Datetime
     * @internal param Datetime $endCommimentPeriod
     */
	public function getStartCommitmentPeriod($endCommitmentPeriod) {

        if (!$this->month) {
            return null;
        }

		$startCommitmentPeriod = clone($endCommitmentPeriod);
        $startCommitmentPeriod->modify('-'.$this->month.' month');
		return $startCommitmentPeriod;
	}

	/**
     * Get end commitment period
     *
     * @param $startCommimentPeriod Datetime
     * @return Datetime
     */
	public function getEndCommitmentPeriod($startCommimentPeriod = null) {
		if (!$startCommimentPeriod) {
			$startCommimentPeriod = new Datetime();
		}

		$endCommimentPeriod = clone($startCommimentPeriod);

        if ($this->month) {
            $endCommimentPeriod->modify('+'.$this->month.' month');
            return $endCommimentPeriod;
        }

        return null;
	}
}
