<?php
class Model_BillionRewards extends Model_table {
	var $table= "jos_xrewards";
	function init(){
		parent::init();
		$this->hasOne('Distributor','distributor_id');
		$this->addField('reward1')->defaultValue('0000-00-00 00:00:00');
		$this->addField('reward2')->defaultValue('0000-00-00 00:00:00');
		$this->addField('reward3')->defaultValue('0000-00-00 00:00:00');
		$this->addField('reward4')->defaultValue('0000-00-00 00:00:00');
		$this->addField('reward5')->defaultValue('0000-00-00 00:00:00');
		$this->addField('reward6')->defaultValue('0000-00-00 00:00:00');
		$this->addField('reward7')->defaultValue('0000-00-00 00:00:00');
		$this->addField('reward8')->defaultValue('0000-00-00 00:00:00');

		$this->addExpression("Pair_10")->set('
				IF(
					reward1="0000-00-00 00:00:00",
						"Running",
						concat("Achived on ",reward1)
				)
			');

		$this->addExpression("Pair_25")->set('
				IF(
					reward2="0000-00-00 00:00:00",
						"Running",
						concat("Achived on ",reward2)
				)
			');

		$this->addExpression("Pair_50")->set('
				IF(
					reward3="0000-00-00 00:00:00",
						"Running",
						concat("Achived on ",reward3)
				)
			');

		$this->addExpression("Pair_100")->set('
				IF(
					reward4="0000-00-00 00:00:00",
						"Running",
						concat("Achived on ",reward4)
				)
			');

		$this->addExpression("Pair_300")->set('
				IF(
					reward5="0000-00-00 00:00:00",
						"Running",
						concat("Achived on ",reward5)
				)
			');

		$this->addExpression("Pair_4000")->set('
				IF(
					reward6="0000-00-00 00:00:00",
						"Running",
						concat("Achived on ",reward6)
				)
			');

		$this->addExpression("Pair_10000")->set('
				IF(
					reward7="0000-00-00 00:00:00",
						"Running",
						concat("Achived on ",reward7)
				)
			');

		$this->addExpression("Pair_20000")->set('
				IF(
					reward8="0000-00-00 00:00:00",
						"Running",
						concat("Achived on ",reward8)
				)
			');

	}
}