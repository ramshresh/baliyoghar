<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/8/16
 * Time: 5:59 AM
 */
// echo ' <tr id="row'.$person_id.'_'.$participation[6].'">';
echo ' <td align="center">' . ($i + 1) . '</td>';
echo ' <td align="left"><a href="../Event/viewEvent?id=' . $participation[6] . '">' . $participation[0] . '<a></td>';
echo '<td align="left">' . $participation[1] . '</td>';
echo '<td align="left">' . $participation[8] . '</td>';
echo '<td align="left">' . $participation[10] . '</td>';
echo '<td align="left">' . $participation[2] . '</td>';

echo '<td align="left">' . $participation[3] . '</td>';
echo '<td align="left">' . $participation[4] . '</td>';
echo '<td align="left">' . $participation[5] . '</td>';

echo '<td data-name= data-label=View align="center">
                                <a data-i="' . $i . '" data-participated_in_id="' . $participation[7] . '" data-event_id="' . $participation[6] . '" class= "text-error handcursor" id="editparticipation_' . $person_id . '" >edit</a>  
                                  &nbsp; | &nbsp;
                                <a data-i="' . $i . '" data-participated_in_id="' . $participation[7] . '" data-event_id="' . $participation[6] . '" class= "text-error handcursor" id="removeevent_' . $person_id . '">unselect</a>
                            </td>';

if (isset($action) && $action !== null) {
    //  echo '<td  align="left"><a id="unselectcandidate_'.$person_id.'_'.$participation[6].'" class="text-error handcursor">unselect</a></td>';
    echo '<td  align="left"><a class= "text-error handcursor" id="unselectcandidate_' . $participation[7] . '">unselect</a></td>';
}
?>