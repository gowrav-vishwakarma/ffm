<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class xSessionClosing extends DataMapper {

    var $table = 'xclosingsession';
    var $has_one = array(
        'distributor' => array(
            'class' => 'distributor',
            'join_other_as' => 'distributor',
            'join_table' => 'jos_xclosingsession',
            'other_field' => 'sessionclosings'
        )
    );

    function setSessionBinary() {
        global $com_params;
        $c = new xConfig('binary_income');
        $tailPV = $c->getkey('TailPV');
        if($tailPV=="")
            $tailPV="0";
        $this->db->query("UPDATE jos_xtreedetails SET temp1=0, SessionPairPV=0, SessionPairBV=0, SessionPairRP=0");
        $queryA = "UPDATE jos_xtreedetails
                    LEFT OUTER JOIN jos_xlegs AS `left` ON jos_xtreedetails.id = `left`.distributor_id
                    LEFT OUTER JOIN jos_xlegs AS `right` ON jos_xtreedetails.id = `right`.distributor_id
                    INNER JOIN jos_xkitmaster AS `k` ON jos_xtreedetails.kit_id = k.id
				SET
				jos_xtreedetails.temp1=IF(`left`.SessionPV <> `right`.SessionPV,
					/*      TRUE PORTION  */
						IF(  IF ( `left`.SessionPV  < `right`.SessionPV, `left`.SessionPV, `right`.SessionPV) < k.Capping,
							 IF ( `left`.SessionPV  < `right`.SessionPV, `left`.SessionPV, `right`.SessionPV), /* True*/
							k.Capping /*False*/
						),
					/*      FALSE PORTION       */
						IF(  IF ( `left`.SessionPV-$tailPV  < `right`.SessionPV-$tailPV, `left`.SessionPV-$tailPV, `right`.SessionPV-$tailPV) < k.Capping,
							 IF ( `left`.SessionPV-$tailPV  < `right`.SessionPV-$tailPV, `left`.SessionPV-$tailPV, `right`.SessionPV-$tailPV), /* True */
							k.Capping /* False */
						)
					)
				WHERE
				`left`.SessionPV <>0 AND `right`.SessionPV<>0
                                AND
                                `left`.Leg = 'A' AND
                                `right`.Leg = 'B'";
        $this->db->query($queryA);
        $this->db->query("UPDATE jos_xtreedetails SET SessionPairPV = temp1, MidSessionPairPV = MidSessionPairPV + temp1, ClosingPairPV=ClosingPairPV+temp1, TotalPairPV=TotalPairPV+temp1");
        $this->db->query("UPDATE jos_xtreedetails SET temp1=0");

        $this->saveSession(getNow());

        $queryA = "UPDATE jos_xtreedetails
                    LEFT OUTER JOIN jos_xlegs AS `left` ON jos_xtreedetails.id = `left`.distributor_id
                    LEFT OUTER JOIN jos_xlegs AS `right` ON jos_xtreedetails.id = `right`.distributor_id
                    INNER JOIN jos_xkitmaster AS `k` ON jos_xtreedetails.kit_id = k.id
				SET
				jos_xtreedetails.temp1=IF(`left`.SessionPV <> `right`.SessionPV,
                                                        IF( `left`.SessionPV < `right`.SessionPV , `left`.SessionPV, `right`.SessionPV),
                                        /*	 else 		*/
                                                        `left`.SessionPV-$tailPV
                                        ),
                                `left`.SessionBV=0,
                                `left`.SessionRP=0,
                                `left`.SessionGreenCount=0,
                                `left`.SessionCount=0,
                                `left`.SessionIntros=0,
                                
                                `right`.SessionBV=0,
                                `right`.SessionRP=0,
                                `right`.SessionGreenCount=0,
                                `right`.SessionCount=0,
                                `right`.SessionIntros=0
        
				WHERE
				`left`.SessionPV <> 0 AND `right`.SessionPV<> 0
                                AND
                                `left`.Leg = 'A' AND
                                `right`.Leg = 'B'";
        $this->db->query($queryA);

        $queryA = "UPDATE jos_xtreedetails
                    LEFT OUTER JOIN jos_xlegs AS `left` ON jos_xtreedetails.id = `left`.distributor_id
                    LEFT OUTER JOIN jos_xlegs AS `right` ON jos_xtreedetails.id = `right`.distributor_id
				SET
				`left`.SessionPV=`left`.SessionPV - jos_xtreedetails.temp1,
                                `right`.SessionPV=`right`.SessionPV - jos_xtreedetails.temp1
				WHERE
				`left`.SessionPV <> 0 AND `right`.SessionPV<> 0
                                AND
                                `left`.Leg = 'A' AND
                                `right`.Leg = 'B'";

        $this->db->query($queryA);
        $maxJoining = $this->db->query("select max(SessionNewJoining) as maxJoining from jos_xtreedetails")->row()->maxJoining;
        $maxJoining++;
        $this->db->query("UPDATE jos_xtreedetails SET SessionIntros=0, SessionGreenCount=0, SessionCount=0");

        $data=array('SessionNewJoining'=>$maxJoining);
        $this->db->where("SessionNewJoining = 0");
        $this->db->update('jos_xtreedetails',$data);

        $q="UPDATE jos_xlegs SET SessionIntros=0, SessionGreenCount=0, SessionCount=0";
        $this->db->query($q);
       
    }

    function saveSession($session='Session001'){
        $query="
            SELECT 0,
                    id,
                    SUM(LeftSessionPV),
                    SUM(RightSessionPV),
                    SessionPairPV,
                    SessionPairBV,
                    SUM(LeftSessionRP),
                    SUM(RightSessionRP),
                    SessionPairRP,
                    SessionIntros,
                    SessionGreenCount,
                    SUM(LeftSessionCount),
                    SUM(RightSessionCount),
                    TotalGreenCount,
                    TotalCount,
                    '$session'
                    FROM
                    (SELECT
                                    0,
                                    jos_xtreedetails.id id,
                                    `left`.SessionPV as LeftSessionPV,
                                    0 as RightSessionPV,
                                    jos_xtreedetails.SessionPairPV,
                                    jos_xtreedetails.SessionPairBV,
                                    `left`.SessionRP LeftSessionRP,
                                    0 RightSessionRP,
                                    jos_xtreedetails.SessionPairRP,
                                    jos_xtreedetails.SessionIntros,
                                    jos_xtreedetails.SessionGreenCount,
                                    `left`.SessionCount LeftSessionCount,
                                    0 RightSessionCount,
                                    jos_xtreedetails.TotalGreenCount,
                                    jos_xtreedetails.TotalCount,
                                    '$session'
                                    FROM
                                    jos_xtreedetails
                                    LEFT JOIN jos_xlegs AS `left` ON jos_xtreedetails.id = `left`.distributor_id
                                    WHERE
                                    (`left`.Leg = 'A')

                    UNION

                    SELECT
                                    0,
                                    jos_xtreedetails.id,
                                    0 LeftSessionPV,
                                    `right`.SessionPV RightSessionPV,
                                    jos_xtreedetails.SessionPairPV,
                                    jos_xtreedetails.SessionPairBV,
                                    0 LeftSessionRP,
                                    `right`.SessionRP RightSessionRP,
                                    jos_xtreedetails.SessionPairRP,
                                    jos_xtreedetails.SessionIntros,
                                    jos_xtreedetails.SessionGreenCount,
                                    0 LeftSessionCount,
                                    `right`.SessionCount RightSessionCount,
                                    jos_xtreedetails.TotalGreenCount,
                                    jos_xtreedetails.TotalCount,
                                    '$session'
                                    FROM
                                    jos_xtreedetails
                                    LEFT JOIN jos_xlegs AS `right` ON jos_xtreedetails.id = `right`.distributor_id
                                    WHERE
                                    (`right`.Leg = 'B')
                    ) groupeddata
                    group by id
            ";
        $query="
                INSERT INTO jos_xclosingsession ($query);
            ";
        $this->db->query($query);
    }

}

?>