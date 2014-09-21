<?php

namespace View;

Class DateTime{
	private $printDay;
	private $printMonth;
	private $todaysDate;
	private $year;
	private $todaysTime;
	
public function printDateTime(){
$day = date("N");
$arrDays = Array("Måndag","Tisdag","Onsdag","Torsdag","Fredag","Lördag","Söndag",);
$this->printDay = $arrDays[$day-1];

$month = date("m");
$arrMonths= Array("januari","februari","mars","april","maj","juni","juli","augusti","september","oktober","november","december");
$this->printMonth = $arrMonths[($month-1)]; 

$this->todaysDate = date("d");
$this->year = date("Y");
$this->todaysTime = date("H:i:s");
}

public function getTime(){
		$this->printDateTime();
	 $printTime = "<p>".$this->printDay." den ".$this->todaysDate." ".$this->printMonth." ".$this->year.", Klockan är: ".$this->todaysTime."</p>";
	return $printTime;
	}
}
