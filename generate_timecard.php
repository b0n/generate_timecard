<?php
mb_internal_encoding('UTF-8');

$hm = new hm();
$body = "* " . $hm->pair() . PHP_EOL;
while($pair = $hm->pair()) {
	$body .= "* {$pair}" . PHP_EOL;
}

$body2 = <<<EOD
▼本日の業務内容
[請負]
[実験]
[社内]
▼明日の業務内容
▼その日行った業務内容
▼次回業務
▼提出した見積り
▼返事待ち、資料待ち
▼訪問先で知り得た情報、指摘された内容
▼今日の自身の気付きと学び

EOD;
$body = $body2 . PHP_EOL . $body;

mb_language('ja');
require_once "set.php";
mb_send_mail($to, $subject, $body, $header, $option);

class hm {

	private $start_hour = '2012/09/14 00:00';
	private $end_hour = '2012/09/14 24:00';
	private $date;
	private $end;

	public function __construct() {
		$this->date = new DateTime($this->start_hour);
		$this->end = new DateTime($this->end_hour);
	}

	public function pair() {
		$cur = $this->cur();
		$next = $this->next();
		if (!$next) return false;

		return $cur . ' - ' . $next;
	}

	public function cur() {
		return $this->date->format('H:i');
	}

	public function next() {
		if ($this->date >= $this->end)
			return false;

		$this->date->add(new DateInterval('PT20M'));
		return $this->cur();
	}

}
